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
                        <div class="interview-list ">
                            <div class="interview-head">
                                <h3 class="text-center interview-{{$v->id}}">{{$v->name}}</h3>
                                <div class="interview-thumbnail">
                                    <div class="interview-thumbnail-inner">
                                        <img src="/{{$v->preview_image?$v->preview_image:'app/interview_image/no-image.png'}}">
                                    </div>
                                </div>
                            </div>
                            <div class="inerview-body text-center">
                                <p class="text-lefta" style="min-height:50px;">{{$v->description}}</p>
                                <h6>Close on : {{date('d.m.Y',strtotime($v->ctt))}}</h6>
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
//            const constraints = {audio: true,video: true};
            const constraints = {audio: true,video: true};

            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            
        } catch (e) {
            console.log(e.toString() )
            alert('Please check  your camera and microphone - (' +e.toString() + ')');
            return false;
        }
        
        location.href = '/home/interview/' + id;
    }
</script>
@endsection