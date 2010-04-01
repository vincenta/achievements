<?php

class LoginForm extends SForm {
    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('user');
        $this->login = new SField(array(
            'required' => true,
            'label'    => __('Login or Email')
        ));
        $this->password = new SField(array(
            'input' => 'SPasswordInput',
            'required' => true,
            'label'    => __('Password')
        ));
        $this->persistent = new SField(array(
            'input' => 'SCheckboxInput',
            'label'    => __('Keep me logged in')
        ));
    }
}

class LostLoginForm extends SForm {
    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);

        $this->set_prefix('user');
        $this->email = new SEmailField(array(
            'required' => true,
            'label'    => __('Email')
        ));
    }
}
