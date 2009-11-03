<?php

class HomeController extends ApplicationController {

    public function index() {
        $this->trophies = Achievement::$objects->all()->filter('state = ?',array('unlocked'))->order_by('-updated_on', 'created_on');
        $this->locked = Achievement::$objects->all()->filter('state = ?',array('locked'))->order_by('-updated_on', 'created_on');
        $this->expired = Achievement::$objects->all()->filter('state = ?',array('expired'))->order_by('-updated_on', 'created_on');
    }

}
