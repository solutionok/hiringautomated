 <!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>{{env('APP_NAME')}}</title>

        <!-- Bootstrap core CSS -->
        <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template -->
        <link href="/assets/stylesheets/front.css?190115" rel="stylesheet">

        @yield('css')
    </head>

    <body class="{{isset($pageClass)?$pageClass:''}}">
        <!--pre headers-->
        <!--<div class="pre-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>Email : info@hiringautomated.com</h6>
                    </div>
                    <div class="col-sm-6">
                        <ul class="text-right">
                            <li>
                                <a href="#">Contact Sales</a>
                            </li>
                            <li>
                                <a href="#">Get Support</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
        
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <a href="/" class="logo">
                            <img src="/assets/images/logo.png">
                        </a>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <ul class="text-right">
                            <li>
                                <a href="/home/about">ABOUT US</a>
                            </li>
                            <li>
                                <a href="/home/product">PRODUCT</a>
                            </li>
                            <li>
                                <a href="#">SUPPORT</a>
                            </li>
                            <li>
                                <a href="#">CONTACT</a>
                            </li>
                            <li>
                                @if(!isset(auth()->user()->isadmin))
                                <a href="/login" class="my-account">SIGN IN</a>
                                @elseif(auth()->user()->isadmin==0)
                                <a href="/home/mypage" class="my-account">MY ACCOUNT</a>
                                @else
                                <a href="/admin" class="my-account">MY ACCOUNT</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        @yield('content')
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <h4>© Pixxy Studio. All Right Reserved 2019.</h4>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <ul class="list-inline text-right">
                            <li class="item">
                                <a href="#" class="fa fa-facebook"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-twitter"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-google-plus"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-instagram"></a>
                            </li>
                            <li class="item">
                                <a href="#" class="fa fa-youtube"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="/assets/vendor/jquery/jquery.min.js"></script>
        <script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        @yield('js')
    </body>
</html>