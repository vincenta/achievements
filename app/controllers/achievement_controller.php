<?php

class AchievementController extends ApplicationController {

    public function generate() {
        $this->layout = '';

        $title       = $this->params['title'];
        $description = $this->params['description'];
        $reward      = $this->params['reward'];
        $state       = $this->params['state'];
//        $pix         = $this->params['pix'];

        $image = new AchievementPix($title, $description, $reward, $state, $pix);

        header('Content-Type: image/png');
        echo $image->getImage();
    }

}
