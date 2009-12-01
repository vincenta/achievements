<?php

/**
 * This class is the application specific achievements images visual style.
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class DefaultPixTheme extends AchievementPixTheme {

    /**
     * Constructor 
     * @param string $state        'unlocked', 'locked' or 'expired'
     * @access public
     * @return void
     */
    public function __construct($state='unlocked') {
        parent::__construct($state);
        $font_path = dirname(__FILE__).'/fonts';

        $this->_titleFont     = "{$font_path}/Victor.ttf";
        if ($state!='unlocked') {
            $this->_bgColor    = '#343434';
            $this->_titleColor = '#909090';
            $this->_textColor  = '#909090';
        } else {
            $this->_bgColor    = '#7a7463';
            $this->_titleColor = '#efb037';
            $this->_textColor  = '#ffffff';
        }
    }
}

