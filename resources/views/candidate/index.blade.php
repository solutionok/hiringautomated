@extends('layouts.page')
@section('css')
<link href="/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<link rel="stylesheet" href="/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .panel img{width: 20px;height:20px; margin-right:10px;}
    
    .header .search{
        width: auto!important;
    }
    @media only screen and (max-width: 900px){
        .header .search {
            display: none;
        }
    }
    .table-responsive {
        margin-top: 10px;
        overflow-x: hidden;
    }
    div.dataTables_length select {
        padding: 5px 10px!important;
        text-align: center;
        width: auto;
        height: auto;
    }
    .dataTables_wrapper .dataTables_filter label{width:100%;}
    .dataTables_wrapper .dataTables_filter input {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555555;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .dataTables_wrapper .dataTables_filter input{
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
        background-repeat: no-repeat;
        background-color: #fff;
        background-position: 3px 6px !important;
        padding-left: 25px;    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">Candidates</h4>
            </div>
            <div class="panel-body">
                <div class="btn-bar">
                    Assign Candidates to 
                    <select name="interview_id" id="interview_id" data-placeholder="Select Interview" style="width: 300px;">
                        <option value=""></option>
                        @foreach($interviews as $i=>$q)
                        <option value="{{$q->id}}">{{$q->name}}</option>
                        @endforeach
                    </select>
                    <select name="assessor_id" id="assessor_id" data-placeholder="Select assessor" style="min-width: 150px;"></select>
                    <button class="btn btn-primary assign-interview" disabled>Assign</button>
                    
                    <div class="btn-group">
                        <button type="button" class="mb-xs mt-xs mr-xs btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">CSV <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:;" onclick="downToCSV()">Download CSV</a></li>
                            <li><a href="javascript:;" onclick="document.getElementById('bulkadd').click()" class="bulkadd">Upload CSV</a></li>
                        </ul>
                    </div>
                    
                    <button onclick="blukDelete()" class="btn btn-danger">Delete <i class="fa fa-trash"></i></button>
                    <button onclick="location.href='/admin/candidate/view'" class="btn btn-primary">Add New <i class="fa fa-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th><input type="checkbox" class="checked-candidate-all"></th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th><span style="width:200px!important;display: inline-block">Interview</span><span style="display: inline-block">Assessor</span></th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($list as $i=>$q)
                            <?php $csp = count($q->interviewList);?>
                            <tr>
                                <td style="vertical-align: middle;"><input type="checkbox" class="checked-candidate"  value="{{$q->id}}"></td>
                                <td style="min-width: 120px;">
                                    <a href="/admin/candidate/view?id={{$q->id}}">
                                        <img src="/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}">{{$q->name}}
                                    </a>
                                </td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->phone}}</td>
                                <td>
                                    <ul style="list-style:none;padding:0;">
                                        @foreach($q->interviewList as $it)
                                        <li style="{{count($q->interviewList)==1?'':'border-bottom:dashed 1px #555555;'}} height:30px;">
                                            <nobr>
                                            <a href="{{empty($it->id)?'javascript:;':('/admin/review/'.$it->id)}}"
                                                title="{{isset($it->rundate)?('Completed interview at '.date('d.m.Y', strtotime($it->rundate)).', evaluated score ' . $it->grade):'No interview'}}"
                                                style="{{isset($it->rundate)?('color:green;'):'color:darkgray'}};display: inline-block;width: 200px;padding-left: 5px;"
                                                >
                                                {{$it->name}}
                                            </a>
                                            <span
                                                title="{{isset($it->rundate)?('Completed interview at '.date('d.m.Y', strtotime($it->rundate)).', evaluated score ' . $it->grade):'No interview'}}"
                                                style="{{isset($it->rundate)?('color:green;'):'color:darkgray'}};display: inline-block;margin-left: 5px;"
                                                >
                                                {{empty($it->as_ids)?('No assessor'):(getAssesorNames($it->as_ids,$assesors))}}
                                            </span>
                                            </nobr>
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <nobr>
                                        <a class="btn btn-default btn-sm" href="/admin/candidate/view?id={{$q->id}}"><i class="fa fa-edit"></i> </a>
                                        <button class="btn btn-default btn-sm delete-trigger" _iid="{{$q->id}}"><i class="fa fa-trash"></i> </button>
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<iframe id="hidden-frame" name="hidden-frame" style="display: none"></iframe>
<form id="import-form" name="import-form" method="post" enctype="multipart/form-data" action="/admin/candidate/bulkadd" target="hidden-frame" style="display:none;">
    @csrf
    <input name="bulkadd" id="bulkadd" type="file" accept=".csv">
</form>
@endsection

@section('scripts')
<script src="/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="/plugins/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

$('#interview_id,#assessor_id').chosen()
var Table = $('.table').dataTable({
    "columnDefs": [
        { "orderable": false, "targets": 0 },
        { "orderable": false, "targets": 4 },
        { "orderable": false, "targets": 5 },
      ]
    ,  
    "dom": '<"top"lf>t<"bottom"pi><"clear">',
    select: true,
    language: {
        searchPlaceholder: "Search "
    }
});
$('#bulkadd').change(function () {
    if (this.value) {

        bootbox.confirm("Is correct selected file?", function (result) {
            if (result) {
                $('#import-form').submit();
            }
        });
    }
})
$('.delete-trigger').click(function () {
    var id = $(this).attr('_iid');
    bootbox.confirm("Are you realy delete this candidate?", function (result) {
        if (result) {
            $.post('/admin/candidate/delete', {'id': id, _token: $('input[name=_token]').val()}, function (r) {
                location.reload();
            })
        }
    });

});

$('.assign-interview').click(function(){
    if(!$('.checked-candidate:checked').length){
        alert('Please check one more candidates!');
        return false;
    }
    
    var interviewId = $('#interview_id').val();
    var assessorId = $('#assessor_id').val();
    
    if(!interviewId||!assessorId)return false;
    
    var candidateIds = [];
    $('.checked-candidate:checked').each(function(i,el){
        candidateIds.push(el.value);
    });
    if(!candidateIds.length)return false;
    $.post('/admin/candidate/assign', {_token:$('input[name=_token]').val(),interviewId:interviewId, assessorId:assessorId, candidateIds:candidateIds}, function(r){
        location.reload();
    })
});
function bulkResult(re) {
    bootbox.alert(re, function(){
        location.reload();
    });
}
$('.checked-candidate-all').click(function(){
    $('.checked-candidate').prop('checked', this.checked)
})

$('#interview_id').change(function(){
    $('#assessor_id').empty();
    $('#assessor_id').chosen('destroy').chosen();
    $('.assign-interview').prop('disabled', true);
    if(!this.value)return;
    $.post('/admin/candidate/assessors/' + this.value,{_token:$('input[name=_token]').val()}, function(r){
        for(var i=0; i<r.length; i++){
            $('#assessor_id').append('<option value="' + r[i]['id'] + '">' + r[i]['name'] + '</option>');
        }
        
        $('#assessor_id').chosen('destroy').chosen();
        $('.assign-interview').prop('disabled', !($('#interview_id').val()&&$('#assessor_id').val()));
    },'json');
}).change();
function downToCSV(){
    if(!$('.checked-candidate:checked').length){
        alert('Please check the candidates you want to donwload');
        return;
    }
    
    var ids = [];
    $('.checked-candidate:checked').each(function(i, el){
        ids.push(el.value);
    });
    $('#hidden-frame').attr('src', '/admin/candidate/downcsv?ids=' + ids);
}
function blukDelete(){
    if(!$('.checked-candidate:checked').length){
        alert('Please check the candidates you want to delete');
        return;
    }
    
    if(!confirm('Are you realy delete checked candiates?'))return false;
    
    var ids = [];
    $('.checked-candidate:checked').each(function(i, el){
        ids.push(el.value);
    });
    $.post('/admin/candidate/delete', {_token:$('input[name=_token]').val(),id:ids}, function(r){
        location.reload();
    })
}
</script>
@endsection