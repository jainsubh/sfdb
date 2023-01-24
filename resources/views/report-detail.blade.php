<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Report Detail Dashboard</title>
        @include('layouts.includes.master_head')
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
            #twitter-global-panel, #twitter-uae-panel, #monitoring-panel, #sector-panel, #countries-panel, #entities-panel{
                height: 290px;
            }
            .back-to-dashboard {
                text-align: right;
                margin: 5px;
                font-size:16px;
                font-weight:700;
                line-height:15px;
                cursor:pointer
            }
            .back-to-dashboard a {
                color:#28adfb
            }
            .back-to-dashboard a:hover {
                color:#fff
            }
            .country-list{
                height: 230px;
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
                @include('layouts.includes.alert-dashboard')
                <!-- alert navigation end -->
                <div class="row" style="padding: 10px 0">
                    <div class="col-10 col-xs-12">
                        <h3 style="margin-bottom: 0px;">Library</h3>
                    </div>
                    <div class="col-2 col-xs-12">
                        <div class="back-to-dashboard">
                            <a href="{{ route('report-overview') }}">
                                Back to Report Overview 
                                <i class="fa fa-share-square-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <section  class="row">
                    <div class="col-xs-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-10 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <article id="main-map-panel" class="module">
                                    <iframe src="{{ route('freeform_report.view_document',$report->ref_id) }}" title="testPdf" height="100%" width="100%"></iframe>
                                </article>
                            </div>
                            <div class="col-2 col-lg-8 col-md-12 col-xs-12">
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6 col-xs-12">
                                        <article id="countries-panel" class="module">
                                            <h3>COUNTRIES - CITIES</h3>
                                            <div class="row">
                                                <div class="col-12 col-xs-12">
                                                    <div class="scroll-wrapper country-list">
                                                        <div class="scroll-inner">
                                                            <div class="entities-items">
                                                                @if($report->report_countries)
                                                                    @foreach(@$report->report_countries as $country)
                                                                        <p>{{ $country->country->city }} - {{ Str::limit($country->country->capital,12) }} ({{ $country->country->country_name }})</p>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6 col-xs-12">
                                        <article id="countries-panel" class="module">
                                            <h3>Keywords</h3>
                                            <div class="row">
                                                <div class="col-12 col-xs-12">
                                                    <div class="entities-items">
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>  
                                </div>        
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        @include('layouts.includes.master_footer_scripts')
        <script>
            $(document).ready(function() {
                $(".scroll-wrapper").mCustomScrollbar();
            });

    </body>
</html>