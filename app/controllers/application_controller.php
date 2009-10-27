<?php

class ApplicationController extends SActionController {
    protected $layout = 'main';

    public function initialize() {
        $this->before_filters->append('is_authorized');
        $this->extra = new ArrayObject();
        $this->extra['css'] = new ArrayObject();
        $this->extra['js'] = new ArrayObject();
    }

    public function add_extra_css($filename) {
        $this->extra['css'][] = $filename;
    }

    public function add_extra_js($filename) {
        $this->extra['js'][] = $filename;
    }

    protected function render_json($array) {
        $this->render_text(json_encode($array));
    }

    public function logout() {
        unset($this->session['user']);
        $this->redirect_to_home();
    }

    protected function redirect_to_home() {
        $this->redirect_to(array('controller' => 'home', 'action' => 'index'));
    }

    protected function redirect_to_login($return_to=false) {
        if ($return_to)
            $this->redirect_to(array('controller' => 'login', 'action' => 'login', 'return_to' => urlencode($this->request->request_uri())));
        else
            $this->redirect_to(array('controller' => 'login', 'action' => 'login'));
    }

    protected function access_denied() {
        $this->redirect_to('/403.html');
        return;
    }

    protected function is_authorized() {
        if ($this->controller_name()=='login')
            return true;
        //else
        if (($this->controller_name()=='users') && ($this->action_name()=='register'))
            return true;
        //else
        if ($this->authenticate())
            return true;
        //else
        $this->flash['notice'] = __('You\'re not authentified. Please, login.');
        if ($this->request->is_xhr())
            $this->render_json(array('error' => $this->flash['notice']));
        else
            $this->redirect_to_login(true);
        return false;
    }

    protected function authenticate() {
        return isset($this->session['user']);
    }

}

