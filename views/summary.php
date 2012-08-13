<?php

/**
 * Bandwidth Viewer overview.
 *
 * @category   Apps
 * @package    bandwidth_viewer
 * @subpackage Views
 * @author     Tim Burgess <trburgess@gmail.com>
 * @copyright  2012 ClearFoundation
 * @copyright  Flot JS Chart 2007-2009 IOLA and Ole Laursen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later. 
 * @link       http://www.clearcenter.com/support/documentation/clearos/bandwidth_viewer/
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


// load language
    $this->lang->load('bandwidth_viewer');

// add javascripts
echo "<script type='text/javascript' src='/approot/bandwidth_viewer/htdocs/jquery.flot.min.js'></script>";

// display chart
echo chart_widget(lang('bandwidth_viewer_title'), "<div id='bandwidth_viewer' style='width: 100%; height: 400px; margin: 0 auto z-index:1'></div>");
//echo chart_widget(lang('bandwidth_viewer_series'), "<div id='series_select' style='margin: 0 auto'></div>");
