<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Image object model
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class Image {
    protected $_filename;
    protected $_title;

    /**
     * Constructor 
     * @param mixed $params       the image filename (or an array containing the filename)
     * @access public
     * @return void
     */
    public function __construct($params) {
        $filename = ( is_array($params) ? $params['filename'] : $params );
        if (!ImageBrowser::check_file($filename)) {
            Throw new Exception(__('This file does not exists or is not readable !'));
        }
        $this->_filename = $filename;
    }

    /**
     * Standard getter
     * @access public
     * @return void
     */
    public function __get($var) {
        $getter = "get_{$var}";
        return $this->$getter();
    }

    /**
     * Filename getter
     * @access public
     * @return void
     */
    public function get_filename() {
        return $this->_filename;
    }

    /**
     * Title getter
     * @access public
     * @return void
     */
    public function get_title() {
        if (empty($this->_title))
            $this->_title = ImageBrowser::build_title($this->_filename);
        return $this->_title;
    }

    /**
     * Title getter
     * @access public
     * @return void
     */
    public function get_path() {
        return ImageBrowser::build_path($this->_filename);
    }

    /**
     * Standard setter
     * @access public
     * @return void
     */
    public function __set($var,$value) {
        $setter = "set_{$var}";
        return $this->$setter($value);
    }

    /**
     * Standard __toString function
     * @access public
     * @return string
     */
    public function __toString() {
        return "{$this->title}";
    }
}

/**
 * class used to browse image dir
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class ImageBrowser {

    /**
     * Return the image object identified by this filename
     * @param string $filename     the image filename
     * @access public
     * @return string
     */
    public static function get($filename) {
        if (ImageBrowser::check_file($filename)) {
            return new Image($filename);
        }
        return false;
    }

    /**
     * ls the images folder (exclude bad extensions or non readable files)
     * @access public
     * @return array
     */
    public static function all() {
        static $all = null;
        if (is_null($all)) {
            $folder_handle = opendir("pix/");
            $all = array();
            while(false !== ($filename = readdir($folder_handle))) {
                if ( (substr($filename, 0, 1)!='.') && ($image = ImageBrowser::get($filename)) ) {
                    $all[] = $image;
                }
            }
        }
        return $all;
    }

    /**
     * build the image filepath from the given filename
     * @param string $title        the image title
     * @access public
     * @return string
     */
    public static function build_path($filename) {
        return "pix/{$filename}";
    }

    /**
     * Convert the image filename to the image title
     * @param string $filename     the image filename or path
     * @access public
     * @return string
     */
    public static function build_title($filename) {
        $info     = pathinfo($filename);
        $filename = basename($file,".{$info['extension']}");
        return str_replace(array('_'),array(' '),$filename);
    }

    /**
     * Generate the image filename from the given title
     * @param string $title        the image title
     * @access public
     * @return string
     */
    public static function generate_filename($title) {
        $tmp = trim(preg_replace( '/([^a-zA-Z0-9\_\-\.\s]+)/', '', $title)); //removes forbidden chars
        $tmp = preg_replace( '/(\s+)/', '_', $tmp); //replaces any space by underscore
        return "{$tmp}.png";
    }

    /**
     * Check file exists, has a valid extension and is readable
     * @param string $filename     the image filename
     * @access public
     * @return string
     */
    public static function check_file($filename) {
        $path = ImageBrowser::build_path($filename);
        $info = pathinfo($path);
        return (file_exists($path) && ImageBrowser::is_valid_extension($info['extension']) && is_readable($path) && !is_dir($path.'/'));
    }

    /**
     * Valid extensions are png, gif, jpg or jpeg
     * @param string $extension    the image extension
     * @access public
     * @return string
     */
    public static function is_valid_extension($extension) {
        return in_array($extension, array('png', 'gif', 'jpg', 'jpeg'));
    }
}

