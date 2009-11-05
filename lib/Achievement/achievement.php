<?php

class AchievementPix {
    protected $_width=772;
    protected $_height=72;
    protected $_title;
    protected $_description;
    protected $_state;
    protected $_pix;

    public function __construct($title, $description, $state='locked', $pix) {
        $this->_title = $title;
        $this->_description = $description;
        $this->_state = (in_array($state,array('unlocked','locked','expired')) ? $state : 'locked');
        $this->_pix = $pix;
    }

    public function __get($var) {
        $attribute = "_{var}";
        return $this->$attribute;
    }

    public function getImage($format='png') {
        $image = $this->_buildImage();
        $image->setImageFormat($format);
        return $image;
    }

    public function saveImage($filename) {
        $image = $this->_buildImage();
        $image->writeImage($filename);
        $image->clear();
        $image->destroy();
    }

    protected function _buildImage () {
    }
}
