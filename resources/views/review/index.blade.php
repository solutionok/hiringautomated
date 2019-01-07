@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<style>
    .panel img{
        max-height: 110px;
    }
    .panel hr{
        margin: 3px;;
    }
    
    .header .search{
        width: auto!important;
    }
@media only screen and (max-width: 900px){
    .header .search {
        display: none;
    }
}
    #date-search-form input{background: #fff;width: 150px;text-align:center;}
    .input-daterange{border-left: solid 1px #ddd;border-top-left-radius: 8px;border-bottom-left-radius: 8px;}
    .ui-slider.ui-widget-content{background: #fff!important;}
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-sm-8">
        <form id="date-search-form">
            <div class="form-group">
                @if(!$searchInterviewId)
                <label class="col-md-3 control-label text-center"><h5 style="font-weight:bold;">Date range</h5></label>
                <div class="col-md-6">
                    <div class="input-daterange input-group" data-plugin-datepicker="">
                        <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control" name="startd" readonly="" value="{{$searchDateRange[0]}}">
                        <span class="input-group-addon">to</span>
                        <input type="text" class="form-control" name="endd" readonly="" value="{{$searchDateRange[1]}}">
                    </div>
                </div>
                @else
                <?php
                $_range = explode('/', $range);
                ?>
                <div class="col-md-12">
                    <div class="m-md slider-primary" data-plugin-slider data-plugin-options='{"values":[{{$_range[0]}},{{$_range[1]}}],"range":true,"max":100}' data-plugin-slider-output="#listenSlider2">
                        <input id="listenSlider2" type="hidden" value="{{$range}}" />
                    </div>
                </div>
                <label class="col-md-3 control-label text-center">Score Range</label>
                <p class="output2">From <b class="min text-danger">{{$_range[0]}}</b>% To <b class="max text-danger">{{$_range[1]}}</b>%</p>
                @endif
            </div>
        </form>
    </div>
    <div class="col-sm-4 text-right">
        
        @if($searchInterviewId)
        <button class="btn btn-primary download-csv" data-toggle="modal" data-target=".interview-modal">
            <i class="fa fa-download"></i>
            Download CSV
        </button>
        @endif
    </div>
</div>
<div class="row">
    
    @foreach($history as $i=>$q)
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-5 text-right">
                        <img src="/{{$q->photo?$q->photo:'app/candidate/user.jpg'}}">
                    </div>
                    <div class="col-sm-7">
                        <h5>{{$q->usern}}</h5>
                        <p><i class="fa fa-envelope-square"></i> {{$q->email}}</p>
                        <p><i class="fa fa-phone"></i> {{$q->phone}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-5 text-right"><p>Interview</p></div>
                    <div class="col-sm-7"><p>{{$q->interviewn}}</p></div>
                </div>
                
                <div class="row">
                    <div class="col-sm-5 text-right"><p>Date</p></div>
                    <div class="col-sm-7"><p>{{$q->rundate}}</p></div>
                </div>
                
                <div class="row">
                    <div class="col-sm-5 text-right"><p>Score/Max Score</p></div>
                    <div class="col-sm-7"><p>{{$q->grade}}/{{$q->availgrade}} &nbsp;&nbsp;&nbsp; <progress value="{{$q->grade}}" max="{{$q->availgrade}}"></progress></p></div>
                </div>
                <div class="row">
                    <div class="col-sm-5 text-right"><p>Close on</p></div>
                    <div class="col-sm-7"><p>{{$q->att}}</p></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3 text-right"></div>
                    <div class="col-sm-9">
                        <a href="/admin/review/{{$q->id}}" class="btn btn-sm btn-{{deadlineCheck($q->att)?'primary':'dark'}}" title="{{auth()->user()->isadmin==2?'Evaluate score, review':'View review result, score, review so on'}}">{{deadlineCheck($q->att)?'View':'Deadline Over'}}</a>
                        @if(auth()->user()->isadmin==1)
                        <a href="/admin/candidate/view?id={{$q->candidate_id}}" class="btn btn-sm btn-primary" title="Go profile page">User Profile</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
<iframe id="download-frame" class="hide"></iframe>
@csrf
@endsection

@section('scripts')
<script src="/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $('input[name=startd],input[name=endd]').change(function(){
        $('#date-search-form').submit();
    })

    $('#listenSlider2').change(function(e) {
        var min = parseInt(this.value.split('/')[0], 10);
        var max = parseInt(this.value.split('/')[1], 10);

        $('.output2 b.min').text( min );
        $('.output2 b.max').text( max );
        
        window.rangeChanged = true;
    });
    
    $('body').mouseup(function(){
        if(window.rangeChanged == true){
            window.rangeChanged = true;
            location.href='/admin/review?search-select=' + $('select[name=search-select]').val() + '&range=' + $('#listenSlider2').val();
        }
    });
    
    $('.download-csv').click(function(){
        $('#download-frame').attr('src', '/admin/review/exportcsv?it='+$('select[name=search-select]').val()+'&range='+$('#listenSlider2').val());
    })
$('.delete-trigger').click(function(){
    var id =$(this).attr('_iid');
    bootbox.confirm("Are you realy delete it?", function(result){ 
        if(result){
            $.post('/admin/review/delete', {'id' : id,_token : $('input[name=_token]').val()}, function(r){
                location.reload();
            })
        }
    });

})
</script>
@endsection