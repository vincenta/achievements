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
        $this->image_id = new SIntegerField(array(
            'required'  => true,
            'label'     => __('Image'),
            'min_value' => 1,
            'error_messages' => array(
                'invalid'   => __('Image selected seems to be invalid'),
                'min_value' => __('Image selected seems to be invalid'),
                'max_value' => __('Image selected seems to be invalid')
            )
        ));
        $this->reward = new SCharField(array(
            'required' => true,
            'label'    => __('Reward')
        ));
    }

    protected function clean() {
    }
}

