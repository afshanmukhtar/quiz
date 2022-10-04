// Entry form
// ---------------------------------------------------------------------------------------
function getUrlVars(str) {
    var val = decodeURIComponent((str+'').replace(/\+/g, '%20'));
    var vars = [], hash;
    var hashes = val.split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push({[hash[0]]:hash[1]});
    }
    return JSON.stringify(vars);
}

(function ($) {
    $("#entry-formm .form-control").tooltip({placement: 'top', trigger: 'manual'}).tooltip('hide');
    $('#entry-form .form-control').blur(function () {
        $(this).tooltip({placement: 'top', trigger: 'manual'}).tooltip('hide');
    });

    $("#entry-form .btn-quiz-start").click(function () {
        var form = $(this).attr('data-step');
        var name = $("#entry-form input#name").val();
        if (name == "" || name == "Name...." || name == "Name" || name == "Name *" || name == "Type Your Name...") {
            $("#entry-form input#name").tooltip({placement: 'bottom', trigger: 'manual'}).tooltip('show');
            $("#entry-form input#name").focus();
            return false;
        }

        var email = $("#entry-form input#email").val();
        var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
        if (!filter.test(email)) {
            $("#entry-form input#email").tooltip({placement: 'bottom', trigger: 'manual'}).tooltip('show');
            $("#entry-form input#email").focus();
            return false;
        }
        
        $('.td-quiz .loading-status').show();
        
        $.ajax({
            url : tdq_script.ajaxurl,
            type : 'post',
            data : {
                action : 'td_load_quiz_form',
                name: name,
                email: email,
                form: form
            },
            success : function( msg ) {
                
                data = JSON.parse(msg);
                $('.td-quiz-main-area').html(data['form']); 
                 
            },complete: function (data) {
                $('.td-quiz .loading-status').hide();
                $("html, body").animate({ scrollTop: $('.td-quiz-main-area').offset().top }, 600);
                $('#quiz-status').skillBars({
                    from: 0,
                    speed: 1000, 
                    interval: 100,
                    decimals: 0,
                }); 
            }
        })
        
        return false;
    });

    $('body').on('click', 'button.notice-dismiss', function(){
         $(this).parent().remove();
    });

    $('.td-quiz-main-area').on('click','#quiz_next',function(){
        var form_data = '';
        var form_step = $(this).attr('data-step'); 
        var data = JSON.parse(getUrlVars($( ".quiz-form" ).serialize()));

        var radio = [];
        $.each( $('.quiz-form input:radio'), function(){
            var myname= this.name;
            if( $.inArray( myname, radio ) < 0 ){
                radio.push(myname); 
            }
        });

        if ( radio.length != data.length ) {

            if ($('div#alert-error').length == 0) {
                $( '<div id="alert-error"><p><strong>Error:</strong> You have to answer every question</p><button type="button" class="notice-dismiss"><span>Dismiss this notice.</span></button></div>' ).insertBefore( "h3.title-inner" );
            }
            $("html, body").animate({ scrollTop: $('.td-quiz-main-area').offset().top }, 600);
            return false;

        } else if ( radio.length == data.length ) { 

            var form_data = $( ".quiz-form" ).serialize();

            $('.td-quiz .loading-status').show();
            var respond = [];

            $.ajax({
                url : tdq_script.ajaxurl,
                type : 'post',
                data : {
                    action : 'td_load_quiz_form',  
                    form: form_step,
                    quiz_data: form_data, 
                },
                success : function(msg) {
                    
                    data = JSON.parse(msg);
                    //data=msg;
                    respond = data; 
                    //console.log(respond['']);
                    //console.log(respond['']);
                    $('.td-quiz-main-area').html(data['form']); 
                     
                },
                complete: function (data) {
                    $("html, body").animate({ scrollTop: $('.td-quiz-main-area').offset().top }, 600);
                    if(form_step !='finish'){
                        $('#quiz-status').skillBars({
                            from: 0,
                            speed: 1000, 
                            interval: 100,
                            decimals: 0,
                        }); 
                    }
                    else{
                        var cat_str = respond['categories'];
                        var cats = cat_str.split(",");
                        var score_str = respond['score'];
                        var scores = $.map( score_str.split(","), Number );//score_str.split(",");
                         
                        
                        Highcharts.chart('spider-chart', {
                            title:{
                                text: null
                            },
                            credits: {
                                enabled: false
                            },
                            chart: {
                                polar: true,
                                type: 'area',
                                height: 450,
                                spacing:[50, 10, 35, 10]
                            },
                            legend: {
                                align: 'center',
                                verticalAlign: 'top',
                                layout: 'horizontal',
                                itemMarginBottom: 40,
                                itemStyle: {
                                    fontWeight: 'bold',
                                    fontSize: '22px',
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
                    }
                    $('.td-quiz .loading-status').hide();
                }
            });

        }
        return false;
    });

    $('.td-quiz-main-area').on('click','#thanks',function(){
        $('.td-quiz .loading-status').show();
        $.ajax({
            url : tdq_script.ajaxurl,
            type : 'post',
            data : {
                action : 'td_load_thnaks_form',
            },
            success : function( data ) {

                $('.td-quiz-main-area').html(data); 
                 
            },
            complete: function (data) {
                $('.td-quiz .loading-status').hide();
                 $("html, body").animate({ scrollTop: $('.td-quiz-main-area').offset().top }, 350);
            }
        });
        
        return false;
    });

    if (typeof cats !== 'undefined') {
  
        Highcharts.chart('results-chart', {
            title:{
                text: null
            },
            credits: {
                enabled: false
            },
            chart: {
                polar: true,
                type: 'area',
                height: 450,
                width: 520,
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
                    fontSize: '22px',
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
            colors: ['#defcfe'],//['#1e8180'],
            xAxis: {
                categories: cats,
                tickmarkPlacement: 'on',
                lineWidth: 0,
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
    } 

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
    
    $('#download-pdf').click(function(){
        var svgString = $('#results-chart > div').html();
        svgString2Image(svgString, 800, 693, 'png', function(pngData) {
            $('#chart_image').val(pngData);
            $('#download-form').submit();
        });
    })
     
})(jQuery);