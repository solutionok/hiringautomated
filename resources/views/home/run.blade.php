 @extends('layouts.page')
@section('css')
<style>
    .panel-heading{padding-bottom: 0;padding-top: 5px;}
    .timer input{  
        border-radius: 20px;
        width: 120px;
        color: orange;
        font-weight: bold;
        border: solid 3px;
        outline: none;
        margin-left:15px;
        text-align: center;
    }
    .candidate-box img{max-height: 100px;margin: 0 10px;float: left;}
    .candidate-box table{line-height: 3rem;}
    .question-box .description{margin-bottom:10px;}
    .question-box .attached-media{width:100%;}

    .answer-box .problem-list{list-style:none;padding-left:0;}
    .answer-box .problem-list .pdesc{margin-left: -3px;font-size: 1.5rem;    line-height: 4rem;}

    .answer-box .btn{margin-top: 0;}

    .answer-box #record-cam{
        width:100%;
    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading text-right" style="padding-right:20px;">
                <div class="row">
                    <div class="col-sm-7">
                        <h4 class="text-left">
                            {{$interview->name}}
                        </h4>
                    </div>
                    <div class="col-sm-5">
                        <p class="timer rasp-time">
                            <i class="fa fas fa-clock"></i> 
                            Response Time <input type="text" value="{{date('i : s', $quiz->qtime)}}" readonly="">
                        </p>
                        @if($quiz->qtype=='3' || $quiz->qtype=='4')
                        <p class="timer prepare-time">
                            <i class="fa fas fa-clock"></i> 
                            Preparation Time <input type="text" value="{{date('i : s', $quiz->qprepare)}}" readonly="">
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel candidate-box">
                            <div class="panel-body">
                                <div class="row">
                                    <img src="/{{!empty(auth()->user()->photo)?auth()->user()->photo:'app/candidate/user.jpg'}}">
                                    <table>
                                        <tr><td>Name : </td><td>{{auth()->user()->name}}</td></tr>
                                        <tr><td>E-mail : </td><td>{{auth()->user()->email}}</td></tr>
                                        <tr><td>Phone : </td><td>{{auth()->user()->phone}}</td></tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="panel question-box">
                            <div class="panel-heading">
                                <h5>
                                    Question : {{$step}} of {{$maxStep}}
                                </h5>
                            </div>
                            <div class="panel-body">
                                <div class="description">{{$quiz->description}}</div>
                                @if($quiz->attach_media)
                                <div class="questions">
                                    <?php $ext = pathinfo($quiz->attach_media)['extension'] ?>
                                    @if($ext=='mp3'||$ext=='mp4')
                                    <video class="attached-media" controls="" name="media" style="{{$ext=='mp3'?'width:100%;height:50px':''}}">
                                        <source src="/{{$quiz->attach_media}}" type="{{$ext=='mp3'?'audio/mp3':'video/mp4'}}">
                                    </video>
                                    @else
                                    <img class="attached-media" src="/{{$quiz->attach_media}}">
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="panel answer-box">
                            <div class="panel-heading row">
                                <div class="col-xs-12 col-sm-4">
                                    <h5>
                                        Answer
                                    </h5>
                                </div>
                                <div class="col-xs-12 col-sm-8 text-right">
                                    @if($quiz->qtype=='3' || $quiz->qtype=='4')
                                    <button href="javascript:;" id="record-trigger" class='btn btn-warning'>
                                        <i class="fa fa-play-circle"></i> 
                                        Start Record
                                    </button>
                                    @endif
                                    <button href="javascript:;" id="go-next" class='btn btn-warning'>
                                        <i class="fa fa-arrow-right"></i> 
                                        {{$step==$maxStep?'Complete':'Next'}}
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                @if($quiz->qtype=='3' || $quiz->qtype=='4')
                                <video id="record-cam" autoplay  muted="muted"></video>
                                @else
                                <ul class="problem-list">
                                    <?php $qdetail = json_decode($quiz->qdetail) ?>
                                    @foreach($qdetail->txt as $i=>$txt)
                                    <li class="row">
                                        <div class="col-sm-1">
                                            <input type="{{$quiz->qtype=='1'?'checkbox':'radio'}}" name="check-items" class="form-control">
                                        </div>
                                        <div class="col-sm-11 pdesc" style="margin-left:-2%;">{{$txt}}</div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@csrf
@endsection

@section('scripts')
<script src="/plugins/jqueryoverlay/loadingoverlay.min.js"></script>
<script>
    var timeLimit = {{$quiz -> qtime}};
    var preparationTime = {{$quiz -> qprepare}};
    
    function tf(s){
        if (s > 59){
            return Math.floor(s / 60) + ' : ' + (s % 60 > 9 ? s % 60:('0' + s % 60));
        }

        return '00 : ' + (s % 60 > 9?s % 60:('0' + s % 60));
    }
    
    function showOveray(msg){
        $.LoadingOverlay("show", {
            image       : "",
            text        : msg
        });
    }
    
    function hideOveray(msg){
        $.LoadingOverlay("text", msg);
    }
    
</script>
@if($quiz->qtype=='3' || $quiz->qtype=='4')
<script src="/assets/javascripts/adapter.latest.js"></script>
<script src="/assets/javascripts/interviewmain.js?190112"></script>
@else
<script>
  var timeLimitInterval = setInterval(function () {
  if (timeLimit <= 0) {
    clearInterval(timeLimitInterval);
    goNext(true);
    return;
  }
  timeLimit--;
  $('.rasp-time input').val(tf(timeLimit));
}, 1000);
function goNext(automated) {
  showOveray("Saving in Progress");
  var checked = [];
  $('.problem-list li input').each(function (i, el) {
    checked.push($(el).prop('checked') ? 1 : 0)
  });
  $.post('/home/runsave', { checked: checked, _token: $('input[name="_token"').val() }, function (r) {
      hideOveray(r);
      setTimeout(function () {
        location.reload();
      }, 2000);
  })
}

$('#go-next').click(function () {
  $(this).hide();
  goNext();
})
</script>
@endif
@endsection