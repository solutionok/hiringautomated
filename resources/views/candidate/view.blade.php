@extends('layouts.page')
@section('css')
<link href="/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<style>
    .card h6{line-height:30px;}
    #previwe-photo{max-height: 200px;}
    .image-trigger{
        position:relative;
        cursor: pointer;
        color:#fff!important;
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
    .plus-education a,.plus-emphistory a, .plus-skill a{display: block;margin-top: 9px;}
    .right{float:right;}
    .assigned-interview-table img{width:15px;height:15px;margin-right: 5px;}
</style>
@endsection
@section('content')

<form id="pass-save" name="pass-save" target="pass-save-frame" method="post" enctype="multipart/form-data" style="display:none;">
    @csrf
    <input type="file" name="cv-file" id="cv-file" accept=".pdf">
    <input type="hidden" name="candidate_id" value="{{@$user->id}}">
</form>
<iframe name="pass-save-frame" style="display:none;s"></iframe>
<div class="row">
    <div class="col-sm-0 col-md-2"></div>
    <div class="col-sm-12 col-md-8">
        <div class="panel">
            <div class="panel-body">
                <a href="/admin/candidate" class="btn btn-primary" style="position:absolute;right:90px;top:10px;z-index:10;">Go back</a>
                
                <div class="btn-group" style="position:absolute;right:20px;top:5px;z-index:10;">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">C V <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:document.getElementById('cv-file').click();">Upload</a></li>
                        @if(@$user->cv)
                        <li><a href="{{@$user->cv?('/'.$user->cv):'javascript:;'}}" target='_blank'>Show</a></li>
                        @endif
                    </ul>
                </div>
                <form method="post" enctype="multipart/form-data" action="/admin/candidate/save" name="save-form" id="save-form">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{!$user?'':$user->id}}">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img id="previwe-photo" src="/{{$user&&$user->photo?$user->photo:'app/candidate/user.jpg'}}">
                            <br>
                            <label class="image-trigger">
                                Image
                                <input id="preview_image" name="preview_image" type="file" accept="image/*">
                            </label>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input name="name" value="{{!$user?'':$user->name}}" class="form-control text-center" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <input type="email" name="email" value="{{!$user?'':$user->email}}" class="col-sm-4 form-control text-center" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input name="phone" value="{{!$user?'':$user->phone}}" class="form-control text-center" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="password" name="new_password" class="form-control text-center" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control text-center" >
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">
                                    Interview |  
                                    <button class="btn btn-sm btn-primary btn-circle interview-add" title="Assign new interview" onclick="return false;"><i class="fa fa-plus-circle"></i> </button>
                                    <input type="hidden" id="assigned_interview_ids" name="assigned_interview_ids" value="<?php echo implode(',', $interviewIds);?>">
                                </label>
                                <table class="table table-bordered text-center assigned-interview-table">
                                    <thead>
                                        <tr><td class="text-left">Name</td><td>Deadline</td><td>Date</td><td>Maximium Score/Score</td><td></td></tr>
                                    </thead>
                                    @if(count($histories))
                                    @foreach($histories as $i=>$h)
                                    <tr itid="{{$h->id}}">
                                        <td class="text-left">
                                            <a href="{{$h->hid?('/admin/review/'.$h->hid):'javascript:;'}}">
                                                <img src="/{{$h->preview_image?$h->preview_image:'app/interview_image/no-image.png'}}" >
                                                {{$h->name}}
                                            </a>
                                        </td>
                                        <td>{{date('d.m.Y', strtotime($h->ctt))}}</td>
                                        <td>{{$h->rundate?date('d.m.Y', strtotime($h->rundate)):'-'}}</td>
                                        <td>{{$h->grade?($h->availgrade.' / '.$h->grade):'-'}}</td>
                                        <td>
                                            @if(deadlineCheck($h->ctt)&&empty($h->hid))
                                            <a href="javascript:DeleteIT({{$h->id}});"><i class="fa fa-minus-circle"></i></a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td class="text-center" colspan="4">Any interviews haven't assigned yet</td></tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Professional Summary </h5>
                            <textarea name="summary" class="col-md-12" rows="5">{{!$user?'':$user->summary}}</textarea>
                        </div>
                    </div>
                    <hr>
                    <h5 style="position:relative;">Employment History  <a style="position:absolute;right:7px;top:10px;" class="btn btn-sm btn-primary" href="javascript:;" _id="plus-emphistory"><i class="fa fa-plus-circle"></i></a> </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            @if($user&&$user->employee_history)
                            @foreach(json_decode($user->employee_history) as $q)
                            <div class="row plus-emphistory">
                                <div class="col-sm-2">
                                    <label class="control-label">From</label>
                                    <input value="{{$q[1]}}" type="text" class="form-control" name="emp-from[]" required/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">To</label>
                                    <input value="{{$q[2]}}" type="text" class="form-control" name="emp-to[]" required/>
                                </div>
                                <div class="col-sm-7">
                                    <label class="control-label">Job Detail</label>
                                    <input value="{{$q[0]}}" type="text" class="form-control" name="emp-job[]" required/>
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" style="visibility: hidden;">x</label>
                                    <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <hr>
                    <h5 style="position:relative;">Education  <a style="position:absolute;right:7px;top:10px;" class="btn btn-sm btn-primary right" href="javascript:;" _id="plus-education"><i class="fa fa-plus-circle"></i> </a></h5>
                    <div class="row">
                        <div class="col-sm-12">

                            @if($user&&$user->education_history)
                            @foreach(json_decode($user->education_history) as $q)
                            <div class="row plus-education">
                                <div class="col-sm-2">
                                    <label class="control-label">From</label>
                                    <input value="{{$q[1]}}" type="text" class="form-control" name="edu-from[]" required/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">To</label>
                                    <input value="{{$q[2]}}" type="text" class="form-control" name="edu-to[]" required/>
                                </div>
                                <div class="col-sm-7">
                                    <label class="control-label">School/Degree/City</label>
                                    <input value="{{$q[0]}}" type="text" class="form-control" name="edu-job[]" required/>
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" style="visibility: hidden;">x</label>
                                    <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <hr>
                    <h5 style="position:relative;">Skills  <a style="position:absolute;right:7px;top:10px;" class="btn btn-sm btn-primary right" href="javascript:;" _id="plus-skill"><i class="fa fa-plus-circle"></i></a> </h5>
                    <div class="row">
                        <div class="col-sm-12">
                            @if($user&&$user->skill_grade)
                            @foreach(json_decode($user->skill_grade) as $q)
                            <div class="row plus-skill">
                                <div class="col-sm-7">
                                    <label class="control-label">Skill</label>
                                    <input value="{{$q[0]}}" type="text" class="form-control" name="skill-label[]" required/>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Level</label>
                                    <select class="form-control" name="skill-level[]" required>
                                        <option {{$q[1]=='Novice'?'selected':''}}>Novice</option>
                                        <option {{$q[1]=='Beginner'?'selected':''}}>Beginner</option>
                                        <option {{$q[1]=='Skillful'?'selected':''}}>Skillful</option>
                                        <option {{$q[1]=='Experienced'?'selected':''}}>Experienced</option>
                                        <option {{$q[1]=='Expert'?'selected':''}}>Expert</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" style="visibility: hidden;">x</label>
                                    <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="/admin/candidate" class="btn btn-primary">Go back</a>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal interview-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose an interview</h5>
      </div>
      <div class="modal-body">
        <select id="interview-picker" data-placeholder="Choose interview..." class="form-control">
            <option></option>
            @foreach($interviews as $i=>$q)
            <option value="{{$q->id}}">{{$q->name}}</option>
            @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary do-interview-assign">Assign</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<template id="plus-emphistory">
    <div class="row plus-emphistory">
        <div class="col-sm-2">
            <label class="control-label">From</label>
            <input type="text" class="form-control" name="emp-from[]" required/>
        </div>
        <div class="col-sm-2">
            <label class="control-label">To</label>
            <input type="text" class="form-control" name="emp-to[]" required/>
        </div>
        <div class="col-sm-7">
            <label class="control-label">Job Detail</label>
            <input type="text" class="form-control" name="emp-job[]" required/>
        </div>
        <div class="col-sm-1">
            <label class="control-label" style="visibility: hidden;">x</label>
            <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
        </div>
    </div>
</template>
<template id="plus-education">
    <div class="row plus-education">
        <div class="col-sm-2">
            <label class="control-label">From</label>
            <input type="text" class="form-control" name="edu-from[]" required/>
        </div>
        <div class="col-sm-2">
            <label class="control-label">To</label>
            <input type="text" class="form-control" name="edu-to[]" required/>
        </div>
        <div class="col-sm-7">
            <label class="control-label">School/Degree/City</label>
            <input type="text" class="form-control" name="edu-job[]" required/>
        </div>
        <div class="col-sm-1">
            <label class="control-label" style="visibility: hidden;">x</label>
            <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
        </div>
    </div>
</template>
<template id="plus-skill">
    <div class="row plus-skill">
        <div class="col-sm-7">
            <label class="control-label">Skill</label>
            <input type="text" class="form-control" name="skill-label[]" required/>
        </div>
        <div class="col-sm-4">
            <label class="control-label">Level</label>
            <select class="form-control" name="skill-level[]" required>
                <option>Novice</option>
                <option>Beginner</option>
                <option>Skillful</option>
                <option>Experienced</option>
                <option>Expert</option>
            </select>
        </div>
        <div class="col-sm-1">
            <label class="control-label" style="visibility: hidden;">x</label>
            <a href="javascript:;" onclick="this.parentNode.parentNode.remove()"><i class="fa fa-minus-circle"></i> </a>
        </div>
    </div>
</template>


@endsection

@section('scripts')
<script src="/plugins/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

    
    $('h5 a').click(function () {
        var clone = $('#' + $(this).attr('_id')).prop('content').cloneNode(true);
        if ($('.' + $(this).attr('_id')).length) {
            $('.' + $(this).attr('_id')).last().after(clone);
        } else {
            $(this).parent().next().children().append(clone);
        }
    })

    $('#preview_image').change(function () {
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "jfif")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previwe-photo').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#previwe-photo').attr('src', '/app/candidate/user.jpg');
        }
    });

    $('#cv-file').change(function(){
        $('#pass-save').attr('action','/admin/candidate/uploadcv').submit();
    });
    
    $('#save-form').submit(function(){
        if($('input[name=new_password]').val()!=$('input[name=confirm_password]').val()){
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
            'url': '/admin/candidate/emailcheck',
            'async': false,
            'type': 'post',
            'data':'email=' + $('input[name=email]').val()+'&id={{$user?$user->id:""}}&_token='+$('input[name=_token]').val(),
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

    $('.do-interview-assign').click(function(){
        
        var id = $('#interview-picker').val();
        if(!id){
            alert('Choose an interview!');
            return;
        }
        
        var it = null;
        for(i in interviews){
            if(interviews[i]['id']==id){
                it = interviews[i];
                break;
            }
        }
        var html = '<tr itid="'+it['id']+'">'
                 + '<td class="text-left">'
                    + '<a href="javascript:;">'
                        + '<img src="/'+(it['preview_image']?it['preview_image']:'app/interview_image/no-image.png')+'" style="width">'
                        + it['name']
                    + '</a>'
                 + '</td>'
                 + '<td>'+it['ctt']+'</td>'
                 + '<td>-</td><td>-</td>'
                 + '<td><a href="javascript:DeleteIT('+it['id']+');"><i class="fa fa-minus-circle"></i></a></td></tr>'
         ;
        $('.assigned-interview-table').append(html);
        
        $('#assigned_interview_ids').val($('#assigned_interview_ids').val()+','+id);
        $('.interview-modal').modal('hide');
    });
    
    $('.interview-add').click(function(){
        var assigned = $('#assigned_interview_ids').val().split(',');
        $('#interview-picker').children().each(function(i,el){
            if(!$(el).attr('value'))return;
            $(el).prop('disabled', $.inArray(String($(el).attr('value')),assigned)!=-1)
        });
        
        $('#interview-picker').chosen({width:'100%'});
        $('.interview-modal').modal();
    });
    
    function DeleteIT(id){
        $('tr[itid='+id+']').remove();
        
        var assigned = $('#assigned_interview_ids').val().split(','),
            newassign = [];
        
        for(i in assigned){
            if(assigned[i]!=id){
                newassign.push(assigned[i]);
            }
        }
        
        $('#assigned_interview_ids').val(newassign.join(','));
    }
    var interviews = <?php echo json_encode($interviews);?>;
</script>
@endsection