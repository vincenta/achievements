<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 */

require 'forms/login_form.php';

/**
 * Login controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class LoginController extends ApplicationController {

    /**
     * Index action : redirect to home if user is logged in or to login action else
     * @access public
     * @return void
     */
    public function index() {
        if (!isset($this->session['user'])) {
            $this->redirect_to_login();
            return;
        }
        $this->redirect_to_home();
    }

    /**
     * Login action : user login action
     * @access public
     * @return void
     */
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

    /**
     * Lost action : if user has lost his password
     * @access public
     * @return void
     */
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
                    $this->flash['error'] = __('This email address is not registered');
                    $this->form->errors = new SFormErrors(array('email' => __('Email not found')));
                    return;
                }
            }
            $this->flash['error'] = __('You have to give a valid registered email address.');
        }
    }
}
