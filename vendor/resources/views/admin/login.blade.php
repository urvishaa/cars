@extends('admin.layoutLlogin')
@section('content')
<style>
	.wrapper{
		display:  none !important;
	}
</style>
<?php
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
    ?>
<div class="login-box">
  <div class="login-logo">     
    <div style="
    font-size: 25px;
"><!-- <b> {{ trans('labels.welcome_message') }}{{ trans('labels.welcome_message_to') }}</b> -->
  <img src="<?php echo $new.'/resources/assets/img/iraq_car.png'; ?>">
</div>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">{{ trans('labels.login_text') }}</p>
    
    <!-- if email or password are not correct -->
    @if( count($errors) > 0)
    	@foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">{{ trans('labels.Error') }}:</span>
                  {{ $error }}
            </div>
         @endforeach
    @endif
    
    @if(Session::has('loginError'))
        <div class="alert alert-danger" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">{{ trans('labels.Error') }}:</span>
              {!! session('loginError') !!}
        </div>
    @endif
    
    {!! Form::open(array('url' =>'admin/checkLogin', 'method'=>'post', 'class'=>'form-validate')) !!}
      
       <div class="form-group has-feedback">
        {!! Form::email('email', '', array('class'=>'form-control email-validate', 'id'=>'email')) !!}
        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                     {{ trans('labels.AdminEmailText') }}</span>
       <span class="help-block hidden"> {{ trans('labels.AdminEmailText') }}</span>
     <!--    <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
      </div>
      <div class="form-group has-feedback">
       <input type="password" name='password' class='form-control field-validate' value="">
       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                   {{ trans('labels.AdminPasswordText') }}</span>
      <!--   <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
       <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
       
      </div>

      <div class="form-group has-feedback">
        <select name="language" id="language" class="form-control" class="field" field-validate>
            <option value="en">{{ trans('labels.englishLanguage') }}</option>                          
            <option value="ar">{{ trans('labels.arabicLanguage') }}</option>                          
            <option value="ku">{{ trans('labels.kurdishLanguage') }}</option>                          
        </select>
       {{-- <input type="language" name='language' class='form-control field-validate' value=""> --}}
       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                   {{ trans('labels.AdminlanguageText') }}</span>
      <!--   <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
       <span class="help-block hidden">{{ trans('labels.AdminlanguageText') }}</span>
       
      </div>

  	 
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
          {!! Form::submit(trans('labels.login'), array('id'=>'login', 'class'=>'btn btn-primary btn-block btn-flat' )) !!}
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}

  </div>

  <!-- /.login-box-body -->
</div>