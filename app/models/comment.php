<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Comment object model, using Stato SActiveRecord pattern
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class Comment extends SActiveRecord {
    public static $objects;
    public static $relationships = array(
        'achievement' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'Achievement', 'foreign_key' => 'achievement_id' ),
        'author' => array( 'assoc_type' => 'belongs_to', 'class_name' => 'User', 'foreign_key' => 'author_id' )
    );
    public $record_timestamps = true;

    /**
     * Standard __toString function
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->body;
    }
}

