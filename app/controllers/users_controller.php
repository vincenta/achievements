<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 */

require 'forms/user_form.php';

/**
 * User controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class UsersController extends ApplicationController {

    /**
     * Register action : create a new account
     * @access public
     * @return void
     */
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
