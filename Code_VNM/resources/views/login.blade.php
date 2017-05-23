<!doctype html>
<html lang="en" class="fullscreen-bg">

    <head>
        <title>Login | HeavenCoffee</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="{!!asset('css/bootstrap.css')!!}">
        <link rel="stylesheet" href="{!!asset('css/main.css')!!}">
        
        <script src="{!!asset('vendors/jquery/dist/jquery.js')!!}"></script>
    </head>
    <body>
        <style type="text/css">
            body, html {
                height: 100%;
                background-repeat: no-repeat;
                background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
            }
        </style>
        <div class="container">
            <div class="card card-container" style="text-align: center">
                <img id="profile-img" class="profile-img-card" src="{!!asset('images/logo-hc.jpg')!!}" />
                <p id="profile-name" class="profile-name-card"></p>
                <form class="form-signin" method="POST" action="{!!url('/login')!!}">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <span></span>
                    <div style="width: 300px">
                        @if(isset($errMess))
                        <label id="lblLoginMessage" class="label-err" >{!!$errMess!!}</label>
                        @else
                        <label id="lblLoginMessage" class="label-err" ></label>
                        @endif
                    </div>
                    @if(isset($username))
                    <input id="txtUsername" name="txtUsername" class="form-control"  value="{!!$username!!}" autofocus>
                    @else
                    <input id="txtUsername" name="txtUsername" class="form-control" placeholder="Tên đăng nhập" value="" autofocus>
                    @endif
                    <input type="password" id="txtPassword" name="txtPassword" class="form-control" value="" placeholder="Mật khẩu">
                    <button class="btn btn-lg btn-primary btn-block btn-signin" onclick="return checkLogin()" type="submit">Đăng nhập</button>
                </form><!-- /form -->
            </div><!-- /card-container -->
        </div><!-- /container -->
    </body>
    <script type="text/javascript">
        function checkLogin() {
            if ($('input#txtUsername').val().trim() === '' || $('input#txtPassword').val().trim() === '') {
                $('label#lblLoginMessage').text('Vui lòng nhập đủ tên đăng nhập, mật khẩu');
                $('div#errLoginMessage').show();
                return false;
            } else {
                return true;
            }
        }
    </script>
</html>
