<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ env('APP_NAME') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .logo{
                font-size: 40px; 
                font-family: sans-serif; 
                font-weight: 700; 
                color: #003473;
                }
            .auth-content{
                min-width: 350px !important;
                max-width: 350px !important;
            }
            body{ overflow: hidden; }
            #video{
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
            }
        </style>
    </head>
    <body>
        <video id="video" oncontextmenu="return false;" src="{{asset('assets/images/SFvideo.mp4')}}" type="video/mp4" autoplay loop muted>    
        </video>
        <div class="auth-layout-wrap">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <div class="auth-logo text-center mb-4">
                                    <span class="logo"> SFCA </span>
                                </div>

                                <h1 class="mb-3 text-18">Two factor Authentication</h1>

                                <form method="POST" action="{{  route('verify.store') }}">
                                    @csrf

                                    <div class="form-group input-group mb-3 ">
                                        
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <em class="fa fa-key"></em>
                                                </span>
                                            </div>
                                            <input name="two_factor_code" type="text" class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" 
                                            required autofocus placeholder="Two Factor Code">

                                            @if($errors->has('two_factor_code'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('two_factor_code') }}
                                                </div>
                                            @endif
                                    </div>
                                    <p class="text-muted">
                                        You have received an email which contains two factor login code.
                                        If you haven't received it, click <a href="{{ route('verify.resend') }}"><strong>here</strong></a>.
                                    </p>
                                    <p class="text-muted">
                                        In case you want to cancel the session and go back to login page, 
                                        <a href="{{ route('verify.cancel') }}" style="color:red"><strong>click here</strong></a>.
                                    </p>
                                    <button class="btn btn-rounded btn-info btn-block mb-3">Verify</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script>
            var vid = document.getElementById("video");
            vid.playbackRate = 0.5;

        </script>
    </body>
</html>