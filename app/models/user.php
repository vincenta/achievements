<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * User object model, using Stato SActiveRecord pattern
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class User extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'achievements_created' => array( 'assoc_type' =>'has_many', 'class_name' => 'Achievement', 'foreign_key' => 'creator_id' ),
        'achievements_won' => array( 'assoc_type' =>'has_many', 'class_name' => 'Achievement', 'foreign_key' => 'winner_id' )
    );
    public $record_timestamps = true;

    /**
     * Standard __toString function
     * @access public
     * @return string
     */
    public function __toString() {
        return "{$this->login}";
    }

    /**
     * Validate the user before creating/updating
     * @access public
     * @return void
     */
    public function validate () {
        $this->validate_uniqueness_of('login',array(__('This Login is already used.')));
        $this->validate_uniqueness_of('email',array(__('An account already exists for this email.')));
    }

    /**
     * Some data initialization before creating the user
     * @access public
     * @return void
     */
    protected function before_create() {
        $this->active = true;
        $this->login = strtolower($this->login);
        $this->email = strtolower($this->email);
    }

    /**
     * Get the user gravatar url
     * @param integer $size         desired image size (in pixels)
     * @access public
     * @return string
     */
    public function get_gravatar_url($size = 64) {
        return Gravatar::build_gravatar_url($this->email, $size);
    }

    /**
     * true if user is the creator of the given achievement
     * @param Achievement $achievement      the achievement to test
     * @access public
     * @return boolean
     */
    public function is_creator_of($achievement) {
        return ($this->id==$achievement->creator_id);
    }

}
