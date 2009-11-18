<?php

class AchievementCreateForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('achievement');
        $this->title = new SCharField(array(
            'required' => true,
            'label'    => __('Title')
        ));
        $this->description = new SCharField(array(
            'required' => true,
            'label'    => __('Description')
        ));
        $this->image_id = new SCharField(array( //FIXME: advanced image picker
            'required'  => false,
            'label'     => __('Image')
        ));
        $this->reward = new SCharField(array(
            'required' => true,
            'label'    => __('Reward')
        ));
    }

    protected function clean() {
    }
}

