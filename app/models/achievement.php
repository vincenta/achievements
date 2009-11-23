<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Achievement object model, using Stato SActiveRecord pattern
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class Achievement extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'creator' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'creator_id' ),
        'winner' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'winner_id' )
    );
    public $record_timestamps = true;

    protected $_image;

    /**
     * Standard __toString function
     * @access public
     * @return string
     */
    public function __toString() {
        return "Achievement #{$this->id}: {$this->title}";
    }

    /**
     * True if the achievement has not been accomplished
     * @access public
     * @return boolean
     */
    public function is_locked() {
        return $this->state=='locked';
    }

    /**
     * True if the challenge has expired
     * @access public
     * @return boolean
     */
    public function is_expired() {
        return $this->state=='expired';
    }

    /**
     * True if the challenge has expired
     * @access public
     * @return boolean
     */
    public function is_new() {
        return $this->updated_on->ts() > time()-86400;
    }

    /**
     * Return the reward text, ie the reward and the donator
     * @access public
     * @return string
     */
    public function reward_text() {
        return _f('Reward : %s, given by %s', array($this->reward, $this->creator->target()));
    }

    /**
     * Return the default image name you may give to the image filename
     * This requires that the image already has an id
     * @access public
     * @return string
     */
    public function filename() {
        return "{$this->id}.png";
    }

    /**
     * Return the image from the image_id
     * @access public
     * @return Image
     */
    public function read_image() {
        if (empty($this->_image)) {
            $this->_image = ImageBrowser::get($this->image_id);
        }
        return $this->_image;
    }

    /**
     * Build image and return the AchievementPix object
     * @access public
     * @return AchievementPix
     */
    public function generate() {
        $pix = $this->image;
        $image_path = !empty($pix) ? $pix->get_path() : null;
        $image = new AchievementPix($this->title, $this->description, $this->reward_text(), $this->state, $image_path);
        return $image;
    }
}
