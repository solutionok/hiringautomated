<!doctype html>
<html class="fixed">
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="smart interview" />
        <meta name="description" content="Automatedhiring system">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <title>{{env('APP_NAME')}}</title>

        @include('layouts.css')
        <style>
            
        </style>
    </head>
    <body class="login-body">
        <a href="/" class="login-logo">
            <img src="/assets/images/login-logo.png">
        </a>
        <div class="row">
            <div class="col-md-7 col-sm-12 col-md-offset-5 col-sm-offset-0">
                <section class="body-sign">
                    <div class="center-sign">
                        <a href="/" class="logo pull-left">
                            <img src="/assets/images/logo.png" height="54">
                        </a>
                        <div class="panel panel-sign">
                            <div class="panel-title-sign mt-xl text-right">
                                <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                            </div>
                            <div class="panel-body">
                                <form method="post">
                                    @csrf
                                    <div class="form-group mb-lg">
                                        <label>Username</label>
                                        <div class="input-group input-group-icon">
                                            <input name="email" type="text" class="form-control input-lg" required="">
                                            <span class="input-group-addon">
                                                <span class="icon icon-lg">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group mb-lg">
                                        <div class="clearfix">
                                            <label class="pull-left">Password</label>
                                            <!--<a href="pages-recover-password.html" class="pull-right">Lost Password?</a>-->
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <input name="password" type="password" class="form-control input-lg" required="">
                                            <span class="input-group-addon">
                                                <span class="icon icon-lg">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="checkbox-custom checkbox-default">
                                                <input id="RememberMe" name="remember_me" type="checkbox">
                                                <label for="RememberMe">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <p class="text-center text-dark mt-md mb-md">© Copyright {{date('Y')}}. All Rights Reserved.  Powered By <a href="javascript:;">VirtuIT</a></p>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>