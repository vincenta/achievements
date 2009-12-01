<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 */

require 'forms/achievement_form.php';

/**
 * Achievement controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class AchievementsController extends ApplicationController {

    /**
     * Index action : redirect to home page
     * @access public
     * @return void
     */
    public function index() {
        $this->redirect_to_home();
    }

    /**
     * Create action : create and generate a new achievement
     * @access public
     * @return void
     */
    public function create() {
        $this->_open_form();

        if ($this->request->is_post()) {
            if (!$this->form->is_valid($this->params['achievement'])) {
                $this->flash['error'] = __('Fail to create achievement : Check data.');
                return;
            }
            $this->achievement = new Achievement($this->form->cleaned_data);
            $this->achievement->creator_id = $this->session['user']->id;
            if (!($this->achievement->save())) {
                $this->form->errors = $this->achievement->errors;
                $this->flash['error'] = __('Fail to create achievement : Check data.');
                return;
            }

            $this->_generate($this->achievement);
            $this->redirect_to_home();
        }
    }

    /**
     * Update action : update and regenerate a locked achievement
     * (unlocked and expired achievements can't be modified)
     * @access public
     * @return void
     */
    public function update() {
        if (!$this->_load_achievement()) {
            $this->redirect_to_home();
            return;
        }

        if ((!$this->achievement->is_locked()) || (!$this->session['user']->is_creator_of($this->achievement))) {
            $this->flash['error'] = __('You can\'t update this achievement.');
            $this->redirect_to_home();
            return;
        }

        $this->_open_form();

        if ($this->request->is_post()) {

            if (!$this->form->is_valid($this->params['achievement'])) {
                $this->flash['error'] = __('Fail to update achievement : Check data.');
                return;
            }
            $this->achievement->populate($this->form->cleaned_data);
            if (!($this->achievement->save())) {
                $this->form->errors = $this->achievement->errors;
                $this->flash['error'] = __('Fail to update achievement : Check data.');
                return;
            }

            $this->_generate($this->achievement);
            $this->redirect_to_home();
        }
    }

    /**
     * Set_winner action : set the winner of an achievement
     * (the achievement state changes to unlocked)
     * @access public
     * @return void
     */
    public function set_winner() {
        if (!$this->_load_achievement()) {
            $this->redirect_to_home();
            return;
        }

        if ((!$this->achievement->is_locked()) || (!$this->session['user']->is_creator_of($this->achievement))) {
            $this->flash['error'] = __('You can\'t modify this achievement.');
            $this->redirect_to_home();
            return;
        }

        $this->_open_setWinnerForm();

        if ($this->request->is_post()) {

            if (!$this->form->is_valid($this->params['achievement'])) {
                $this->flash['error'] = __('Fail to set the winner : Check data.');
                return;
            }
            $this->achievement->state = 'unlocked';
            $this->achievement->winner_id = $this->form->cleaned_data['winner_id'];
            if (!($this->achievement->save())) {
                $this->form->errors = $this->achievement->errors;
                $this->flash['error'] = __('Fail to set the winner : Check data.');
                return;
            }

            $this->_generate($this->achievement);
            $this->redirect_to_home();
        }
    }


    /**
     * Set_expired action : update achievement state to expired
     * (unlocked and expired achievements can't be modified)
     * @access public
     * @return void
     */
    public function set_expired() {
        if (!$this->_load_achievement()) {
            $this->redirect_to_home();
            return;
        }

        if ((!$this->achievement->is_locked()) || (!$this->session['user']->is_creator_of($this->achievement))) {
            $this->flash['error'] = __('You can\'t modify this achievement.');
            $this->redirect_to_home();
            return;
        }

        $this->achievement->state = 'expired';
        if (!($this->achievement->save())) {
            $this->form->errors = $this->achievement->errors;
            $this->flash['error'] = __('Fail to update achievement : Check data.');
            return;
        }

        $this->_generate($this->achievement);
        $this->redirect_to_home();
    }

    /**
     * Delete action : delete a locked achievement
     * (unlocked and expired achievements can't be modified)
     * @access public
     * @return void
     */
    public function delete() {
        if (!$this->_load_achievement()) {
            $this->redirect_to_home();
            return;
        }

        if ((!$this->achievement->is_locked()) || (!$this->session['user']->is_creator_of($this->achievement))) {
            $this->flash['error'] = __('You can\'t delete this achievement.');
            $this->redirect_to_home();
            return;
        }

        $this->achievement->delete();
        $path = achievement_path($this->achievement);
        unlink($path);
        $this->redirect_to_home();
    }

    /**
     * Preview action : generate an achievement preview
     * @access public
     * @return void
     */
    public function preview() {
        $this->layout = '';

        $this->form = new AchievementCreateForm();
        if (!$this->form->is_valid($this->params)) {
            //FIXME: error management ? render an error image ?
            $this->flash['error'] = __('Fail to create achievement : Check data.');
            return;
        }
        $achievement = new Achievement($this->form->cleaned_data);
        $image = $achievement->generate();

        header('Content-Type: image/png');
        echo $image->getImage();
    }



    /**
     * include required js and css and create the achievement form
     * @access public
     * @return void
     */
    protected function _open_form() {
        $this->add_extra_css('jquery.imageSelector.css');
        $this->add_extra_js('jquery.imageSelector.js');
        $this->form = new AchievementCreateForm();
        if (isset($this->achievement)) {
            $this->form->set_initial_values(array(
                'title' => $this->achievement->title,
                'description' => $this->achievement->description,
                'reward' => $this->achievement->reward,
                'image_id' => $this->achievement->image_id
            ));
        }
    }

    /**
     * include required js and css and create the form used to set the winner
     * @access public
     * @return void
     */
    protected function _open_setWinnerForm() {
        $this->add_extra_css('jquery.imageSelector.css');
        $this->add_extra_js('jquery.imageSelector.js');
        $this->form = new SetWinnerForm();
        if (isset($this->achievement)) {
            $this->form->set_initial_values(array(
                'winner_id' => $this->achievement->winner_id
            ));
        }
    }

    /**
     * load the achievement given in parameters (id of achievement_id). Return false in case of error
     * @access public
     * @return boolean
     */
    protected function _load_achievement() {
        try {
            $achievement_id = $this->params['id']!='' ? $this->params['id'] : $this->params['achievement_id'];
            $this->achievement = Achievement::$objects->get($achievement_id);
        } catch (SRecordNotFound $e) {
            $this->flash['error'] = __('Can\'t find this achievement.');
            return false;
        }
        return true;
    }

    /**
     * generate the achievement and put it in the achievements folder
     * @access public
     * @return void
     */
    protected function _generate($achievement) {
        $path = achievement_path($achievement);
        generate_achievement($achievement, $path);
    }
}
