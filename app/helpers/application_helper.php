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
    if (!($f = @fopen($path, 'w')))
        throw new Exception(_f('Can\'t write to file %s',array($path)));
    fclose($f);
    unlink($path);
    $image = $achievement->generate();
    $image->saveImage($path);
}

