<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>NEWS-{{$name}}</title>
    @include('layouts.includes.head')
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/kelly.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <style>
      #summary-panel .summary-item{
        height: 195px;
        /*overflow: hidden;
        text-overflow: ellipsis; */
      }
      /*.summary{
        height:175px; 
        margin-bottom: 5px; 
        overflow: hidden;
      }*/
      #knowledgeMap{
        height: 318px;
      }
      #knowledgeMapTool{
        position: absolute;
        right: 10px;
        top: 8px;
      }
      #knowledgeMapTool a i{
        color: #629fc3;
      }
      #chartdiv {
        width: 100%;
        height: 495px;
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

      #word_definition .modal-content{
        width: 800px;
        max-height: 600px;
        overflow-y: auto;
      }
      #word_definition .word{
        text-align: left;
        margin-bottom: 0px;
      }
      #word_definition .punctuation{
        font-size: 12px;
      }
      #word_definition ul li{
        padding: 4px 25px;
        font-weight: normal;
        font-size: 14px;
      }
      #word_definition .definition_type{
        padding: 5px 0px;
      }
      #word_definition .meaning-container{
        position: relative;
        min-height: 100px;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="wrap container-fluid">
          <!-- header section start -->
          @include('layouts.includes.header')
          <!-- header section end -->

          <!-- alert navigation start -->
          <!-- @include('layouts.includes.alert-navigation') -->
          <section id="alert" class="row">
            <div class="col-12 col-xs-12">
                <div class="alert-holder">
                    <div class="alert-txt" style="background:#102f74; width:115px; z-index:99">
                        <h2 style="color:#28adfb; overflow:hidden">TITLE</h2>
                    </div>
                <div class="module-alert"> 
                  <div class="marquee-horz" style="width:800px" data-speed=60 data-pauseOnHover='true' data-pauseOnCycle='true' >
                      <h3 class="red" style="text-align:left; margin-left:12px">{{ Str::limit($alert->title,140) }}</h3>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- alert navigation end -->
          
        <section id="working-area" class="row">
          <div class="col-2 col-lg-12 col-md-12 col-xs-12">
            <div class="row">
              <!-- Summary -->
              <div class="col-12 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <article id="summary-panel" class="module">
                  <h3>SUMMARY</h3>
                  <div class="scroll-wrapper summary-item">
                    <div class="scroll-inner">
                      <div class="summary" >
                        <p style="text-align: justify" id="summary_meaning">{{ $alert->summary }}</p><br>
                      </div>
                    </div>
                  </div>  
                </article>
              </div>
              <!-- Source URl -->
              <div class="col-12 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <article id="source-panel" class="module">
                  <h3>SOURCES URL</h3>
                  <div class="scroll-wrapper source-list">
                    <div class="scroll-inner">
                      <div class="source-content">
                        @foreach($alert->links->pluck('url') as $links)
                          <a href="{{$links}}" target="_blank" style="color:white; "> <p> {{$links}}</p> </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </article>
              </div>
              <!-- Sentiment Count -->
              <div class="col-12 col-lg-4 col-xs-12">
                <article id="tweet-no-panel" class="module">
                  <h3>SENTIMENT COUNT</h3>
                  <div class="tweet-numbers">
                    <div class="row">
                      <div class="col-4 col-xs-4">
                        <div class="tw-no-item">
                          <div class="tw-no green">{{ $alert->positive }}</div>
                          <div class="tw-txt">positive</div>
                        </div>
                      </div>
                      <div class="col-4 col-xs-4">
                        <div class="tw-no-item">
                          <div class="tw-no orange">{{ $alert->neutral }}</div>
                          <div class="tw-txt">neutral</div>
                        </div>
                      </div>
                      <div class="col-4 col-xs-4">
                        <div class="tw-no-item">
                          <div class="tw-no red">{{ $alert->negative }}</div>
                          <div class="tw-txt">negative</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
          
          <div class="col-7 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- Globe Map -->
            <article id="events-map-panel" class="module">
              <div id="chartdiv"></div>
              <div id="chartdivGlobe"></div>
            </article>
            <!-- Knowledge Map -->
            <article id="knowledge-map-panel" class="module">
              <div id="knowledgeMapTool">
                <a onclick="mapCenter();" href="javascript:void(0)">
                  <em class="fa fa-crosshairs" style="font-size: 30px;"></em>
                </a>
              </div>
              <div id="knowledgeMap">
              </div>
            </article>
          </div>

          <div class="col-3 col-lg-12 col-md-12 col-xs-12">
            <div class="row">
              <!-- Country / City -->
              <div class="col-12 col-lg-4 col-xs-12">
                <article id="tab-country-panel" class="module">
                  <h3>Countries/cities</h3>
                  <div class="table-head">
                    <table aria-describedby="" border="0">
                      <thead>
                        <tr>
                          <th scope="col" style="width:50%">Country</th>
                          <th scope="col" style="width:50%">City</th>
                          <!--<th scope="col" style="width:33%">Count</th>-->
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="scroll-wrapper country-list">
                    <div class="scroll-inner">
                      <div class="table-content">
                        <table aria-describedby=""  border="0">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($alert->countries as $countries)
                            <tr>
                              <td style="width:33%">
                                  {{$countries->country->country_name}}
                              </td>
                              <td style="width:33%">
                                  {{$countries->country->city}}
                              </td>
                              <!--<td style="width:33%">{{rand(1,25)}}</td>-->
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
              <!-- Sectors -->
              <div class="col-12 col-lg-4 col-xs-12">
                <article id="tab-sector-panel" class="module">
                  <h3>Categories</h3>
                  
                  <div class="scroll-wrapper sector-list">
                    <div class="scroll-inner">
                      <div class="table-content">
                        <table aria-describedby=""  border="0">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($alert->events->eventdepartments as $key => $value)
                            <tr>
                              <td style="width:22.66%">
                              {{$value->departments->name}}
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </article>
                
              </div>
              <!-- Popular Mentions -->
              <div class="col-12 col-lg-4 col-xs-12">
                <article id="tab-mentions-panel" class="module">
                  <h3>Keywords</h3>
                  
                  <div class="scroll-wrapper mentions-list">
                    <div class="scroll-inner">
                      <div class="table-content">
                        <table aria-describedby=""  border="0">
                          <thead>
                            <tr>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($alert->keywords as $key => $value)
                            <tr>
                              <td style="width:50%">{{ $value->keyword }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

    @include('layouts.includes.footer-scripts')

    <div id="word_definition" class="modal">
        <div class="modal-content">
            <div class="panel-modal-head">
                <a href="javascript:void(0)" onclick="$('#word_definition').modal('hide');" class="close" aria-label="Close">&times;</a>
                <div class="panel-title">Dictionary</div>
            </div>
            
            <div class="panel-modal-content">
                <div class="meaning-container .scroll-wrapper">
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 10px; ">  
                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right; margin-bottom: 12px; padding: 0 20px;">
                    <div class="btn_semi_automatic">
                        <button class="button" onclick="$('#word_definition').modal('hide');"> OK </button>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
    <script src="https://gw.alipayobjects.com/os/lib/antv/g6/3.7.3/dist/g6.min.js"></script>
    <script>
      var graph;
      //scrollbar
      (function($) {
          $(window).on("load", function() {
            $(".scroll-wrapper").mCustomScrollbar();
          });

          var summary_meaning = $('p#summary_meaning');

          summary_meaning.html(function(index, oldHtml) {
              return oldHtml.replace(/\b(\w+?)\b/g, '<span class="word">$1</span>')
          });

          summary_meaning.dblclick(function(event) {
              if(this.id != event.target.id) {
                  word_definition(event.target.innerHTML);
              }
          });
      })(jQuery);

      var cities = [];
      var imgData = [];
      var chart;
    
      fetch('{{ route("alerts.countries", "") }}/{{ $alert->id }}')
        .then((res) => res.json())
        .then((data) => {
          cities = data;

          window.imageSeries.data = [];
          window.imageSeriesGlobe.data = [];
          
          $.each(cities, function (key, value) {
              var city = [];
              city.color = value.color;
              city.title = value.title;
              city.latitude = parseFloat(value.latitude);
              city.longitude = parseFloat(value.longitude);
              city.priority = value.priority;
              city.tooltip_description = value.city;
              imgData.push(city);
          });
          
          window.imageSeries.data = imgData;
          window.imageSeriesGlobe.data = imgData;
      });

      function startMap() {
          // Themes begin
          am4core.useTheme(am4themes_kelly);
          // Themes end

          // Create map instance
          chart = am4core.create("chartdiv", am4maps.MapChart);
          chart.logo.height = 0;

          // Set map definition
          chart.geodata = am4geodata_worldLow;

          // Set projection
          chart.projection = new am4maps.projections.Miller();
          chart.background.fill = am4core.color("#0a1942"); //darkblue
          chart.background.fillOpacity = 1;

          // Create map polygon series
          let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
          
          chart.zoomControl = new 
          am4maps.ZoomControl();

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
          
          let circle = imageSeries.mapImages.template.createChild(am4core.Circle);
          circle.radius = 5;
          circle.propertyFields.fill = "color";

          circle.events.on("inited", function (event) {
              if(imgData.length === cities.length - 1) {
                  imageSeries.mapImages.template.showTooltipOn = "hover";
              }
          });

          imageSeries.data = imgData;
      }

      function startGlobe() {
          setTimeout(() => {
              document.getElementById('chartdivGlobe').style.width = '201px';
              setTimeout(() => {
                  document.getElementById('chartdivGlobe').style.width = '200px';
              });
          });

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
          chart.deltaLongitude = 20;
          chart.deltaLatitude = -20;

          var globeTimer = setInterval(() => {
              if(chart.deltaLongitude > 360) {
                  chart.deltaLongitude = 1;
              }
              chart.deltaLongitude += 3;
          }, 1);

          let globeDiv = document.getElementById('chartdivGlobe');
          globeDiv.onmouseover = () => {
              clearInterval(globeTimer);
          };
          globeDiv.onmouseout = () => {
              globeTimer = setInterval(() => {
                  if(chart.deltaLongitude > 360) {
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
          graticuleSeries.mapLines.template.stroke = am4core.color("#fff");
          graticuleSeries.fitExtent = false;
          graticuleSeries.mapLines.template.strokeOpacity = 0.2;
          graticuleSeries.mapLines.template.stroke = am4core.color("#fff");


          var measelsSeries = chart.series.push(new am4maps.MapPolygonSeries());
          measelsSeries.tooltip.background.fillOpacity = 0;
          measelsSeries.tooltip.background.cornerRadius = 20;
          measelsSeries.tooltip.autoTextColor = false;
          measelsSeries.tooltip.label.fill = am4core.color("#000");
          measelsSeries.tooltip.dy = -5;

          var measelTemplate = measelsSeries.mapPolygons.template;
          measelTemplate.fill = am4core.color("red");
          measelTemplate.strokeOpacity = 0;
          measelTemplate.fillOpacity = 0.75;
          measelTemplate.tooltipPosition = "fixed";


          var hs2 = measelsSeries.mapPolygons.template.states.create("hover");
          hs2.properties.fillOpacity = 1;
          hs2.properties.fill = am4core.color("#86240c");

          window.imageSeriesGlobe = chart.series.push(new am4maps.MapImageSeries());
          var imageSeriesTemplate = imageSeriesGlobe.mapImages.template;
          var circle = imageSeriesTemplate.createChild(am4core.Circle);
          circle.radius = 2;
          circle.fill = am4core.color("yellow");
          circle.stroke = am4core.color("yellow");
          circle.strokeWidth = 2;
          circle.nonScaling = true;
          circle.tooltipText = "{title}";

          imageSeriesTemplate.propertyFields.latitude = "latitude";
          imageSeriesTemplate.propertyFields.longitude = "longitude";

          imageSeriesGlobe.data = imgData;
      }

      am4core.ready(() => {
          startMap();
          startGlobe();
      });

      //fetch('{{ URL::to('/') }}'+'/data.json')
      fetch('{{ route("alerts.knowledgeMap", "") }}/{{ $alert->id }}')
        .then((res) => res.json())
        .then((data) => {
          const width = document.getElementById('knowledgeMap').scrollWidth;
          const height = document.getElementById('knowledgeMap').scrollHeight || 500;
          graph = new G6.TreeGraph({
            container: 'knowledgeMap',
            width,
            height,
            linkCenter: true,
            fitCenter: true,
            fitView: true,
            maxStep: 1,
            enabledStack: true,
            minZoom: 0.4,
            maxZoom: 20,
            groupType: 'rect',
            modes: {
              default: [
                {
                  type: 'collapse-expand',
                  onChange: function onChange(item, collapsed) {
                    const data = item.get('model').data;
                    data.collapsed = collapsed;
                    //setTimeout(function(){ console.log('fitview'); graph.fitView(); }, 1000);
                    //setTimeout(function(){ console.log('fitCenter'); graph.fitCenter(); }, 1000);
                    return true;
                  },
                },
                'drag-canvas',
                'zoom-canvas',
              ],
            },
            defaultNode: {
              size: 40,
              style: {
                fill: '#27adfb',
                stroke: '#27adfb',
              },
              labelCfg: {           // The configurations for the label
                style: {            // The style properties of the label
                  fontSize: 12,     // The font size of the label
                  fill: '#ffc600',     // The font size of the label
                  // ...            // Other style properties of the label
                }
              }
            },
            defaultEdge: {
              style: {
                stroke: '#A3B1BF',
                fill: '#fff'
              },
            },
            layout: {
              type: 'dendrogram',
              direction: 'LR',
              nodeSep: 20,
              rankSep: 100,
              radial: true,
            },
          });

          graph.node(function (node) {
            return {
              label: node.id,
            };
          });

          graph.data(data);
          graph.render();

        });

      function mapCenter(){
        graph.fitView();
        //graph.fitCenter();
      }

      function word_definition(word){
      
      $('#word_definition').modal('show');

        var url;
        url = "{{route('words.meaning', '') }}/"+word;

        $.ajax({
          url: url,
          type: 'GET',
          beforeSend: function(){
            $('#word_definition .meaning-container').html('<div class="loader">Loading...</div>');
          },
          success: function(result) {
            $('#word_definition .meaning-container').html(result);
            $("#task_reminder_modal .scroll-wrapper").mCustomScrollbar();
          },
          error: function(e){
            $('#word_definition .meaning-container').html(e);
          }
        });      
      }
    </script>
  </body>
</html>
