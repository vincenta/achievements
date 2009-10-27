<?php

class UserCreateForm extends SForm {

    public function __construct (array $data = null, array $files = null) {
        parent::__construct($data, $files);
        
        $this->set_prefix('account');
        $this->login = new SCharField(array(
            'required' => true,
            'label'    => __('Login')
        ));
        $this->password = new SCharField(array(
            'input' => 'SPasswordInput',
            'required' => true,
            'label'    => __('Password')
        ));
        $this->password_confirmation = new SCharField(array(
            'input' => 'SPasswordInput',
            'required' => true,
            'label'    => __('Password confirmation')
        ));
        $this->email = new SEmailField(array(
            'required' => true,
            'label'    => __('Email')
        ));
    }

    protected function clean() {
        try {
            if ($this->cleaned_data['password']!==$this->cleaned_data['password_confirmation'])
                throw new SValidationError(__('Password confirmation must be identical to password'), array(), $value);

        } catch (SValidationError $e) {
            $this->errors['password_confirmation'] = _f($e->get_message(), $e->get_args());
            $this->cleaned_data[$name] = $e->get_cleaned_value();
        }
    }
}

