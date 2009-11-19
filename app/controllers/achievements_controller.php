<?php

require 'forms/achievement_form.php';

class AchievementsController extends ApplicationController {

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

//    public function update() {
//
//        //FIXME: do things here
//
//        $this->_generate($this->achievement);
//        $this->redirect_to_home()
//    }

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



    protected function _generate($achievement) {
        $path = achievement_path($achievement);
        generate_achievement($achievement, $path);
    }
}
