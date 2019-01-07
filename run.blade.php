<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="shortcut icon" href="/images/favicon.png">
        <link rel="apple-touch-icon" href="/images/favicon.png">

        <title>{{env('APP_NAME')}}</title>
        
        <!-- stylesheet css -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/fontawesome5.6.3/css/all.min.css">
        <link rel="stylesheet" href="/css/nivo-lightbox.css">
        <link rel="stylesheet" href="/css/nivo_themes/default/default.css">
        <link rel="stylesheet" href="/css/style.css?181229">
        
        <!-- google web font css -->
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,600,700' rel='stylesheet' type='text/css'>
        
        <style>
            .headbar{
                background: #f96332;
                padding: 5px 20px; 
                color: #fff; 
                position: relative;
                margin-bottom: -1px;
            }
            .headbar ul{
                list-style: none;
                position: absolute;
                right:20px;
                top:5px;
                font-size:14px;
                line-height: 30px;
            }
            .headbar ul li{
                float: left;
                margin-left: 15px;
                padding-right:15px;
            }
            .headbar ul li a{
                color: snow;
                text-decoration: none;
            }
            .problem-list{
                margin: 20px 0;
                padding:0;
                list-style: none;
                font-size: 24px;
                line-height: 40px;
                
            }
            
            .problem-list li{
                border-bottom: dashed 1px #f96332;
            }
            .problem-list li:first-child{
                border-top: solid 1px #f96332;
            }
            
        </style>
        
    </head>
    <body data-spy="scroll" data-target=".navbar-collapse">

        <!-- navigation -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon icon-bar"></span>
                        <span class="icon icon-bar"></span>
                        <span class="icon icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand smoothScroll">Smart Interview</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#home" >HOME</a></li>
                        <li><a href="#service" >INTERVIEW</a></li>
                        <li><a href="#about" >ABOUT</a></li>
                        <li><a href="#team" >TEAM</a></li>
                        @if(Auth::check())
                        <li><a href="/home/mypage">MYPAGE</a></li>
                        <li><a href="/logout">LOGOUT</a></li>
                        @else
                        <li><a href="/login">LOGIN/REGISTER</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>		

        <!-- service section -->
        <div class="quiz" style="margin-top: 100px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h3 class="headbar">
                            Question : {{$step}} of {{$maxStep}}
                            
                            <ul class="btn-list">
                                <li class="timelimit">
                                    <i class="fa fas fa-clock"></i> 
                                    <span>Time Limit - {{date('i : s', $quiz->qtime)}}</span>
                                </li>
                                @if($quiz->qtype=='3' || $quiz->qtype=='4')
                                <li class="preparetime">
                                    <i class="fa fas fa-clock"></i> 
                                    <span>Preparation Time - {{date('i : s', $quiz->qprepare)}}</span>
                                </li>
                                <li id="record-trigger">
                                    <a href="javascript:;" status='not-inited'>
                                        <i class="fa fa-play-circle"></i> 
                                        Start Record
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="javascript:;" id="go-next">
                                        <i class="fa fa-arrow-right"></i> 
                                        {{$step==$maxStep?'Complete Interview':'Save and Next'}}
                                    </a>
                                </li>
                            </ul>
                        </h3>
                        
                        <h4 class="description">{{$quiz->description}}</h4>
                        
                        @if($quiz->attach_media)
                        <div class="col-md-12 col-sm-12 problemarea">
                            <?php $ext = pathinfo($quiz->attach_media)['extension'] ?>
                            @if($ext=='mp3'||$ext=='mp4')
                            <video class="attached-media" controls="" name="media" style="{{$ext=='mp3'?'width:100%;height:50px':'max-height:300px;'}}">
                                <source src="/{{$quiz->attach_media}}" type="{{$ext=='mp3'?'audio/mp3':'video/mp4'}}">
                            </video>
                            @else
                            <img class="attached-media" src="/{{$quiz->attach_media}}">
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form id="quiz-form" action="/home/runsave" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($quiz->qtype=='3' || $quiz->qtype=='4')
                            <video id="record-cam" autoplay style="width: 100%;height:auto;"></video>
                        @else
                            <ul class="problem-list">
                            <?php $qdetail = json_decode($quiz->qdetail)?>
                            @foreach($qdetail->txt as $i=>$txt)
                            <li>
                                <input type="{{$quiz->qtype=='1'?'checkbox':'radio'}}" name="check-items">
                                {{$txt}}
                            </li>
                            @endforeach
                            </ul>
                        @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- divider section -->
        <div class="container">
            <div class="row">
                <div class="col-md-1 col-sm-1"></div>
                <div class="col-md-10 col-sm-10">
                    <hr>
                </div>
                <div class="col-md-1 col-sm-1"></div>
            </div>
        </div>


        <!-- copyright section -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <p>Copyright &copy; {{date('Y')}} Smart Interview</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- scrolltop section -->
        <a href="#top" class="go-top"><i class="fa fa-angle-up"></i></a>

        <!-- javascript js -->	
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootbox.min.js"></script>
        
        <script>
            var timeLimit = {{$quiz->qtime}};
            var preparationTime = {{$quiz->qprepare}};
            function tf(s){
                if(s>59){
                    return Number(s/60).toFixed(0)+' : ' + (s%60>9?s%60:('0'+s%60));
                }
                
                return '00 : ' + (s%60>9?s%60:('0'+s%60));
            }
        </script>
        @if($quiz->qtype=='3' || $quiz->qtype=='4')
        <script src="/js/adapter.latest.js"></script>
        <script src="/js/interviewmain.js"></script>
        @else
        <script>
            var timeLimitInterval = setInterval(function(){
                if(timeLimit<=0){
                    clearInterval(timeLimitInterval);
                    goNext();
                    return;
                }
                timeLimit--;
                $('.timelimit span').text('Time Limit - '+ tf(timeLimit) +'');
            },1000);
            
            function goNext(){
                var checked = [];
                $('.problem-list li input').each(function(i, el){
                    checked.push($(el).prop('checked')?1:0)
                });
                    
                $.post('/home/runsave', {checked:checked,_token:$('input[name="_token"').val()}, function(r){
                    bootbox.alert(r, function(){
                        location.reload();
                    });
                })
            }
            
            $('#go-next').click(function(){
                $(this).hide();
                goNext();
            })
        </script>
        @endif
    </body>
</html>