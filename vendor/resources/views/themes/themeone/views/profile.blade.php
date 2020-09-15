@extends('layout')
@section('content')

<div class="super_container">
	<div class="super_overlay"></div>
	

	<div class="profile">
		<div class="container">
			@if(session()->has('message'))
			    <div class="alert alert-danger">
			        {{ session()->get('message') }}
			    </div>
			@endif
			<form  method="post" action="{{ URL::to('/updateprofile') }}">
				<div class="row">
					<div class="col-md-5 col-lg-4">
						<div class="profile-pic">
							<div class="pro-pic">
								<div class="bg-pro-pic">
									<img src="{{ URL::to('/public/bg.jpeg')}}">
								</div>
								<div class="pro-main-pic">
									@if(file_exists(public_path().'/profileImage/'.@$detail->image)  && @$detail->image != '')
										<img src="{{ URL::to('/public/profileImage/'.@$detail->image) }}" id="chimg">
									@else
										<img src="{{ URL::to('/resources/assets/img/pro-pic.jpg')}}" id="chimg">
									@endif
									
								</div>
							</div>
							<div class="pro-nam">
								<h3>{{ ucfirst(@$detail->username) }}</h3>
								<div class="edit_pro">
									<div class="edit">
										<input type="file" name="" id="ch-img" class="edit-pro" value="Edit image">
										 <label>{{ trans('labels.editprofile') }}</label>
									</div>
									<label for="edit_na"></label>
								</div>
							</div>
						</div>
						<form method="post" action="{{ URL::to('/changePassword') }}">
						<div class="pro-cng-pswrd">
							  <span style="color: white;background-color: green;border: none;display: none;" id="done" class="form-control">{{ trans('labels.passwordchangesuccessful') }}</span>
							<label>{{ trans('labels.changePassword') }}</label>
							<div class="pro-pswrd">
								<input type="password" name="password" id="txtPassword" class="form-control" placeholder="{{ trans('labels.password') }}">
								<img src="{{ URL::to('/resources/assets/img/lock-password.png')}}">
							</div>
							<div class="pro-pswrd">
								<input type="password"  id="txtConfirmPassword" class="form-control" placeholder="{{ trans('labels.Confirm Password') }}">
								<img src="{{ URL::to('/resources/assets/img/lock-password.png')}}">
							</div>
							<span id="valid_password" style="display:none;color:red;">{{ trans('labels.passwordNotMatch') }} *</span>
							<button class="pro-pass-btn" type="button" onclick="return confirm();">{{ trans('labels.save') }}</button>
						</div>
						</form>
					</div>
					
					<div class="col-md-7 col-lg-8">
						<div class="pro-input">
							<label>{{ trans('labels.FirstName') }}</label>
							<div class="inpt-txt">
								<input type="text" name="name" class="form-control" placeholder="{{ trans('labels.FirstName') }}" value="{{ @$detail->name }}">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>{{ trans('labels.LastName') }}</label>
							<div class="inpt-txt">
								<input type="text" name="lname" class="form-control" placeholder="{{ trans('labels.LastName') }}" value="{{ @$detail->lname }}">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>{{ trans('labels.phone') }}</label>
							<div class="inpt-txt">
								<input type="text" name="phone" class="form-control" placeholder="{{ trans('labels.phone') }}" value="{{ @$detail->phone }}">
								<i class="fas fa-phone"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>{{ trans('labels.email') }}</label>
							<div class="inpt-txt">
								<input type="text" name="email" class="form-control" placeholder="{{ trans('labels.email') }}" value="{{ @$detail->email }}">
								<i class="far fa-envelope"></i>
							</div>
						</div>

						<div class="pro-input">
							<label>{{ trans('labels.userName') }}</label>
							<div class="inpt-txt">
								<input type="text" name="username" class="form-control" placeholder="{{ trans('labels.userName') }}" value="{{ @$detail->username }}">
								<i class="fa fa-id-card" aria-hidden="true"></i>
							</div>
						</div>
						
						<div class="pro-input">
							<label>{{ trans('labels.dateOfBirth') }}</label>
							<div class="inpt-txt">
								<input type="date" name="dob" class="form-control" placeholder="{{ trans('labels.dateOfBirth') }}" value="{{ @$detail->dob }}">
								<i class="far fa-calendar-alt"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>{{ trans('labels.address') }}</label>
							<div class="inpt-txt">
								<input type="text" name="address" class="form-control" placeholder="{{ trans('labels.address') }}" value="{{ @$detail->address }}">
								<i class="fas fa-map-marker-alt"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>{{ trans('labels.gender') }}</label>
							<div class="inpt-txt rdio">
								<div class="rdio-main">
									<div class="checkbox">
									  	  <div class="chec_bx_tr">
										  	  <input type="radio" name="gender" class="red"  value="1" {{ @$detail->gender == 1 || @$detail->gender == '' ? 'checked="checked"' : '' }}>
										  	  <label><i class="fas fa-circle"></i></label>
									  	  </div>
									  	  <label class="mt-rd" for="test5" >{{ trans('labels.male') }}</label>
									</div>
								<div class="checkbox">
							  	  <div class="chec_bx_tr female">
								  	  <input type="radio" name="gender" class="red"  value="2" {{ @$detail->gender == 2 ? 'checked="checked"' : '' }}>
								  	  <label><i class="fas fa-circle"></i></label>
							  	  </div>
							  	  <label class="mt-rd" for="test5">{{ trans('labels.female') }}</label>
							  </div>
							  </div>
							</div>
						</div>
						
						
						<!-- <div class="pro-input">
							<label>City</label>
							<div class="inpt-txt">
								<select name="city" class="form-control">
									<option>Baghdad</option>
									<option>Baghdad</option>
								</select>
								<i class="fas fa-chevron-down"></i>
							</div>
						</div>
						<div class="pro-input">
							<label>Change Language</label>
							<div class="inpt-txt">
								<select class="form-control">
									<option>English</option>
									<option>English</option>
								</select>
								<i class="fas fa-chevron-down"></i>
							</div>
						</div> -->
						<div class="probtn">
							<button class="pro-btn" type="submit">{{ trans('labels.save') }}</button>
						</div>
					</div>
					
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
  
  $(document).ready(function() {

  $('#ch-img').on('change', function() {

    var fileName = '';
    fileName = $(this).val();
    $('#file-selected').html(fileName);


    var imageData = new FormData();
    imageData.append('image', $('#ch-img')[0].files[0]);

    //Make ajax call here:
    $.ajax({
      url: '{{ URL::to("/edituserimage") }}',
      type: 'POST',
      processData: false, // important
      contentType: false, // important
      data: imageData,
      beforeSend: function() {
        $("#err").fadeOut();
      },
      success: function(result) {
        if (result == '0') {
          $("#err").html("Invalid File. Image must be JPEG, PNG or GIF.").fadeIn();
        } else {
          $("#chimg").attr('src','<?php echo asset('')."public/profileImage/"?>' +result);
        
        }
      },
      error: function(result) {
        $("#err").html("errorcity").fadeIn();
      }
    });

  });

});

function confirm() {
	 jQuery("#done").hide();
var password=jQuery('#txtPassword').val();
var confirmPassword=jQuery('#txtConfirmPassword').val();

  if (password != confirmPassword) {
  
      document.getElementById('valid_password').style.display='';
  }
  else
  {
  
    document.getElementById('valid_password').style.display='none';

    $.ajax({
      url: '{{ URL::to("/changePassword") }}',
      type: 'POST',
      data: {password:password},
     
      success: function(result) {
    
        if (result == '1') {
           $("#done").show(); 
            setTimeout(function() { $("#done").hide(); }, 5000);
        }
      },
     
    });
  }

   

}  
</script>
@endsection

