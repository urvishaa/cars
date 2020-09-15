@extends('layout')
@section('content')

<div class="super_container">
	<div class="super_overlay"></div>
	
</div>

<div class="login_main_cls regis_main">
	<div class="container">
		<div class="login_inr regis_inr">
			<div class="login_info">
				<div class="log_info_left regis_tmr">
					<h6>{{ trans('labels.Register') }}</h6>
					
					@if(session()->has('message'))
					    <div class="alert alert-danger">
					        {{ session()->get('message') }}
					    </div>
					@endif

					<form method="post" action="{{ URL::to('/insertuser') }}">
					    <div class="form-group">
					     
					      <input type="text" class="form-control"  placeholder="{{ trans('labels.userName') }} *" name="username" value="" required=""> <label><img src="{{ URL::to('/resources/assets/img/user-login.png')}}"></label>
					    </div>
					    <div class="form-group">
					      <input type="email" class="form-control"  placeholder="{{ trans('labels.email') }} *" name="email" value="" required="">
					      <label><img src="{{ URL::to('/resources/assets/img/message.png')}}"></label>
					    </div>
					     <div class="form-group">
					      <input type="password" class="form-control" id="txtPassword" placeholder="{{ trans('labels.password') }} *" name="password">
					      <label><img src="{{ URL::to('/resources/assets/img/password-login.png')}}"></label>
					    </div>
					     <div class="form-group">
					      <input type="password" class="form-control" id="txtConfirmPassword" placeholder="{{ trans('labels.Confirm Password') }} *">
					      <label><img src="{{ URL::to('/resources/assets/img/password-login.png')}}"></label>
					      <span id="valid_password" style="display:none;color:red;">{{ trans('labels.passwordAndConfirmPasswordSame') }} *</span>
					    </div>
					    
                        <div class="register login">
					    	<button type="submit" onclick="return confirm();" class="btn btn-default">{{ trans('labels.Register') }}</button>
						</div>
						<p class="crt-acunt">{{ trans('labels.Already_have_an_account?') }}<span><a href="{{ URL::to('/login') }}" >{{ trans('labels.Login') }}.</a></span></p>
					 </form>
				</div>	
			</div>
			<div class="login_img">
				<div class="log_reg_img">
					<img class="rvrc-img" src="{{ URL::to('/resources/assets/img/sports-car.png')}}">
					<div class="log_img">
						<div class="log_wel">
							<h6>{{ trans('labels.Welcome') }}</h6>
							<p>{{ trans('labels.Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy & sell') }} </p>
						</div>
					</div>
				</div>	
			</div>
		</div>
			

	</div>
</div>
<script type="text/javascript">
 function confirm() {
        var password=document.getElementById('txtPassword');
        var confirmPassword=document.getElementById('txtConfirmPassword');
       
          if (password.value != confirmPassword.value) {
              document.getElementById('valid_password').style.display='';
              return false;
          }
          else
          {
            document.getElementById('valid_password').style.display='none';
          }
           
          return true;
        }    
  </script>
  @endsection