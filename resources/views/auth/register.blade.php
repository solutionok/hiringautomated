<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/fontawesome5.6.3/css/all.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">

        <link rel="stylesheet" type="text/css" href="/css/register.css">
        <title>Sign up - Smart Interview</title>
    </head>
    <body>
        <div class="container">
            <div class="row main">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2 class="title">Resiter your information</h2>
                    </div>
                </div> 
                <div class="main-login main-center">
                    <form id="main-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-9">
                            
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="name" class="control-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="name" id="name" required=""/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="name" class="control-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="email" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="email" class="control-label">Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="phone" required=""/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="email" class="control-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="password" minlength="6" required=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <label for="photo"  style="cursor: pointer">
                                <img id="previwe-photo" src="/app/candidate/user.jpg" style="max-height: 130px;max-width:100%;border: solid 1px #eee;" >
                                 Choose my photo...
                                <input type="file" id="photo" name="photo" class="form-control" accept="image/*" style="opacity: 0;position: absolute;right:0;top:0;">
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="email" class="control-label">Professional Summary</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-comment-alt fa" aria-hidden="true"></i></span>
                                    <textarea class="form-control" name="summary" required="" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="meta-head">Employment History <a class="btn btn-sm btn-dark" href="javascript:;" _id="plus-emphistory"><i class="fa fa-plus-circle"></i> </a></h4>
                        
                        <h4 class="meta-head">Education <a class="btn btn-sm btn-dark " href="javascript:;" _id="plus-education"><i class="fa fa-plus-circle"></i> </a></h4>
                        
                        <h4 class="meta-head">Skills <a class="btn btn-sm btn-dark " href="javascript:;" _id="plus-skill"><i class="fa fa-plus-circle"></i> </a></h4>
                        
                        <div class="form-group ">
                            <button class="btn btn-danger btn-lg btn-block login-button" >Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <template id="plus-emphistory">
            <div class="form-group plus-emphistory">
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
            <div class="form-group plus-education">
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
            <div class="form-group plus-skill">
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
        
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
            $('#photo').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                 {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                       $('#previwe-photo').attr('src', e.target.result);
                    }
                   reader.readAsDataURL(input.files[0]);
                }
                else
                {
                  $('#previwe-photo').attr('src', '/app/candidate/user.jpg');
                }
            });
            
            $('.login-button').click(function(){
                if(!($('input[name=email]').val())) return false;
                
                var re = true;
                $.ajax({
                    'url': '/register/emailcheck/' + $('input[name=email]').val(),
                    'async': false,
                    'type': 'get',
                    'success': function(r){
                        if(r!='ok'){
                            alert('An equal email registered aleady!');
                            $('input[name=email]').prop('focus');
                            re = false;
                        }
                    },
                    'error': function(r){
                        re = false;
                    }
                })
                return re;
            });
            
            $('.meta-head .btn').click(function(){
                var clone = $('#'+$(this).attr('_id')).prop('content').cloneNode(true);
                if($('.'+$(this).attr('_id')).length){
                    $('.'+$(this).attr('_id')).last().after(clone);
                }else{
                    $(this).parent().after(clone);
                }
            })
        </script>
    </body>
</html>