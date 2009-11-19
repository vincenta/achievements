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
     * Create action : create and generate a new achievement
     * @access public
     * @return void
     */
    public function create() {
        $this->add_extra_css('jquery.imageSelector.css');
        $this->add_extra_js('jquery.imageSelector.js');
        $this->form = new AchievementCreateForm();

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
//    public function update() {
//
//        //FIXME: do things here
//
//        $this->_generate($this->achievement);
//        $this->redirect_to_home()
//    }

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

        $image = new AchievementPix($title, $description, $reward, $state, $image);

        header('Content-Type: image/png');
        echo $image->getImage();
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
