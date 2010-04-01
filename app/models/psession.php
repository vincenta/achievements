<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Psession object model, using Stato SActiveRecord pattern
 * (Persistent Session)
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class Psession extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'user' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'user_id' )
    );
    public $record_timestamps = true;
    public $attr_protected = array('key');

    public static $expiration = 691200; //8 days (in seconds)
    public static $cookie_name = 'achievements_stayloggedin_key';

    /**
     * Standard __toString function
     * @access public
     * @return string
     */
    public function __toString() {
        return "{$this->user->target()} ({$this->key})";
    }

    /**
     * called any time someone try to manually set the key
     * @param  string $value   ignored
     * @access public
     */
    public function write_key($value=null) {
        $login = $this->user->target()->login;
        $this->key = $login.'_'.sha1(uniqid(rand(),true));
    }

    /**
     * function called any time someone try to manually set the key
     * @access protected
     */
    protected function after_save() {
        setcookie(self::$cookie_name, $this->key, time()+self::$expiration, '/');
    }

    /**
     * Update the psession key
     * record from the database
     * @access public
     */
    public function touch() {
        $this->key = 'pouet'; //force the call of write_key
        $this->save();
    }

    /**
     * Delete the cookie of the persistent session and remove the corresponding
     * record from the database
     * @access public
     * @return User
     */
    public function force_expire() {
        $this->delete();
        setcookie(self::$cookie_name, '', time()-3600, '/');
    }

    /**
     * Used to retrieve the connected user
     * @access public
     * @return User
     */
    public static function retrieve() {
        self::check_expiration();
        $key = $_COOKIE[self::$cookie_name];
        if (!empty($key)) {
            $psession = self::$objects->get('`key` = ?', array($key));
            if ($psession) {
                $psession->touch();
                return $psession;
            }
        }
        return null;
    }

    /**
     * Remove all expired sessions from database
     * @access public
     * @return User
     */
    public static function check_expiration() {
        $expiration_limit = time()-self::$expiration;
        $query = "DELETE FROM psessions WHERE UNIX_TIMESTAMP(updated_on) < {$expiration_limit};";
        return self::connection()->execute($query);
    }
}

