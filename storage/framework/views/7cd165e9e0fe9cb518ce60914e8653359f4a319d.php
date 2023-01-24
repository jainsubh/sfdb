<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>NEWS-Master Dashboard</title>
        <?php echo $__env->make('layouts.includes.master_head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            .inews-content{
                overflow:hidden;
                height: 530px;
            }
            .an-rep-content {
                overflow:hidden;
                height: 135px;
            }
            .an-rep-content-lg{
                overflow:hidden;
                height: 212px;
            }
            #chartdiv {
                width: 100%;
                height: 590px;
                overflow: hidden;
            }
            #chartdivGlobe {
                width: 200px;
                height: 200px;
                background: transparent;
                position: absolute;
                bottom: 20px;
                left: 20px;
            }
            .sector-items p{
                line-height:22px;
            }
            .entities-items p{
                line-height:22px;
            }
            .red{
                font-weight: 600;
            }
            .green{
                /*color: #41cd41;*/
                color: #4ae34a;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="wrap container-fluid">
                <!-- header section start -->
                <?php echo $__env->make('layouts.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- header section end -->

                <!-- alert navigation start -->
                <?php echo $__env->make('layouts.includes.alert-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- alert navigation end -->
                <section id="working-area" class="row">
                    <div class="col-xs-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-8 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                
                                <article id="main-map-panel" class="module">
                                    <div id="chartdiv"></div>
                                    <div id="chartdivGlobe"></div>
                                    <div id="colorLegends">
                                        <div class="color-legend" style="background-color: red">P1</div>
                                        <div class="color-legend" style="background-color: orange">P2</div>
                                        <div class="color-legend" style="background-color: yellow">P3</div>
                                        <div class="color-legend" style="background-color: green">P4</div>
                                        <div class="color-legend" style="background-color: cyan">P5</div>
                                        <div class="color-legend" style="background-color: blue">P6</div>
                                    </div>
                                </article>

                            </div>
                            <div class="col-2 col-lg-4 col-md-12 col-xs-12">
                                <article id="inews-panel" class="module">
                                    <h3>IMPORTANT NEWS</h3>
                                    <div class="inews-content">
                                        <div class="marquee-news" id="important_news" style="height:540px; visibility: hidden;" data-speed=15  data-pauseOnHover='true' data-pauseOnCycle='true' >
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-2 col-lg-8 col-md-12 col-xs-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6 col-xs-12">
                                        <article id="analyst-rep-panel" class="module">
                                            <h3>Analysts Reports</h3>
                                            <div class="analyst-numbers">
                                                <div class="row">
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($analyst_report_count); ?></div>
                                                            <div class="an-txt">total</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($analyst_report_year); ?></div>
                                                            <div class="an-txt">YTD</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($analyst_report_month); ?></div>
                                                            <div class="an-txt">MTD</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="an-rep-content">
                                                    <div class="marquee-vert" style="height:150px" data-speed=40 data-pauseOnHover='true' data-pauseOnCycle='true' >
                                                    <?php if($analyst_report): ?>
                                                    <?php $__currentLoopData = $analyst_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="an-rep-item">
                                                        <p> 
                                                            <?php if($report->subject->title != '' && $report->subject_type == 'alert'): ?> 
                                                                <?php echo e($report->subject->title); ?> 
                                                            <?php elseif($report->subject->title != '' && $report->subject_type == 'freeform_report'): ?> 
                                                                <?php echo e($report->subject->title); ?> 
                                                            <?php elseif($report->subject->name != '' &&  $report->subject_type == 'institution_report'): ?>
                                                                <?php echo e($report->subject->name); ?> 
                                                            <?php else: ?>
                                                                No Title 
                                                            <?php endif; ?>
                                                        </p>
                                                        <p class="date red"> <?php echo e(\Carbon\Carbon::parse($report->completed_at, 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                        </article>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6 col-xs-12">
                                        <article id="inst-rep-panel" class="module">
                                            <h3>Institutional Reports</h3>
                                            <?php if($institution_report_count): ?>
                                            <div class="analyst-numbers">
                                                <div class="row">
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($institution_report_count['institution_report_total']); ?></div>
                                                            <div class="an-txt">total</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($institution_report_count['institution_report_year']); ?></div>
                                                            <div class="an-txt">YTD</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-xs-4">
                                                        <div class="an-no-item">
                                                            <div class="an-no"><?php echo e($institution_report_count['institution_report_month']); ?></div>
                                                            <div class="an-txt">MTD</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <div class="an-rep-content">
                                                <div class="marquee-vert" style="height:150px" data-speed=40 data-pauseOnHover='true' data-pauseOnCycle='true' >
                                                    <?php if($institution_report): ?>
                                                    <?php $__currentLoopData = @$institution_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="inst-rep-content">
                                                        <div class="an-rep-item">
                                                            <p><?php echo e(Str::limit($report['name'], 38)); ?></p>
                                                            <p class="date red"><?php echo e(\Carbon\Carbon::parse($report['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </article>
                                    </div>
                                </div>             
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="twitter-global-panel" class="module">
                                    <h3>TWITTER TREND GLOBAL</h3>
                                    <div class="row">
                                        <div class="col-8 col-xs-8">
                                            <div class="tweet-items">
                                                <?php if($global_trends_report): ?>
                                                <?php 
                                                    foreach ($global_trends_report as $global): ?>
                                                    <p> <?php echo $global->value; ?></p>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-4 col-xs-4">
                                            <?php if($global_trends_report): ?>
                                            <?php 
                                                foreach ($global_trends_report as $gltrend){
                                                $globalprogress = ($gltrend->volume) / $global_trends_total * 100;
                                            ?>
                                                <div class="meter-holder">
                                                    <div class="cssProgress">
                                                        <div class="progress mblue">
                                                            <div class="cssProgress-bar blue-back" data-num="<?php echo $gltrend->volume; ?>" data-percent="<?php echo $globalprogress; ?>" style="width: <?php echo round($globalprogress); ?>%;">
                                                                <span class="cssProgress-label"><?php echo $gltrend->volume; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="twitter-uae-panel" class="module">
                                    <h3>TWITTER TREND UAE</h3>
                                    <div class="row">
                                        <div class="col-8 col-xs-8">
                                            <div class="tweet-items">
                                                <?php if($uae_trends_report): ?>
                                                <?php foreach ($uae_trends_report as $uae): ?>
                                                    <p> <?php echo $uae->value; ?></p>
                                                <?php endforeach; ?>    
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-4 col-xs-4">
                                            <?php if($uae_trends_report): ?>
                                            <?php 
                                                foreach ($uae_trends_report as $uae){
                                                $progress = ($uae->volume) / $uae_trends_total * 100;
                                                ?>
                                                <div id="progres11" class="meter-holder">
                                                    <div class="cssProgress">
                                                        <div class="progress mblue">
                                                            <div class="cssProgress-bar blue-back" data-num="<?php echo $uae->volume; ?>" data-percent="<?php echo $progress; ?>" style="width: <?php echo round($progress); ?>%;">
                                                                <span class="cssProgress-label"><?php echo $uae->volume; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="monitoring-panel" class="module">
                                    <h3>Log Status</h3>
                                    <div class="an-rep-content-lg">
                                        
                                        <div class="marquee-vert" style="height:210px" data-speed=40 data-pauseOnHover='true' data-pauseOnCycle='true' >
                                            <?php if($monitoring_details): ?>
                                                <?php $__currentLoopData = $monitoring_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="monitoring-item">
                                                    <p class="date red"><?php echo e(\Carbon\Carbon::parse($value['date_time'], 'UTC')->timezone(auth()->user()->timezone)->isoFormat('lll')); ?></p>
                                                    <p><?php echo e($value['description']); ?></p>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="sector-panel" class="module">
                                    <h3>MONITORING DETAILS</h3>
                                    <div class="sector-items">
                                        <p>URLs = <?php echo e($count['site']); ?> </p>
                                        <p>Organizations = <?php echo e($count['organisation']); ?></p>
                                        <p>Search Keywords = <?php echo e($count['keywords']); ?></p>
                                    </div>
                                    <h3>SECTORS</h3>
                                    <div class="row">
                                        <?php if($sectors->count()): ?>
                                        <div class="col-6 col-xs-6">
                                            <div class="entities-items">
                                                <?php for($i = 0; $i < 3; $i++): ?>
                                                <p><?php echo e(Str::limit($sectors[$i],18)); ?></p>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="col-6 col-xs-6">
                                            <div class="entities-items">
                                                <?php for($i = 3; $i < 6; $i++): ?>
                                                <p><?php echo e(Str::limit($sectors[$i],18)); ?></p>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="countries-panel" class="module">
                                    <h3>COUNTRIES - CITIES</h3>
                                    <div class="row">
                                        <div class="col-12 col-xs-12">
                                            <div class="entities-items">
                                                <?php if($alert_country): ?>

                                                    <?php $__currentLoopData = @$alert_country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <p><?php echo e($country->country->city); ?> - <?php echo e(Str::limit($country->country->capital,12)); ?> (<?php echo e($country->country->country_name); ?>)</p>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </article>
                            </div>
                            
       
                            <div class="col-2 col-xl-4 col-lg-4 col-md-6 col-xs-12">
                                <article id="entities-panel" class="module">
                                    <h3>KEYWORDS</h3>
                                    <div class="row" id="alert_keyword">
                                        
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php echo $__env->make('layouts.includes.master_footer_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            var cities = [];
            var imgData = [];

            var colors = {
                P1: 'red',
                P2: 'orange',
                P3: 'yellow',
                P4: 'green',
                P5: 'cyan',
                P6: 'blue',
            };
            
            function updateNews() {
                $.ajax({
                    type: 'GET',
                    url: 'master/map',
                    async: true,
                    dataType: 'json',
                    success: function (result) {
                        $("#important_news").html('');
                        cities = [];
                        imgData = [];
                        window.imageSeries.data = [];
                        window.imageSeriesGlobe.data = [];
                        var class_style = '';
                        $.each(result, function (key, value) {
                            if (value.priority == 'P1' || value.priority == 'p1') {
                                class_style = 'color : red; font-weight:500';
                            } else if (value.priority == 'P2' || value.priority == 'p2') {
                                class_style = 'color : orange';
                            } else if (value.priority == 'P3' || value.priority == 'p3') {
                                class_style = 'color : yellow';
                            } else if (value.priority == 'P4' || value.priority == 'p4') {
                                class_style = 'color : #4ae34a';
                            } else if (value.priority == 'P5' || value.priority == 'p5') {
                                class_style = 'color : cyan';
                            } else {
                                class_style = 'color : blue';
                            }

                            var important_news = '<div class="inews-item"><a href="'+value.link1+'" target="_blank"><p style="' + class_style + '">' + value.date + ' ' + value.time + ' : ' + value.priority + ' : ' + value.subject + '</p><p>' + value.content + '</p></div>';
                            $("#important_news").append(important_news);
                            
                            cities.push(value);
                            
                        });
                        addedCity();
                    }
                });
            }

            function addedCity() {
                imgData = [];
                window.imageSeries.data = [];
                window.imageSeriesGlobe.data = [];
                
                $.each(cities, function (key, value) {
                    var city = [];
                    city.color = colors[value.priority];
                    city.title = value.city;
                    city.latitude = parseFloat(value.latitude);
                    city.longitude = parseFloat(value.longitude);
                    city.priority = value.priority;
                    city.tooltip_description = value.priority + " : " + value.subject;
                    //console.log(city);
                    imgData.push(city);
                });
                
                window.imageSeries.data = imgData;
                window.imageSeriesGlobe.data = imgData;
            }

            function startMap() {
                // Themes begin
                am4core.useTheme(am4themes_kelly);
                // Themes end

                // Create map instance
                let chart = am4core.create("chartdiv", am4maps.MapChart);
                chart.logo.height = 0;

                // Set map definition
                chart.geodata = am4geodata_worldLow;

                // Set projection
                chart.projection = new am4maps.projections.Miller();
                chart.background.fill = am4core.color("#0a1942"); //darkblue
                chart.background.fillOpacity = 1;

                // Create map polygon series
                let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

                // Exclude Antartica
                polygonSeries.exclude = ["AQ"];

                // Make map load polygon (like country names) data from GeoJSON
                polygonSeries.useGeodata = true;

                // Configure series
                let polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.tooltipText = "{name}";
                polygonTemplate.polygon.fillOpacity = 1;
                polygonTemplate.polygon.strokeWidth = 0.5;
                polygonTemplate.stroke = am4core.color("rgb(50,200,250)");//blue
                polygonTemplate.fill = am4core.color("rgb(35,155,220)");//blue

                // Create hover state and set alternative fill color
                let hs = polygonTemplate.states.create("hover");
                hs.properties.fill = am4core.color("#4A80FF");

                // Add image series
                window.imageSeries = chart.series.push(new am4maps.MapImageSeries());
                imageSeries.mapImages.template.propertyFields.longitude = "longitude";
                imageSeries.mapImages.template.propertyFields.latitude = "latitude";
                imageSeries.mapImages.template.tooltipText = "{tooltip_description}";
                imageSeries.mapImages.template.showOnInit = true;
                imageSeries.mapImages.template.showTooltipOn = "always";
                imageSeries.mapImages.template.propertyFields.url = "url";
            
                let circle = imageSeries.mapImages.template.createChild(am4core.Circle);
                circle.radius = 8;
                circle.propertyFields.fill = "color";

                circle.events.on("inited", function (event) {
                    event.target.tooltip.label.maxWidth = 150;
                    event.target.tooltip.label.wrap = true;
                    //if (imgData.length === cities.length - 1) {
                        //imageSeries.mapImages.template.showTooltipOn = "hover";
                    //}
                });
                /*
                circle2.events.on("over", function (event) {
                    event.target.showTooltip();
                    event.target.tooltip.disabled = false;
                    event.target.tooltip.label.maxWidth = 150;
                    event.target.tooltip.label.wrap = true;
                });
                */
                imageSeries.data = imgData;
            }

            function startGlobe() {
                document.getElementById('chartdivGlobe').style.width = '200px';

                // Create map instance
                var chart = am4core.create("chartdivGlobe", am4maps.MapChart);
                chart.logo.height = 0;

                try {
                    chart.geodata = am4geodata_worldLow;
                } catch (e) {
                    chart.raiseCriticalError(new Error("Map geodata could not be loaded. Please download the latest <a href=\"https://www.amcharts.com/download/download-v4/\">amcharts geodata</a> and extract its contents into the same directory as your amCharts files."));
                }

                // Set projection
                chart.projection = new am4maps.projections.Orthographic();
                chart.panBehavior = "rotateLongLat";
                chart.padding(20, 20, 20, 20);

                chart.backgroundSeries.mapPolygons.template.polygon.fill = am4core.color("rgb(35,155,220)"); //blue;
                chart.backgroundSeries.mapPolygons.template.polygon.fillOpacity = 1;
                //chart.deltaLongitude = 20;
                chart.deltaLatitude = -20;
                
                var globeTimer = setInterval(() => {
                    //console.log(chart.deltaLongitude);
                    if (chart.deltaLongitude > 360) {
                        chart.deltaLongitude = 1;
                    }
                    chart.deltaLongitude += 3;
                }, 1);
                
                
                var globeDiv = document.getElementById('chartdivGlobe');
                
                globeDiv.onmouseover = () => {
                    clearInterval(globeTimer);
                };

                globeDiv.onmouseout = () => {
                    globeTimer = setInterval(() => {
                        if (chart.deltaLongitude > 360) {
                            chart.deltaLongitude = 1;
                        }
                        chart.deltaLongitude += 3;
                    }, 1);
                };
                
                
                // limits vertical rotation
                chart.adapter.add("deltaLatitude", function (delatLatitude) {
                    return am4core.math.fitToRange(delatLatitude, -90, 90);
                });
                

                // Create map polygon series
                var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                polygonSeries.useGeodata = true;
                polygonSeries.calculateVisualCenter = true;
                polygonSeries.tooltip.background.fillOpacity = 0.2;
                polygonSeries.tooltip.background.cornerRadius = 20;
                polygonSeries.tooltip.background.stroke = am4core.color("red");

                var template = polygonSeries.mapPolygons.template;
                template.nonScalingStroke = true;
                template.fill = am4core.color("#0a1942"); //#2a6cff ; 
                template.stroke = am4core.color("#e2c9b0");

                polygonSeries.calculateVisualCenter = true;
                template.propertyFields.id = "id";
                template.tooltipPosition = "fixed";
                template.fillOpacity = 1;

                template.events.on("over", function (event) {
                    if (event.target.dummyData) {
                        event.target.dummyData.isHover = true;
                    }
                });

                template.events.on("out", function (event) {
                    if (event.target.dummyData) {
                        event.target.dummyData.isHover = false;
                    }
                });

                var hs = polygonSeries.mapPolygons.template.states.create("hover");
                hs.properties.fillOpacity = 1;
                hs.properties.fill = am4core.color("#deb7ad");

                var graticuleSeries = chart.series.push(new am4maps.GraticuleSeries());
                graticuleSeries.mapLines.template.stroke = am4core.color("#000");
                graticuleSeries.fitExtent = false;
                graticuleSeries.mapLines.template.strokeOpacity = 0.2;

                var measelsSeries = chart.series.push(new am4maps.MapPolygonSeries());
                measelsSeries.tooltip.background.fillOpacity = 0;
                measelsSeries.tooltip.background.cornerRadius = 0;
                measelsSeries.tooltip.autoTextColor = false;
                measelsSeries.tooltip.label.fill = am4core.color("#000");
                measelsSeries.tooltip.label.maxWidth = 150;
                measelsSeries.tooltip.label.wrap = true;
                measelsSeries.tooltip.dy = -5;

                var measelTemplate = measelsSeries.mapPolygons.template;
                measelTemplate.fill = am4core.color("red");
                measelTemplate.strokeOpacity = 0;
                measelTemplate.fillOpacity = 0.75;
                measelTemplate.tooltipPosition = "fixed";

                var hs2 = measelsSeries.mapPolygons.template.states.create("hover");
                hs2.properties.fillOpacity = 1;
                hs2.properties.fill = am4core.color("#86240c"); // 

                window.imageSeriesGlobe = chart.series.push(new am4maps.MapImageSeries());
                var imageSeriesTemplate = imageSeriesGlobe.mapImages.template;
                var circle = imageSeriesTemplate.createChild(am4core.Circle);
                circle.radius = 4;
                circle.strokeWidth = 2;
                circle.nonScaling = true;
                circle.tooltipText = "{title}";

                imageSeriesTemplate.propertyFields.fill = "color";
                imageSeriesTemplate.propertyFields.stroke = "color";
                imageSeriesTemplate.propertyFields.latitude = "latitude";
                imageSeriesTemplate.propertyFields.longitude = "longitude";
                
                /*
                var animation;
                setTimeout(function(){
                    animation = chart.animate({property:"deltaLongitude", to:100000}, 4000000);
                }, 3000);

                var globeDiv = document.getElementById('chartdivGlobe');
                globeDiv.onmouseover = () => {
                    if(animation){
                        animation.stop();
                    }
                };

                globeDiv.onmouseout = () => {
                    animation.start();
                };
                */
                
                /*
                chart.seriesContainer.events.on("hover", function(){
                    if(animation){
                        animation.stop();
                    }
                })
                */
                imageSeriesGlobe.data = imgData;
            }

            am4core.ready(() => {
                startMap();
                startGlobe();
            });

            function updateAlertKeyword() {
                $.ajax({
                    type: 'GET',
                    url: 'master/alert_keyword',
                    async: true,
                    success: function (result) {
                        $("#alert_keyword").html(result);
                    }
                });
            }

            $(document).ready(function () {
                updateNews();
                updateAlertKeyword();
                setTimeout(function(){
                    $('.marquee-news').marquee({
                        direction: 'up',
                        speed: 50000
                    });
                    $("#important_news").css("visibility", "visible");
                }, 2000);
            });
            
            setInterval(function () {
                $("#important_news").css("visibility", "hidden");
                updateNews();
                setTimeout(function(){
                    $('.marquee-news').marquee({
                        direction: 'up',
                        speed: 50000
                    });
                    $("#important_news").css("visibility", "visible");
                }, 2000);
            }, 60000);

            setInterval(function() {
                $.ajax({
                    url: "<?php echo e(route('auth.check', '')); ?>",
                    success: function( response ) {
                    if(!response){
                        window.location.href = "<?php echo e(route('login')); ?>";
                    }
                    }
                });
            }, 5000);

        </script>
    </body>
</html><?php /**PATH /Volumes/Data/sfdbd_new/resources/views/master.blade.php ENDPATH**/ ?>