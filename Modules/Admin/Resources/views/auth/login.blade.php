<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ env('APP_NAME') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <style>
            body{
                overflow: hidden;
            }
            .logo{
                font-size: 40px; 
                font-family: sans-serif; 
                font-weight: 700; 
                color: #003473;
            }

            .auth-content { min-width: 350px !important; }

            #video{
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
            }

            .captcha_icon{
                font-size: 18px; 
                vertical-align: middle;
            }

            .captcha_icon:hover{
                color: #008755;
            }
            
        </style>
    </head>
    <body>
        <video id="video" oncontextmenu="return false;" autoplay loop muted>   
            <source src="{{asset('assets/images/SFvideo.mp4')}}" type="video/mp4" />
            <track src="" kind="subtitles" srclang="en" label="English" />
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
                                <h1 class="mb-3 text-18">Sign In</h1>
                                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input id="email"
                                            class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" type="password"
                                            class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Captcha</label>
                                        <div>
                                            <?php echo captcha_img() ?>
                                            <a href="javascript:void(0)" class="captcha_icon" id="regen_captcha"> <i class="fa fa-refresh"></i> </a>
                                            <input type="text" name="captcha" class="form-control form-control-rounded @error('captcha') is-invalid @enderror" autocomplete="false" style="float:right; width: 55%">
                                            
                                            @error('captcha')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me test') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-rounded btn-info btn-block mt-2">Sign In</button>
                                    </div>
                                </form>
                                @if (Route::has('password.request'))
                                <div class="mt-3 text-center">
                                    <a href="{{ route('password.request') }}" class="text-muted">
                                        <u>
                                            Forgot Password?
                                        </u>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet">
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script>
            var vid = document.getElementById("video");
            vid.playbackRate = 0.5;

            $('#regen_captcha').on('click',function(){
                $(this).prev().attr('src','/captcha/default?'+Math.random());
            });

        </script>
    </body>
</html>