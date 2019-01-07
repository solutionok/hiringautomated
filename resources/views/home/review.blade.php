@extends('layouts.page')
@section('css')
<style>
    .panel-heading .toolbar{
        padding-top:15px;
        font-size: 18px;
    }
    .panel-heading .toolbar span{
        color:#fa7a50;font-weight: bold;margin-right: 15px;
    }
    .panel-heading .toolbar progress{
        height: 18px;
    }
    .candidate-box .panel-body img{
        width: 100px;height:100px;float:left;margin:0 10px 10px 0;
    }
    .step-box table td a{
        color: #888;
    }
    
    .quiz-box .panel-body h5{
        border-bottom:solid 1px #fa7a50;position:relative;
    }
    .quiz-box .panel-body h5 div{
        position:absolute;right:5px;top: -10px;text-align: right;
    }
    .quiz-box #record-cam{
        width: 100%;height:auto;
    }
    .quiz-box .problem-list{
        list-style: none;
    }
    .quiz-box .quiz h5{
        border-bottom:solid 1px #fa7a50;margin-top:10px;
    }
    td.active-step a{
        color: #f96332!important;
        font-weight: bold!important;
    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-8">
                        <h4 class="panel-title">
                            {{empty($interview)?'Interview damaged':$interview->name}}
                        </h4>
                    </div>
                    <div class="col-sm-4 text-right">
                        Total Score :  <span title="evaluated interview score/maximium score">{{$history->grade}} / {{$history->availgrade}}</span>
                        <progress value="{{$history->grade}}" max="{{$history->availgrade}}"></progress>

                        <button onclick="location.href='/home/interview'" class="btn btn-sm btn-warning" style="margin-top:-1px;margin-left: 10px;"><i class="fa fa-arrow-circle-left"></i> Interview List</button>
                    </div>
                </div>
                
            </div>
            <div class="panel-body">
                <div class="row">
                    
                <div class="col-md-5">
                    <div class="panel candidate-box">
                        <div class="panel-body">
                            <img src="/{{!empty($candidate->photo)?$candidate->photo:'app/candidate/user.jpg'}}">
                            <p>Name : {{$candidate->name}}</p>
                            <p>Interview Time : {{$history->rundate}}</p>
                            <p>Evaluated : {{empty($history->evaluated)?'Not yet':'Yes'}}</p>
                        </div>
                    </div>
                    <div class="panel step-box">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <th>
                                        Questions 
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($steps as $i=>$q)
                                        <tr>
                                            <td class='{{$step==($i+1)?'active-step':''}}'><a href="/home/review/{{$history->id}}/{{$i+1}}">{{substr($q->description,0, 60)}}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="panel quiz-box">
                        <div class="panel-body">
                            @if($step)
                                <!--Answer Head-->
                                <h5>
                                    Answer
                                    <div>
                                        Score : <span title="Evaluated score / Maximium score">{{empty($quiz->mark)?'0':$quiz->mark}} / {{empty($quiz->grade)?'0':$quiz->grade}}</span>
                                        @if(auth()->user()->isadmin==2)
                                        &nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-primary btn-sm set-mark-trigger" 
                                                _id="{{$quiz->id}}" 
                                                _history="{{$history->id}}" 
                                                _avail_grade="{{$quiz->grade}}" 
                                                {{$quiz->qtype=='3' || $quiz->qtype=='4'?'isrecord':''}}>Set Quiz Review</button>
                                        @endif
                                    </div>
                                </h5>

                                <!--Answer Body-->
                                @if($quiz->qtype=='3' || $quiz->qtype=='4')
                                    @if(isset($quiz->record))
                                    <video id="record-cam" src="/{{$quiz->record}}" controls=""></video>
                                    @else
                                    <img src="/assets/images/no-answer.jpg" style="width:100%;">
                                    @endif
                                    
                                @else
                                    <?php $qdetail = json_decode($quiz->qdetail)?>
                                    @if(count($qdetail->txt))
                                    <ul class="problem-list">
                                    @foreach($qdetail->txt as $i=>$txt)
                                    <li>
                                        <input type="{{$quiz->qtype=='1'?'checkbox':'radio'}}" name="check-items" disabled {{$qdetail->ch[$i]==1?'checked':''}}>
                                        {{$txt}}
                                    </li>
                                    @endforeach
                                    </ul>
                                    @else
                                    <img src="/assets/images/no-answer.jpg" style="width:100%;">
                                    @endif
                                @endif
                                
                                <!--Quiz-->
                                <div class="quiz">
                                    <h5>Question</h5>
                                    <blockquote>{{$quiz->description}}</blockquote>
                                    @if($quiz->attach_media)
                                    <?php $ext = pathinfo($quiz->attach_media)['extension'] ?>
                                    @if($ext=='mp3'||$ext=='mp4')
                                    <video style="width:100%;" controls="" name="media" style="{{$ext=='mp3'?'width:100%;height:50px':'max-height:300px;'}}">
                                        <source src="/{{$quiz->attach_media}}" type="{{$ext=='mp3'?'audio/mp3':'video/mp4'}}">
                                    </video>
                                    @else
                                    <img class="attached-media" src="/{{$quiz->attach_media}}">
                                    @endif
                                    @endif
                                </div>
                            @endif 
                            
                            
                            <h5>Summary</h5>
                            @if(count($reviews))
                                @foreach($reviews as $re)
                                    <p class="blockquote blockquote-warning">
                                        <img src="/{{$re->photo?$re->photo:'app/assessor/user.jpg'}}" style="width:30px;height:30px;margin:10px;"/>
                                        <b>{{$re->assessorn}}</b>
                                        <br>
                                        <span style="color:#555;">
                                            <?php echo nl2br($re->comment)?>
                                        </span>
                                    </p>
                                    
                                @endforeach
                            @else
                            <p class="text-center blockquote blockquote-primary" style="">Not yet!</p>
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