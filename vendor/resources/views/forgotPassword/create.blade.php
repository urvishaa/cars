@extends('admin.layoutLlogin')
@section('content')
<style>
  .wrapper{
    display:  none !important;
  }
</style>
<div class="login-box">
  <div class="login-logo">     
    <div style="
    font-size: 25px;
"><!-- <b> {{ trans('labels.welcome_message') }}{{ trans('labels.welcome_message_to') }}</b> -->
  <img src="/resources/assets/img/property-logo.png">
</div>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Change Password</p>
    
	@if (Session::has('message'))
      <div class="alert alert-danger">
        <p>{{ Session::get('message') }}</p>
      </div>
    @endif

    
    <form action="{{ url('/ForgotPassword/save') }}" method="POST" enctype="multipart/form-data">
         <div class="panel-heading">
            </div>
            {!! csrf_field() !!}

            <input type="hidden"  name="userId" value="{{ $user_email->id }}" class="form-control">
                          
            <div class="form-group">
                <label for="name">Email<span class="clsred">*</span></label>
                <input type="text"  name="oldemail" value="" class="form-control">
	    </div>
            
            <div class="form-group">
                <label for="name">New Password <span class="clsred">*</span></label>
                <input type="password" name="new_password" value="" class="form-control" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="name">Confirm Password <span class="clsred">*</span></label>
                <input type="password" name="con_password" value="" class="form-control" required autofocus>
            </div>

            
            <div class="form-group">
                  <label class="col-md-4 control-label" for="submit"></label>
                  <div class="">
                    <button id="submit" name="submit" class="btn btn-primary btn-block btn-flat" value="1">Change Password</button>
                    
                  </div>
            </div>
    </form>

  </div>

  <!-- /.login-box-body -->
</div>

