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
        padding: 5px 20px;
        display: inline-block;
        background: #FFB236;
        border-radius: 5px;}
    #preview_image{
        width: 100%;
        visibility: hidden;
        position: absolute;
        left:0;
        top:0;}
    .plus-education a,.plus-emphistory a, .plus-skill a{display: block;margin-top: 9px;}
    .right{float:right;}
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-sm-1 col-md-2">
        <form id="pass-save" name="pass-save" target="pass-save-frame" method="post" action="/home/passchange" enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="file" name="cv-file" id="cv-file" accept=".pdf">
        </form>
        <iframe name="pass-save-frame" style="display:none"></iframe>
    </div>
    <div class="col-sm-10 col-md-8">
        <div class="panel">
            <div class="panel-body" style="padding:30px;">

                <div class="btn-group" style="position:absolute;right:20px;top:5px;z-index:10;">
                    <button type="button" class="mb-xs mt-xs mr-xs btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">C V <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:document.getElementById('cv-file').click();">Upload</a></li>
                        @if(@$user->cv)
                        <li><a href="{{@$user->cv?$user->cv:'javascript:;'}}" target='_blank'>Show</a></li>
                        @endif
                    </ul>
                </div>
                <form method="post" enctype="multipart/form-data" action="/home/mysave">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{!$user?'':$user->id}}">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img id="previwe-photo" src="/{{$user&&$user->photo?$user->photo:'app/candidate/user.jpg'}}">
                            <br>
                            <label class="image-trigger">
                                Image Upload
                                <input id="preview_image" name="preview_image" type="file" accept="image/*">
                            </label>
                            <br>
                            <div class="row">
                                <div class="col-sm-0 col-md-3"></div>
                                <h2 class="col-sm-12 col-md-6"></h2>
                            </div>
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
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Current Password</label>
                                    <input name="current_password" type="password" class="form-control text-center" form="pass-save" style="margin: 3px;" required="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">New Password</label>
                                    <input name="new_password"  type="password" form="pass-save"  class="form-control text-center" style="margin: 3px;" required="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Confirm Password</label>
                                    <input name="new_password1"  type="password" form="pass-save"  class="form-control text-center" style="margin: 3px;" required="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"> &nbsp;</label>
                                <input class="btn btn-warning form-control" type="submit" value="Change Password" form="pass-save">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Professional Summary </h5>
                            <textarea name="summary" class="col-md-12" rows="5">{{!$user?'':$user->summary}}</textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-11">
                            <h5 style="position:relative;">Employment History  </h5>
                        </div>
                        <div class="col-sm-1">
                            <a class="btn btn-sm btn-warning" href="javascript:;" _id="plus-emphistory"><i class="fa fa-plus-circle"></i></a> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
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
                    <div class="row">
                        <div class="col-sm-11">
                            <h5 style="position:relative;">Education  </h5>
                        </div>
                        <div class="col-sm-1">
                            <a class="btn btn-sm btn-warning" href="javascript:;" _id="plus-education"><i class="fa fa-plus-circle"></i></a> 
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-sm-11">
                            <h5 style="position:relative;">Skills  </h5>
                        </div>
                        <div class="col-sm-1">
                            <a class="btn btn-sm btn-warning" href="javascript:;" _id="plus-skill"><i class="fa fa-plus-circle"></i></a> 
                        </div>
                    </div>
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
                            <button class="btn btn-warning">Save</button>
                        </div>
                    </div>
                </form>
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

    $('select[name="interview_id[]"]').chosen({width: "100%"});

    $('a[_id="plus-emphistory"],a[_id="plus-education"],a[_id="plus-skill"]').click(function () {
        var clone = $('#' + $(this).attr('_id')).prop('content').cloneNode(true);
        if ($('.' + $(this).attr('_id')).length) {
            $('.' + $(this).attr('_id')).last().after(clone);
        } else {
            $(this).parent().parent().next().children().append(clone);
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

    $('form').submit(function () {
        if (!($('input[name=email]').val()))
            return false;

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
            'url': '/home/emailcheck',
            'async': false,
            'type': 'post',
            'data': 'email=' + $('input[name=email]').val() + '&id={{$user?$user->id:""}}&_token=' + $('input[name=_token]').val(),
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
    });

    $('input[name=current_password],input[name=new_password]').keypress(function (e) {
        if (e.keyCode == 13) {
            $('#pass-save').submit();
        }
    })

    $('#pass-save').submit(function () {
        if ($('input[name=new_password]').val() != $('input[name=new_password1]').val()) {
            alert('New password not equal');
            return false;
        }

        return true;
    });
    $('#cv-file').change(function(){
        $('#pass-save').attr('action','/home/uploadcv').submit();
    })
</script>
@endsection