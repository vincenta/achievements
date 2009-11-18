<?php

require 'forms/user_form.php';

class UsersController extends ApplicationController {

    public function register() {
        $this->form = new UserCreateForm();

        if ($this->request->is_post()) {
            if (!$this->form->is_valid($this->params['account'])) {
                $this->flash['error'] = __('Fail to create account : Check data.');
                return;
            }
            $this->user = new User($this->form->cleaned_data);
            if (!($this->user->save())) {
                $this->form->errors = new SFormErrors($this->user->errors);
                $this->flash['error'] = __('Fail to create account : Check data.');
                return;
            }

            $logger = new SLogger('../log/account.log');
            $logger->info("{$this->user->login} ({$this->user->id}) signup");

            $this->session['user'] = $this->user;

            //FIXME mail a confirmation to user
            $this->redirect_to_home();
        }
    }

}
