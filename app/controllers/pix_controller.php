<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Pix controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class PixController extends ApplicationController {

    /**
     * all_json action : return the list of all images useable to generate achievements in the pix folder
     * @access public
     * @return void
     */
    public function all_json() {
        $this->layout = '';

        $all = array();
        foreach (ImageBrowser::all() as $title => $image) {
            $all[] = array(
                'image_id' => $image->filename,
                'title'    => $image->title,
                'url'      => $this->url_for($image->path)
            );
        }
        $this->render_json(array(
            'message' => 'ok',
            'count'   => count($all),
            'images'  => $all
        ));
    }

}
