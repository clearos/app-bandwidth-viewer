Highcharts.setOptions({
   global: {
      useUTC: false
   }
});

var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'bandwidth_viewer',
				defaultSeriesType: 'line',
				marginRight: 10,
				events: {
					load: requestData
				}
			},
			plotOptions: {
				series: {
					marker: {
						enabled: false,
						states: {
							hover: {
								enabled: true
							}
						}
					}
				}
			},
			title: {
				text: ''
			},
			xAxis: {
				type: 'datetime',
				tickPixelInterval: 150,
				maxZoom: 20 * 1000,
				gridLineWidth: 1
			},
			yAxis: {
				//minPadding: 0.2,
				//maxPadding: 0.2,
				min: 0,
				title: {
					text: '',
					margin: 10
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				//formatter: function() {
		                //return '<b>'+ this.series.name +'</b><br/>'+
				//		Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+ 
				//		Highcharts.numberFormat(this.y, 2);
				//}
			},
			legend: {
				enabled: true
			},
			exporting: {
				enabled: false
			},
			series: []
			});
		});
/**
 * Request data from the server, add it to the graph and set a timeout to request again
 */
function requestData() {
    $.ajax({
        url: '/approot/bandwidth_viewer/htdocs/getnetdata.php',
        success: function(point) {
		
		var limit = point.length - chart.series.length;	
		if(point.length > 60){
			var limit = 0;
		}
		for(i=0; i<limit; i++){
			chart.addSeries({ name: point[i].name, redraw: false });
		}
		
            	var series = chart.series[0],
	    	shift = series.data.length > 60; // shift if the series is longer than 20
	    
		// add the points
		if(chart.series.length > 1){
		for(i=0; i<point.length; i++){
			chart.series[i].addPoint([point[i].x,point[i].y], false, shift);
		}
		}
		chart.redraw();	                
            // call it again after one second
            setTimeout(requestData,500);    
        },
        cache: false
    });
}
				

