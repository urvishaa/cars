
@extends('layout')
@section('content')

<div class="super_container">
	<div class="super_overlay"></div>
	
	
</div>
<!-- Info message -->

<div class="login_main_cls">
	<div class="container">
		<div class="login_inr">
			<div class="login_info">
				<div class="log_info_left">

					<h6>{{ trans('labels.Login') }}</h6>
					<p>{{ trans("labels.Don't_have_an_account?") }}<span><a href="{{ URL::to('/register') }}" >{{ trans('labels.Create your account') }},</a></span>{{ trans('labels.it_takes_less_than_a_minute') }}</p>
					@if(session()->has('message'))
					    <div class="alert alert-danger">
					        {{ session()->get('message') }}
					    </div>
					@endif
					<form method="post" action="{{ URL::to('/checkuserLogin') }}">
						{{ csrf_field() }}
					    <div class="form-group">
					     
					      <input type="email" class="form-control" id="email" placeholder="{{ trans('labels.email') }} *" name="email" autofocus="" required=""> <label><img src="{{ URL::to('/resources/assets/img/user-login.png')}}"></label>
					    </div>
					    <div class="form-group">
					      <input type="password" class="form-control" placeholder="{{ trans('labels.password') }} *" name="password" autofocus="" required="">
					      <label><img src="{{ URL::to('/resources/assets/img/password-login.png')}}"></label>
					    </div>
					    <div class="check_log_rem">
						    <div class="checkbox_part">
						    	<div class="check_reti">
									<input type="checkbox" id="rember" class="check_decheck">
									<label><i class="fas fa-check"></i></label> 
							   </div>
							      <label for="checkOther">{{ trans('labels.Remember_me') }}</label>
							 </div>

							 <div class="forget_password_check">
							 	<a href="#">{{ trans('labels.Forget_password') }} ?</a>
							 </div>
                        </div>
                        <div class="login">
					    	<button type="submit" class="btn btn-default">{{ trans('labels.Login') }}</button>
						</div>
					 </form>
				</div>	
			</div>
			<div class="login_img">
				<div class="log_reg_img">
					<img src="{{ URL::to('/resources/assets/img/banner_inner_cast.png')}}">
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

@endsection