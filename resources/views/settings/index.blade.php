@extends('layouts.page')

@section('css')
<style>
    .account-info h6,.account-info input{
        line-height: 40px;
    }
    .account-info input[type=submit]{
        line-height: initial;
    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="panel account-info">
            <div class="panel-heading">
                <h5 class="title">
                    Account
                </h5>
            </div>
            <div class="panel-body">
                <form class="form form-horizontal" id="account-form" method="post" action="/admin/settings/account">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3 text-right"><h6>Name</h6></div>
                        <div class="col-sm-7"><input name="name" class="form-control" value="{{$admin->name}}" required></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-right"><h6>Email</h6></div>
                        <div class="col-sm-7"><input type="email" name="email" class="form-control" value="{{$admin->email}}" required></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-right"><h6>Phone</h6></div>
                        <div class="col-sm-7"><input name="phone" class="form-control" value="{{$admin->phone}}" required></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3 text-right"></div>
                        <div class="col-sm-7"><input type="submit" class="btn btn-primary" value="Save"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel account-info">
            <div class="panel-heading">
                <h5 class="title">
                    Change password
                </h5>
            </div>
            <div class="panel-body">
                <form id="password-form" class="form form-horizontal" method="post" action="/admin/settings/password">
                    @csrf
                    <div class="row">
                        <div class="col-sm-5 text-right"><h6>Current password</h6></div>
                        <div class="col-sm-6"><input id="current_password" name="current_password" class="form-control" type="password" required></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 text-right"><h6>New password</h6></div>
                        <div class="col-sm-6"><input id="new_password" name="new_password" class="form-control" type="password" required></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 text-right"><h6>Confirm password</h6></div>
                        <div class="col-sm-6"><input id="confirm_password" class="form-control" type="password" required></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-5 text-right"></div>
                        <div class="col-sm-6"><input type="submit" class="btn btn-primary change-password" value="Change"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('.change-password').click(function(){
        if(!$('#current_password').val()){
            alert('Enter current password!');
            return false;
        }
        if($('#new_password').val()!=$('#confirm_password').val()){
            alert('not equal new password!');
            return false;
        }
        
        var re = false;
        
        $.ajax({
            'url' : '/admin/settings/checkpass',
            'data' : {password:$('#current_password').val(),_token:$('input[name=_token]').val()},
            'async' : false,
            'type' : 'post',
            'success' : function(r){
                if(r!='ok'){
                    alert('Incorrect current password!');
                    re = false;
                }else{
                    re = true;
                }
            }
        });
        
        return re;
    });
    
    $('#account-form').submit(function(){
        
        if (!validateEmail($('input[name=email]').val())) {
            alert('Invalid Email Address!');
            return false;
        }
        if (!validatePhone($('input[name=phone]').val())) {
            alert('Invalid Phone Number!');
            return false;
        }
        return true;
    })
</script>
@endsection