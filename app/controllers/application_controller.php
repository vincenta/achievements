<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 */

include_once 'Gravatar/gravatar.php';
include_once 'Achievement/achievement.php';
include_once 'resources/achievements_theme.php';
include_once 'models/image.php';

/**
 * Standard Application controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class ApplicationController extends SActionController {
    protected $layout = 'main';

    /**
     * Controller initialization
     * @access public
     * @return void
     */
    public function initialize() {
        $this->before_filters->append('is_authorized');
        $this->extra = new ArrayObject();
        $this->extra['css'] = new ArrayObject();
        $this->extra['js'] = new ArrayObject();
    }

    /**
     * add a new css file to include in the layout
     * @param string $filename   the css file name
     * @access public
     * @return void
     */
    public function add_extra_css($filename) {
        $this->extra['css'][] = $filename;
    }

    /**
     * add a new js file to include in the layout
     * @param string $filename   the javascript file name
     * @access public
     * @return void
     */
    public function add_extra_js($filename) {
        $this->extra['js'][] = $filename;
    }

    /**
     * render a json array to the output
     * @param array $array   the array to encode in json and render
     * @access protected
     * @return void
     */
    protected function render_json($array) {
        $this->render_text(json_encode($array));
    }

    /**
     * render a json array to the output
     * @param array $array   the array to encode in json and render
     * @access protected
     * @return void
     */
    protected function render_image($image) {
        $this->add_variables_to_assigns();
        $this->response->headers['Content-Type'] = 'image/png';
        $this->render_text($image->__toString());
    }

    /**
     * logout the current logged user
     * @access public
     * @return void
     */
    public function logout() {
        if ($this->session['psession']) {
            $this->session['psession']->force_expire();
            unset($this->session['psession']);
        }
        unset($this->session['user']);
        $this->redirect_to(home_url());
    }

    /**
     * http redirect to the application login page if a page is given, user
     * will redirected to this page after login
     * @access protected
     * @return void
     */
    protected function redirect_to_login($return_to=false) {
        if ($return_to)
            $this->redirect_to(array('controller' => 'login', 'action' => 'login', 'return_to' => urlencode($this->request->request_uri())));
        else
            $this->redirect_to(array('controller' => 'login', 'action' => 'login'));
    }

    /**
     * http redirect to the 404 error page
     * @access protected
     * @return void
     */
    protected function file_not_found() {
        $this->redirect_to('/404.html');
        return;
    }

    /**
     * http redirect to the 403 error page
     * @access protected
     * @return void
     */
    protected function access_denied() {
        $this->redirect_to('/403.html');
        return;
    }

    /**
     * true if user is authorized to see the current page
     * @access protected
     * @return boolean
     */
    protected function is_authorized() {
        $authentified = $this->authenticate();
        if (($this->controller_name()=='login') || ($this->action_name()=='logout'))
            return true;
        //else
        if ($this->controller_name()=='home')
            return true;
        //else
        if (($this->controller_name()=='users') && ($this->action_name()=='register'))
            return true;
        //else
        if (($this->controller_name()=='achievement') && ($this->action_name()=='generate'))
            return true;
        //else
        if ($authentified)
            return true;
        //else
        $this->flash['notice'] = __('You\'re not authentified. Please, login.');
        if ($this->request->is_xhr())
            $this->render_json(array('error' => $this->flash['notice']));
        else
            $this->redirect_to_login(true);
        return false;
    }

    /**
     * true if user is logged in
     * @access protected
     * @return boolean
     */
    protected function authenticate() {
        if (isset($this->session['user']))
            return true;
        //else
        $psession = Psession::retrieve();
        if ($psession) {
            $user = $psession->user->target();
            $this->session['psession'] = $psession;
            $this->session['user'] = $user;
            return true;
        }
        return false;
    }

}

