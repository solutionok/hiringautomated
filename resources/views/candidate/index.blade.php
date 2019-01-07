@extends('layouts.page')
@section('css')
<link href="/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<link rel="stylesheet" href="/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .panel img{width: 35px;height:35px; margin-right:10px;}
    
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
                    Checked candidates to 
                    <select name="interview_id" id="interview_id" style="height:31px!important;padding: 0;">
                        <option value=''></option>
                        @foreach($interviews as $i=>$q)
                        <option value="{{$q->id}}">{{$q->name}}</option>
                        @endforeach
                    </select>
                    <select name="assessor_id" id="assessor_id" style="height:31px!important;padding: 0;">
                        <option value=''></option>
                        @foreach($assesors as $i=>$q)
                        <option value="{{$q->id}}">{{$q->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary assign-interview" disabled>Assign</button>
                    <button onclick="document.getElementById('hidden-frame').src='/app/candidate_template.csv'" class="btn btn-primary">Download CSV</button>
                    <button onclick="document.getElementById('bulkadd').click()" class="btn btn-primary bulkadd">Upload CSV</button>
                    <button onclick="location.href='/admin/candidate/view'" class="btn btn-primary">Add New <i class="fa fa-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th><input type="checkbox" class="checked-candidate-all"></th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th>Interview</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($list as $i=>$q)
                            <tr>
                                <td style="vertical-align: middle;"><input type="checkbox" class="checked-candidate"  value="{{$q->id}}"></td>
                                <td>
                                    <a href="/admin/candidate/view?id={{$q->id}}">
                                        <img src="/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}">{{$q->name}}
                                    </a>
                                </td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->phone}}</td>
                                <td>
                                    <table>
                                        @foreach($q->interviewList as $it)
                                        <tr style="border-bottom:dashed 1px #555555">
                                            <td style="padding:2px 4px">
                                                <a href="{{empty($it->id)?'javascript:;':('/admin/review/'.$it->id)}}"
                                                    title="{{isset($it->rundate)?('Completed interview at '.$it->rundate.', evaluated score ' . $it->grade):'No interview'}}"
                                                    style="{{isset($it->rundate)?('color:green;'):'color:darkgray'}}"
                                                    >
                                                    {{$it->name}}
                                                </a>
                                            </td>
                                            <td style="padding:2px 4px">
                                                <a href="{{empty($it->as_ids)?'javascript:;':('/admin/assessor?search-select='.$it->id)}}"
                                                    title="{{empty($it->as_ids)?('No assessor'):getAssesorNames($it->as_ids,$assesors, true)}}"
                                                    style="{{empty($it->as_ids)?('color:darkgray;'):'color:green'}}"
                                                    >
                                                    {{empty($it->as_ids)?('No assessor'):getAssesorNames($it->as_ids,$assesors)}}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
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

$('#interview_id,#assessor_id').chosen({width: "auto"})
var Table = $('.table').dataTable();
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

$('#interview_id,#assessor_id').change(function(){
    $('.assign-interview').prop('disabled', !($('#interview_id').val()&&$('#assessor_id').val()));
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
</script>
@endsection