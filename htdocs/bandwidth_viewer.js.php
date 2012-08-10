<?php

/**
 * Bandwidth_Viewer javascript helper.
 *
 * @category   Apps
 * @package    Bandwidth Viewer
 * @subpackage Javascript
 * @author     Tim Burgess <trburgess@gmail.com>
 * @copyright  2011 ClearFoundation
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
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// J A V A S C R I P T
///////////////////////////////////////////////////////////////////////////////

header('Content-Type:application/x-javascript');
?>



$(function () {
    // wipe data, set total points
    var series = [], totalPoints = 120;
    var points = [];
    // setup control widget
    var updateInterval = 200;

    // setup plot
    var options = {
	 points: { show: false },
	 grid: { 
		borderWidth:0, 
		minBorderMargin: 20, 
		backgroundColor: { colors: ["#fff","#ddd"]},
		hoverable: true },
        series: { shadowSize:2, 
		lines: { show: true, fill: 0.1}}, // drawing is faster without shadows
	legend: { 
		show: true,
		position: "sw"},
        //zoom: { interactive: true },
	//pan: { interactive: true },
        xaxis: { 
		show: true, 
		//ticks: [], 
		mode: "time" },
	yaxis: {
		min: 0}
		//zoomRange: [0,1000],
		//panRange: [0,1000]}
		
    };
    var plot = $.plot($("#bandwidth_viewer"), series, options);
    update();

    function update() {
            $.ajax({
                url: "/approot/bandwidth_viewer/htdocs/getnetdata.php",
                method: 'GET',
                dataType: 'json',
		cache: false,
                success: onDataReceived
            });

            function onDataReceived(point) {
		 for (var i = 0; i < point.length; i++) {
			if(typeof points[i] == "undefined"){
				points[i] = [];
			}
			//points[i].push(point[i].data);
			points[i][points[i].length] = point[i].data;
			if(points[i].length > totalPoints){
				points[i].shift();
			}
			
			//debug alert(JSON.stringify(points));
			series[i] = ({ 
				label: point[i].label, 
				data: points[i]
			});
		  }
		
		setTimeout(update,updateInterval);   
		
     	        plot.setData(series);
		plot.setupGrid()
	        plot.draw();
	    }
	}

	function showTooltip(x, y, contents) {
		$('<div id="tooltip" style="z-index:10">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 5,
			border: '1px solid #fdd',
			padding: '2px',
			'background-color': '#fff',
			opacity: 0.80
		}).appendTo("body").fadeIn(100);
	}

	var previousPoint = null;
	$("#bandwidth_viewer").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2), y = item.datapoint[1].toFixed(2);
					showTooltip(item.pageX, item.pageY, item.series.label + " = " + y);
				}
			}
			else {
				$("#tooltip").remove();
				previousPoint = null;
			}
	});  


});