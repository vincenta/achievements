<?php

class HomeController extends ApplicationController {

    public function index() {
        $this->trophies = Achievement::$objects->all()->filter('winner_id IS NOT NULL and NOT expired')->order_by('-updated_on', 'created_on');
        $this->locked = Achievement::$objects->all()->filter('winner_id IS NULL and NOT expired')->order_by('-updated_on', 'created_on');
        $this->expired = Achievement::$objects->all()->filter('expired')->order_by('-updated_on', 'created_on');
    }

}
