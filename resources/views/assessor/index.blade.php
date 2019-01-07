@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .panel img{
        width: 35px;
        height:35px; 
        margin-right:10px;}
    .image-trigger{
        position:relative;
        cursor: pointer;
        color:#fff;
        margin: 10px auto;
        width: 100px;
        padding: 5px 20px;
        display: inline-block;
        background: #f96332;
        border-radius: 5px;}
    #preview_image{
        width: 100%;
        visibility: hidden;
        position: absolute;
        left:0;
        top:0;}

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
                <h4 class="panel-title">Assessors</h4>
            </div>
            <div class="panel-body">
                <div class="btn-bar">
                    <button class="btn btn-primary create-assessor" data-toggle="modal" data-target=".assessor-modal">Create New Assessor <i class="fa fa-plus"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="">
                        <th>#</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Phone</th>
                        <th style="display:none;">Description</th>
                        <th>Assign  Date</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            @foreach($list as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td><img src="/{{!empty($q->photo)?$q->photo:'app/assessor/user.jpg'}}">{{$q->name}}</td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->phone}}</td>
                                <td style="display:none;"><textarea _iid="{{$q->id}}">{{$q->summary}}</textarea></td>
                                <td>{{$q->created_at}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <nobr>
                                        <button class="btn btn-sm btn-default update-trigger" _iid="{{$q->id}}"  data-toggle="modal" data-target=".assessor-modal"><i class="fa fa-edit"></i> </button>
                                        <button class="btn btn-sm btn-default delete-trigger" _iid="{{$q->id}}"><i class="fa fa-trash"></i> </button>
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

<div class="modal fade assessor-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Assessor</h5>
            </div>
            <div class="modal-body">
                <form id="create-assessor-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="assessor_id">

                    <div class="row">
                        <div class="col-sm-12 col-md-3 text-center">
                            <img id="userimg" src="/app/assessor/user.jpg" style="width:100%;">
                            <label class="image-trigger">
                                Image
                                <input id="preview_image" name="preview_image" type="file" accept="image/*">
                                <!--<code>Choose an assessor preview image.(300 X 200 pixel)</code>-->
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="summary" class="form-control" placeholder="" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-assessor-form">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script type="text/javascript">
    var Table = $('.table').dataTable();
$('.update-trigger').click(function (e) {
    $('#create-assessor-form').trigger('reset');
    $('.assessor-modal .modal-title').text('Update Assessor');
    $('.assessor-modal input[type="submit"]').val('Update');
    $('#create-assessor-form img').attr('src', $('img', $(this).parent().parent()).attr('src'));
    $('#create-assessor-form input[name="assessor_id"]').val($(this).attr('_iid'));
    $('#create-assessor-form input[name="name"]').val($(this).closest('tr').children('td:nth-child(2)').text());
    $('#create-assessor-form input[name="email"]').val($(this).closest('tr').children('td:nth-child(3)').text());
    $('#create-assessor-form input[name="phone"]').val($(this).closest('tr').children('td:nth-child(4)').text());
    $('#create-assessor-form textarea[name="summary"]').val($('textarea[_iid=' + $(this).attr('_iid') + ']').val());
});

$('.create-assessor').click(function (e) {
    $('.assessor-modal .modal-title').text('Create Assessor');
    $('.assessor-modal input[type="submit"]').val('Create');
    $('#create-assessor-form input[name="assessor_id"]').val('');
    $('#userimg').attr('src', '/app/assessor/user.jpg');
    $('#create-assessor-form').trigger('reset');
});

$('#preview_image').change(function () {
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#userimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else
    {
        $('#userimg').attr('src', '/app/assessor/user.jpg');
    }
});
$('.delete-trigger').click(function () {
    var id = $(this).attr('_iid');
    bootbox.confirm("Are you realy delete this assessor?", function (result) {
        if (result) {
            $.post('/admin/assessor/remove', {'id': id, _token: $('input[name=_token]').val()}, function (r) {
                location.reload();
            })
        }
    });

})

$('#create-assessor-form').submit(function () {
    if ($('input[name=new_password]').val() != $('input[name=confirm_password]').val()) {
        alert('New password not equal');
        return false;
    }

    if (!validateEmail($('input[name=email]').val())) {
        alert('Invalid Email Address!');
        return false;
    }
    if (!validatePhone($('input[name=phone]').val())) {
        alert('Invalid Phone Number!');
        return false;
    }
    var re = true;
        $.ajax({
            'url': '/admin/assessor/emailcheck',
            'async': false,
            'type': 'post',
            'data':'email=' + $('input[name=email]').val()+'&id='+$('input[name=assessor_id]').val()+'&_token='+$('input[name=_token]').val(),
            'success': function (r) {
                if (r != 'ok') {
                    alert('An equal email registered aleady!');
                    $('input[name=email]').prop('focus');
                    re = false;
                }
            },
            'error': function (r) {
                re = false;
            }
        })
      return re;

    return true;
})
</script>
@endsection