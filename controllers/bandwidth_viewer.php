<?php

/**
 * Bandwidth Viewer.
 *
 * @category   apps
 * @package    bandwidth-viewer
 * @subpackage controllers
 * @author     Tim Burgess <trburgess@gmail.com>
 * @copyright  2011-2014 ClearFoundation
 * @copyright  2007-2009 IOLA and Ole Laursen (Flot JS Chart)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/bandwidth_viewer/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Bandwidth Viewer Controller.
 *
 * @category   apps
 * @package    bandwidth-viewer
 * @subpackage controllers
 * @author     Tim Burgess <trburgess@gmail.com>
 * @copyright  2011-2014 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/bandwidth_viewer/
 */



use \Exception as Exception; 

class Bandwidth_Viewer extends ClearOS_Controller
{
    /**
     * Index controller.
     * 
     * @return view
     */

    function index() 
    {
        // Load libraries
        //---------------

        $this->lang->load('bandwidth_viewer');

        // Load view data
        //---------------

        // Load controllers
        //-----------------

        $controllers = array('bandwidth_viewer/report', 'bandwidth_viewer/series');

        $this->page->view_controllers($controllers, lang('bandwidth_viewer_app_name'));
    }

}

?>
