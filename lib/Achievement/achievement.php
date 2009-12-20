<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Class used to generate achievement images.
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
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
    protected $_theme;
    protected $_image;

    /**
     * Constructor 
     * @param string $title        achievement title to draw
     * @param string $description  description to draw
     * @param string $state        'unlocked', 'locked' or 'expired'
     * @param string $pix          path to the achievement pix (64*64px)
     * @param AchievementPixTheme $theme AchievementPix theme
     * @access public
     * @return void
     */
    public function __construct($title, $description, $reward='', $state='unlocked', $pix=null, AchievementPixTheme $theme=null) {
        $pix_path  = dirname(__FILE__).'/pix';

        $this->_title = $title;
        $this->_description = $description;
        $this->_reward = $reward;

        $this->_state = 'unlocked';
        if (in_array($state, array('unlocked','locked','expired')))
            $this->_state = $state;

        $this->_pix = "{$pix_path}/default.png";
        if (!empty($pix))
            $this->_pix = $pix;

        $this->set_theme($theme);
    }

    /**
     * Set the AchievementPix visual style
     * @param AchievementPixTheme $theme AchievementPix theme
     * @access public
     * @return mixed
     */
    public function set_theme(AchievementPixTheme $theme=null) {
        if (empty($theme))
            $this->_theme = new AchievementPixTheme($this->_state);
        else
            $this->_theme = $theme;
    }

    /**
     * Standard getter
     * @access public
     * @return void
     */
    public function __get($var) {
        if ($var=='image')
            return $this->build();
        $attribute = "_{$var}";
        return $this->$attribute;
    }

    /**
     * Build image and return the Imagick object or just return if it was already built
     * @param string $format       image format (gif, jpg, png, tiff, default is png)
     * @access public
     * @return Imagick
     */
    public function build($format='png') {
        if (!$this->_image)
            $this->_image = $this->_buildImage();
        $this->_image->setImageFormat($format);
        return $this->_image;
    }

    /**
     * Build image and save it to the given path
     * @param string $filename     image filename including format (eg: suck_my_balls.png)
     * @access public
     * @return void
     */
    public function save($filename) {
        $info  = pathinfo($filename);
        $image = $this->build($info['extension']);
        $image->writeImage($filename);
    }

    /**
     * Free all resources and delete the image object
     * @access public
     * @return void
     */
    public function destroy() {
        if ($this->_image)
            $this->_image->destroy();
        $this->_image = null;
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
        $draw->setFillColor(new ImagickPixel($this->_theme->bgColor));
        $draw->roundRectangle(0,0,$this->_width-1,$this->_height-1,5,5);

        //drawing Title and Description
        $this->_addTextToDraw($draw, $this->_theme->titleColor, $this->_theme->titleFont, $this->_theme->titleFontSize,
            84, $this->_theme->titleYPos, $this->_title);
        $this->_addTextToDraw($draw, $this->_theme->textColor, $this->_theme->textFont, $this->_theme->textFontSize,
            84, $this->_theme->descYPos, $this->_description);

        //drawing Reward
        if (!empty($this->_reward)) {
            $this->_addTextToDraw($draw, $this->_theme->textColor, $this->_theme->textFont, $this->_theme->textFontSize,
                84, $this->_theme->rewardYPos, $this->_reward);
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

    /**
     * Add text to the given ImagickDraw (just a tool function used by _buildImage)
     * @param ImagickDraw $draw         canvas to draw text
     * @param string      $color        text color
     * @param string      $font         font path
     * @param integer     $font_size    font size (in pixels)
     * @param integer     $x            text x pos
     * @param integer     $y            text y pos
     * @param string      $text         text
     * @access protected
     * @return void
     */
    protected function _addTextToDraw(&$draw, $color, $font, $font_size, $x, $y, $text) {
        $draw->setFillColor(new ImagickPixel($color));
        $draw->setFont($font);
        $draw->setFontSize($font_size);
        $draw->annotation($x,$y+$draw->getFontSize(),$text);
    }
}

/**
 * Class used to set achievement images visual style.
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class AchievementPixTheme {
    protected $_bgColor       = '#4f4f4f';
    protected $_titleColor    = '#9dc34c';
    protected $_titleFont;
    protected $_titleFontSize = 20;
    protected $_textColor     = '#c8b996';
    protected $_textFont;
    protected $_textFontSize  = 11;
    protected $_titleYPos     = 5;
    protected $_descYPos      = 34;
    protected $_rewardYPos    = 51;

    /**
     * Constructor 
     * @param string $state        'unlocked', 'locked' or 'expired'
     * @access public
     * @return void
     */
    public function __construct($state='unlocked') {
        $font_path = dirname(__FILE__).'/fonts';

        $this->_titleFont     = "{$font_path}/Vera.ttf";
        $this->_titleFontSize = 20;
        $this->_textFont      = "{$font_path}/VeraBd.ttf";
        $this->_textFontSize  = 11;
        if ($state!='unlocked') {
            $this->_bgColor    = '#343434';
            $this->_titleColor = '#909090';
            $this->_textColor  = '#909090';
        } else {
            $this->_bgColor    = '#4f4f4f';
            $this->_titleColor = '#9dc34c';
            $this->_textColor  = '#c8b996';
        }
    }

    /**
     * Standard getter
     * @access public
     * @return void
     */
    public function __get($var) {
        $attribute = "_{$var}";
        return $this->$attribute;
    }
}

