<?php

require 'forms/login_form.php';

class LoginController extends ApplicationController {

    public function index() {
        if (!isset($this->session['user'])) {
            $this->redirect_to_login();
            return;
        }
        $this->redirect_to_home();
    }

    public function login() {
        $this->form = new LoginForm();
        
        if ($this->request->is_post() ) {
            if ($this->form->is_valid($this->params['user'])) {
                try {
                    $this->user = User::$objects->get('login = ?', 'password = ?',
                        array($this->params['user']['login'], $this->params['user']['password']));
                    $this->session['user'] = $this->user;
                    
                    if (isset($this->params['return_to'])) {
                        $this->redirect_to($this->params['return_to']);
                    } else {
                        $this->redirect_to_home();
                    }
                    
                    $logger = new SLogger('../log/connection.log');
                    $logger->info("{$this->user->login} ({$this->user->id}) connects");

                    return;

                } catch (SRecordNotFound $e) {
                }
            }
            $this->flash['error'] = __('Fail to connect : User not found or password may be wrong.');
            return;
        }
    }

    public function lost() {
        $this->form = new LostLoginForm();

        $req = new SRequestParams();
        if ($this->request->is_post()) {
            if ($this->form->is_valid($this->params['user'])) {
                try {
                    $user = User::$objects->get('email = ?',
                        array($this->params['user']['email']));

                    //FIXME mail a password reminder for user
            
                    $logger = new SLogger('../log/account.log');
                    $logger->info("{$user->login} ({$user->id}) password reminder sent to &lt;{$user->email}&gt;");

                    $this->flash['notice'] = __('Password reminder has been sent to you by email');
                    $this->redirect_to_login();
                    return;

                } catch (SRecordNotFound $e) {
                    $this->flash['error'] = __('Email not found');
                    return;
                }
            }
        }
    }
}
