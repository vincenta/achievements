<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Class used to generate users gravatar url.
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class Gravatar {

    /**
     * Constructor 
     * @param string  $email        user email address
     * @param integer $size         desired image size (in pixels)
     * @param string  $default      d gravatar parameter (an image url, 'wavatar', 'identicon', 'monsterid' or '404')
     * @access public
     * @return string
     */
    public static function build_gravatar_url($email, $size=40, $default='wavatar') {
        $url = "http://www.gravatar.com/avatar.php?gravatar_id=%s&size=%d";
        if (in_array($dafault,array('wavatar','identicon','monsterid','404')))
            $url.= "&d=$default";
        elseif (!empty($default))
            $url.= "&d=".urlencode($default);
        return sprintf($url, md5(strtolower($email)), $size);
    }

}
