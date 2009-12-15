<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Some helper functions
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */

/**
 * Translate and protect string to be used in js
 * @param string $label
 * @access public
 * @return string
 */
function __js($label) {
    return addslashes(__($label));
}

/**
 * The path to the achievement image file
 * @param Achievement $achievement  achievement
 * @access public
 * @return string
 */
function achievement_path($achievement) {
    $filename = $achievement->filename();
    return "achievements/{$filename}";
}

/**
 * The url of the achievement image file (generate the file if it does no exists)
 * @param Achievement $achievement  achievement
 * @access public
 * @return string
 */
function achievement_url($achievement) {
    $path = achievement_path($achievement);
    if (!file_exists($path)) {
        generate_achievement($achievement, $path);
    }
    return SUrlRewriter::url_for($path);
}

/**
 * Build image of the achievement and save it to the given path
 * @param Achievement $achievement  achievement
 * @param string      $path         image file path including format (eg: achievements/1.png)
 * @access public
 * @return void
 */
function generate_achievement($achievement, $path) {
    if (!can_write($path))
        throw new Exception(_f('Can\'t write to file %s',array($path)));
    $image = $achievement->generate();
    $image->saveImage($path);
}

/**
 * set the achievement image file to be generated again
 * @param Achievement $achievement  achievement
 * @access public
 * @return void
 */
function must_regenerate_achievement($achievement) {
    $path = achievement_path($achievement);
    unlink($path);
}

/**
 * The path to the user image file
 * @param User $user  user
 * @access public
 * @return string
 */
function userImage_path($user) {
    $filename = strtolower("{$user->login}.png");
    return "users/{$filename}";
}

/**
 * The url of the user image file (generate the file if it does no exists)
 * @param User $user  user
 * @access public
 * @return string
 */
function userImage_url($user) {
    $path = userImage_path($user);
    if (!file_exists($path)) {
        generate_userImage($user, $path);
    }
    return SUrlRewriter::url_for($path);
}

/**
 * Build image of the user and save it to the given path
 * @param User $user  user
 * @param string      $path         image file path including format (eg: users/toto.png)
 * @access public
 * @return void
 */
function generate_userImage($user, $path) {
    if (!can_write($path))
        throw new Exception(_f('Can\'t write to file %s',array($path)));
    $image = $user->generate_image();
    $image->saveImage($path);
}

/**
 * set the user image file to be generated again
 * @param User $user  user
 * @access public
 * @return void
 */
function must_regenerate_userImage($user) {
    $path = userImage_path($user);
    unlink($path);
}

/**
 * http download a file from the given url and save it into the given filename
 * @param string      $url          url
 * @param string      $path         filename (eg: /tmp/toto.txt)
 * @access public
 * @return void
 */
function wget($url, $path) {
    if (!can_write($path))
        return false;

    $from  = @fopen($url, 'rb');
    $to    = @fopen($path, 'w');
    $error = false;
    while (!feof($from) && !$error) {
        $buffer = @fread($from, 1024);
        if (($buffer===FALSE) || (fwrite($to, $buffer)===FALSE)) {
            $error = true;
        }
    }
    fclose($to);
    fclose($from);

    if ($error)
        unlink($to);

    return !$error;
}

/**
 * Test if a file is overwritable (warning: file is deleted if it exists and is writable)
 * @param string      $path         filename (eg: /tmp/toto.txt)
 * @access public
 * @return void
 */
function can_write($path) {
    if (!($f = @fopen($path, 'w')))
        return false;
    fclose($f);
    unlink($path);
    return true;
}

/**
 * Return a user profile image tag html code
 * @param User      $user
 * @access public
 * @return void
 */
function gravatar_tag($user) {
    return tag('img', array('src' => $user->get_gravatar_url(), 'alt' => $user->__toString(), 'title' => $user->__toString()));
}

/**
 * Return a displayable internationalized date
 * @param date      $date
 * @access public
 * @return string
 */
function displayable_date($date) {
    $age = time() - $date;
    if ($age < 60) {
        return __('just few seconds ago');
    }
    if ($age < 3600) {
        $minutes = intval($age/60);
        return _f('%s minutes ago',$minutes);
    }
    //FIXME: it would be better to use "yesterday" if date is older than today at 00:00
    if ($age < 86400) {
        $hours = intval($age/3600);
        return _f('%s hours ago',$hours);
    }
    if ($age < 864000) {
        $days = intval($age/86400);
        return _f('%s days ago',$days);
    }
    //FIXME: it would be better to give the date ;)
    return __('a long time ago');
}

