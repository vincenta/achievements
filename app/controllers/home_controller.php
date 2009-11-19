<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Home controller
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class HomeController extends ApplicationController {

    /**
     * Index action : application home page
     * @access public
     * @return void
     */
    public function index() {
        $this->trophies = Achievement::$objects->all()->filter('state = ?',array('unlocked'))->order_by('-updated_on', 'created_on');
        $this->locked = Achievement::$objects->all()->filter('state = ?',array('locked'))->order_by('-updated_on', 'created_on');
        $this->expired = Achievement::$objects->all()->filter('state = ?',array('expired'))->order_by('-updated_on', 'created_on');
    }

}
