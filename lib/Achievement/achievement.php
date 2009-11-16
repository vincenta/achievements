<?php

/**
 * Class used to generate achievement images.
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@aliasource.fr> 
 * @license AGPL 3.0
 */
class AchievementPix {
    protected $_width=772;
    protected $_height=72;
    protected $_title;
    protected $_description;
    protected $_reward;
    protected $_state;
    protected $_pix;
    protected $_bgColor;
    protected $_titleColor;
    protected $_titleFont;
    protected $_titleFontSize=20;
    protected $_textColor;
    protected $_textFont;
    protected $_textFontSize=11;

    /**
     * Constructor 
     * @param string $title        achivement title to draw
     * @param string $description  description to draw
     * @param string $state        'unlocked', 'locked' or 'expired'
     * @param string $pix          path to the achievement pix (64*64px)
     * @access public
     * @return void
     */
    public function __construct($title, $description, $reward='', $state='unlocked', $pix=null) {
        $font_path = dirname(__FILE__).'/fonts';
        $pix_path = dirname(__FILE__).'/pix';
        $this->_title = $title;
        $this->_description = $description;
        $this->_reward = $reward;
        $this->_state = (in_array($state,array('unlocked','locked','expired')) ? $state : 'unlocked');
        $this->_pix = (!empty($pix) ? $pix : "{$pix_path}/default.png");
        $this->_titleFont = "{$font_path}/Vera.ttf";
        $this->_textFont = "{$font_path}/VeraBd.ttf";
        $this->_bgColor = '#4f4f4f';
        $this->_titleColor = '#9dc34c';
        $this->_textColor = '#c8b996';
        if ($this->_state!='unlocked') {
            $this->_bgColor = '#343434';
            $this->_titleColor = '#909090';
            $this->_textColor = '#909090';
        }
    }

    /**
     * Standard getter
     * @param string $var          attribute name (eg: 'title')
     * @access public
     * @return mixed
     */
    public function __get($var) {
        $attribute = "_{$var}";
        return $this->$attribute;
    }

    /**
     * Build image and return the Imagick object
     * @param string $format       image format (gif, jpg, png, tiff, default is png)
     * @access public
     * @return Imagick
     */
    public function getImage($format='png') {
        $image = $this->_buildImage();
        $image->setImageFormat($format);
        return $image;
    }

    /**
     * Build image and save it to the given path
     * @param string $filename     image filename including format (eg: suck_my_balls.png)
     * @access public
     * @return void
     */
    public function saveImage($filename) {
        $image = $this->_buildImage();
        $image->writeImage($filename);
        $image->clear();
        $image->destroy();
    }

    /**
     * Build image
     * @access protected
     * @return Imagick
     */
    protected function _buildImage () {
        $canvas = new Imagick();
        $canvas->newImage($this->_width, $this->_height, 'none');

        $draw = new ImagickDraw();

        //drawing Background
        $draw->setFillColor(new ImagickPixel($this->_bgColor));
        $draw->roundRectangle(0,0,$this->_width-1,$this->_height-1,5,5);

        //drawing Title
        $draw->setFillColor(new ImagickPixel($this->_titleColor));
        $draw->setFont($this->_titleFont);
        $draw->setFontSize($this->_titleFontSize);
        $draw->annotation(84,5+$draw->getFontSize(),$this->_title);

        //drawing Description
        $draw->setFillColor(new ImagickPixel($this->_textColor));
        $draw->setFont($this->_textFont);
        $draw->setFontSize($this->_textFontSize);
        $draw->annotation(84,30+$draw->getFontSize(),$this->_description);

        //drawing Reward
        if (!empty($this->_reward)) {
            $draw->setFillColor(new ImagickPixel($this->_textColor));
            $draw->setFont($this->_textFont);
            $draw->setFontSize($this->_textFontSize);
            $draw->annotation(84,$this->_height-10,$this->_reward);
        }

        $canvas->drawImage($draw);

        //drawing pix (if not unlocked, set black and white)
        $expired = new Imagick($this->_pix);
        if ($this->_state!='unlocked') {
            $expired->modulateImage(100, 0, 100);
        }
        $canvas->compositeImage($expired, imagick::COMPOSITE_OVER, 4, 4);

        //if expired, draw the expired logo
        if ($this->_state=='expired') {
            $expired = new Imagick(dirname(__FILE__).'/extra/expired.png');
            $canvas->compositeImage($expired, imagick::COMPOSITE_OVER, 0, 0);
        }

        return $canvas;
    }
}
