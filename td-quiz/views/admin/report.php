<form id="report-form" method="POST" action="<?php echo TDQ_PLUGIN_URI; ?>/inc/download.php" style="padding: 10px;background: #fff;">
    <div id="results-chart"></div>
    <input type="hidden" name="email" value="<?php echo $email; ?>" />
    <input type="hidden" name="chart_image" id="chart_image" value="" />
    <input type="button" class="button-primary" id="download-pdf" value="Download PDF" />
</form>
<canvas id="canvas" width="5" height="5"></canvas>
<script type="text/javascript">
(function ($) {
    var cats = ['<?php echo implode("','", $cat_names); ?>']; 
    var scores = [<?php echo implode(',', $score_arr); ?>];

    Highcharts.chart('results-chart', {
        title:{
    		text: null
    	},
       CSSObject: {
   fontFamily: 'monospace',
 color :'contrast'
},
    	credits: {
    		enabled: false
    	},
    	chart: {
            polar: true,
            type: 'area',
            height: 450,
            width: 580,
            spacing:[50, 10, 35, 10]
        },
        tooltip: { enabled: false },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            layout: 'horizontal',
            itemMarginBottom: 40,
            itemStyle: {
                fontWeight: 'bold',
                fontSize: '27px',
            }
        },
        pane: {
            size: '100%'
        },
        plotOptions: {
        	area: {
        		//fillColor: '#1e8180',
        	}
        },
        colors:['#defcfe'],// ['#1e8180'],
        xAxis: {
            categories: cats,
            tickmarkPlacement: 'on',
            lineWidth: 0,
             labels: {
            style: {
                color: 'black',
                fontSize:'1.1em'
            }
        }
        },
        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 2,
            min: 0,
            max: 20,
            tickInterval: 5,
        },
        series: [{
             showInLegend: false, 
             
            name: 'Total Profile Score',
            data: scores,
            pointPlacement: 'on',
            marker: {
            	enabled: false
            }
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
    			        align: 'center',
    			        verticalAlign: 'top',
    			        layout: 'horizontal',
    			        itemMarginBottom: 20,
    			    },
                    pane: {
                        size: '100%'
                    }
                }
            }]
        }
    
    });
    
    
    $('#download-pdf').click(function(){
           
        function svgString2Image(svgString, width, height, format, callback) {
            // set default for format parameter
            format = format ? format : 'png';
            // SVG data URL from SVG string
            var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
            // create canvas in memory(not in DOM)
            var canvas = document.createElement('canvas');
            // get canvas context for drawing on canvas
            var context = canvas.getContext('2d');
            // set canvas size
            canvas.width = width;
            canvas.height = height;
            // create image in memory(not in DOM)
            var image = new Image();
            // later when image loads run this
            image.onload = function () { // async (happens later)
                // clear canvas
                context.clearRect(0, 0, width, height);
                // draw image with SVG data to canvas
                context.drawImage(image, 0, 0, width, height);
                // snapshot canvas as png
                var pngData = canvas.toDataURL('image/' + format);
                // pass png data URL to callback
                callback(pngData);
            }; // end async
            // start loading SVG data into in memory image
            image.src = svgData;
        }
        
        // call svgString2Image function
        
        var svgString = $('#results-chart > div').html();
        
        svgString2Image(svgString, 800, 693, 'png', /* callback that gets png data URL passed to it */function (pngData) {
            // pngData is base64 png string
            $('#chart_image').val(pngData);
            $('#report-form').submit();
        });
        
        
        
         
    })
})(jQuery);
</script>