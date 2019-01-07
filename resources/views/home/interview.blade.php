@extends('layouts.page')

@section('css')
<link href="/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<style>
    .all-icons .font-icon-detail{
        padding: 5px;
    }
    .all-icons .font-icon-detail img{
        width: 100%;
    }
    .all-icons h6{
        font-weight: bold;
        
    }
    .font-icon-detail{border: solid 1px #ddd;}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h5 class="panel-title">
                    My Interviews
                </h5>
            </div>
            <div class="panel-body all-icons">
                <div class="row">
                    @foreach  ($interviewList as $v)
                    <div class="font-icon-list col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="font-icon-detail text-center">
                            @if($v->preview_image)
                            <img src="/{{$v->preview_image}}">
                            @else
                            <i class="now-ui-icons business_badge" style="font-size: 194px;"></i>
                            @endif
                            <h4>{{$v->name}}</h4>
                            <p class="text-lefta">{{$v->description}}</p>
                            <h6>Close on : {{$v->ctt}}</h6>
                            <h6>Total Score : {{$v->grade}}</h6>
                            <h6>My  Score : {{intval($v->mygrade)}}</h6>
                            <div>
                                @if($v->hisid)
                                <a class="btn btn-sm btn-warning" href="/home/review/{{$v->hisid}}">View Review</a>
                                @elseif(deadlineCheck($v->ctt))
                                <button class="btn btn-sm btn-warning" onclick="startInterview({{$v->id}})">Start Interview</button>
                                @else
                                <a class="btn btn-sm btn-dark" href="javascript:;">Deadline Over</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="/assets/javascripts/adapter.latest.js"></script>
<script type="text/javascript">
    async function startInterview(id){
        try {
            const constraints = {audio: {echoCancellation: {exact: true}},video: {}};

            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            
        } catch (e) {
            alert('Please check  your camera and microphone - (' +e.toString() + ')');
            return false;
        }
        
        location.href = '/home/interview/' + id;
    }
</script>
@endsection