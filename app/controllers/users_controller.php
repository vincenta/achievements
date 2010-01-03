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
     * Default action : users ranking
     * @access public
     * @return void
     */
    public function index() {
        $this->users = new ArrayObject();
        $results = User::$objects->get_ranking();
        foreach ($results as $result) {
            $this->users[] = new User($result);
        }
    }

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

            $mailer = new ApplicationMailer();
            $mailer->send_signup_notification($this->user);

            $this->redirect_to(home_url());
        }
    }

    /**
     * all_json action : return the list of all users useable to generate achievements in the pix folder
     * @access public
     * @return void
     */
    public function all_json() {
        $this->layout = '';

        $all = array();
        foreach (User::$objects->all() as $user) {
            $all[] = array(
                'image_id' => $user->id,
                'title'    => $user->__toString(),
                'url'      => $user->get_gravatar_url()
            );
        }
        $this->render_json(array(
            'message' => 'ok',
            'count'   => count($all),
            'elements'  => $all
        ));
    }

    /**
     * generate the user image, put it in the users folder and return it
     * @access public
     * @return void
     */
    public function generate_image() {
        $filename = $this->params['filename'];
        $login = basename($filename,'.png');

        $user = User::$objects->get_or_404('login = ?', array($login));
        $path = userImage_path($user);
        $image = generate_userImage($user, $path);

        $this->render_image($image->image);
        $image->destroy();
    }

}
