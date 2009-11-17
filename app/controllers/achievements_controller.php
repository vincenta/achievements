<?php

class AchievementsController extends ApplicationController {

    public function create() {
        
    }

    public function generate() {
        $this->layout = '';

        $title       = $this->params['title'];
        $description = $this->params['description'];
        $reward      = $this->params['reward'];
        $state       = $this->params['state'];
//        $pix         = $this->params['pix']; //FIXME: add pix support

        $image = new AchievementPix($title, $description, $reward, $state, $pix);

        header('Content-Type: image/png');
        echo $image->getImage();
    }

}
