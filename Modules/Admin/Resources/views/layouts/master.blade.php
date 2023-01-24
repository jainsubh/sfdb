<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME') }}</title>
        <!-- Fonts Icon css -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet"> 
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css') }}">
        <!-- Ladda button css -->
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
        @yield('before-css')
        <!-- Theme css -->
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/toastr.css')}}">
        <!-- Custom css -->
        <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/custom.css') }}">
        <style type="text/css">
        .swal-button:not([disabled]):hover{
            background-color: #024495 !important;
        }

        .btn-danger:not([disabled]):hover{
            background-color: #ef2415 !important;
        }
        .dropzone .dz-preview .dz-image{
            border-radius: 0px !important;
        }
        </style>
        <!-- Page css -->
        @yield('page-css')
    </head>
    <body class="text-left">
        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">
            <div class="loader spinner-bubble spinner-bubble-primary">
            </div>
        </div>
        <!-- Pre Loader end  -->

        <!-- ============ Compact Layout start ============= -->
        <!--=============== Start app-admin-wrap ================-->
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            @include('admin::layouts.compact-sidebar')
            <!-- ============ end of left sidebar ============= -->
            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap d-flex flex-column">
                @include('admin::layouts.header-menu')
                <!-- ============ end of header menu ============= -->
                <div class="main-content">
                    @yield('main-content')
                </div>
                
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        {{-- @include('admin::layouts.customizer') --}}
        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
        <script type="text/javascript">
            function dateToTimestamp(date){
                return new Date(date).getTime()/1000;
            }

            function unixToDateTime(unixTimestamp){
                var months_arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                var dt = new Date(unixTimestamp*1000);
                var year = dt.getFullYear();
                var month = months_arr[dt.getMonth()]
                var day = dt.getDate();
                var hr = dt.getHours();
                var m = "0" + dt.getMinutes();
                var s = "0" + dt.getSeconds();
                return month+' '+day+', '+year+' '+hr+ ':' + m.substr(-2);  
            }
        </script>
        {{-- page specific javascript --}}
        @yield('page-js')
        {{-- Ladda button scripts --}}
        <script src="{{asset('assets/js/vendor/toastr.min.js')}}"></script>
        <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
        <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
        <script src="{{asset('assets/js/ladda.script.js')}}"></script>
        {{-- theme javascript --}}
        <script src="{{asset('assets/js/script.js')}}"></script>
        {{-- sidebar javascript --}}
        <script src="{{asset('assets/js/sidebar.compact.script.js')}}"></script>
        <script src="{{asset('assets/js/customizer.script.js')}}"></script>
        
        <script type="text/javascript">
            (function($) {
                toastr.options = {
                    positionClass : 'toast-bottom-right',
                }
            })(jQuery);

            function confirmDelete(url, dt){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    closeOnEsc: true,
                    closeOnClickOutside: true,
                    className: '',
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: 'cancel',
                            visible: true,
                            className: "btn btn-info",
                            closeModal: true,
                        },
                        catch: {
                            text: "Delete",
                            value: "ok",
                            className: "btn btn-danger",
                        },
                    }
                }).then(function (value) {
                    switch(value){
                        case "ok":
                            $.ajax({
                                url: url,
                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                type: 'DELETE',
                                success: function(result) {
                                    if(result == 'success'){
                                        if(dt.rows({ selected: true }).count() > 1)
                                        dt.rows( { selected: true } ).remove().draw();
                                        else
                                        dt.row( { selected: true } ).remove().draw( false );
                                        toastr.success("Deleted successfully");
                                    }else{
                                        toastr.error("Failed to delete");
                                    }
                                },
                                error: function(response){
                                    console.log(response.responseJSON);
                                    toastr.error(response.responseJSON);
                                }
                            });
                        default:
                            return true;
                    }
                    
                }, function (dismiss) {
                });
            }

            function confirmRestore(url, dt){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    closeOnEsc: true,
                    closeOnClickOutside: true,
                    className: '',
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: 'cancel',
                            visible: true,
                            className: "btn btn-info",
                            closeModal: true,
                        },
                        catch: {
                            text: "Restore",
                            value: "ok",
                            className: "btn btn-danger",
                        },
                    }
                }).then(function (value) {
                    switch(value){
                        case "ok":
                            $.ajax({
                                url: url,
                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                type: 'Post',
                                success: function(result) {
                                    if(result == 'success'){
                                        dt.row( { selected: true } ).remove().draw( false );
                                        toastr.success("Restored successfully");
                                    }else{
                                        toastr.error("Failed to Restore");
                                    }
                                    
                                }
                            });
                        default:
                            return true;
                    }
                    
                }, function (dismiss) {
                });
            }
        </script>
        @yield('bottom-js')
        @include('admin::flash.message')
    </body>
</html>