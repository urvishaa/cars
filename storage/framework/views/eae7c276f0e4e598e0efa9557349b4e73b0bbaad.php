
<?php $__env->startSection('content'); ?>

<div class="super_container">
	<div class="super_overlay"></div>
	

	<div class="profile">
		<div class="container">
			<?php if(session()->has('message')): ?>
			    <div class="alert alert-danger">
			        <?php echo e(session()->get('message')); ?>

			    </div>
			<?php endif; ?>
			<form  method="post" action="<?php echo e(URL::to('/updateprofile')); ?>">
				<div class="row">
					<div class="col-md-5 col-lg-4">
						<div class="profile-pic">
							<div class="pro-pic">
								<div class="bg-pro-pic">
									<img src="<?php echo e(URL::to('/public/bg.jpeg')); ?>">
								</div>
								<div class="pro-main-pic">
									<?php if(file_exists(public_path().'/profileImage/'.@$detail->image)  && @$detail->image != ''): ?>
										<img src="<?php echo e(URL::to('/public/profileImage/'.@$detail->image)); ?>" id="chimg">
									<?php else: ?>
										<img src="<?php echo e(URL::to('/resources/assets/img/pro-pic.jpg')); ?>" id="chimg">
									<?php endif; ?>
									
								</div>
							</div>
							<div class="pro-nam">
								<h3><?php echo e(ucfirst(@$detail->username)); ?></h3>
								<div class="edit_pro">
									<div class="edit">
										<input type="file" name="" id="ch-img" class="edit-pro" value="Edit image">
										 <label><?php echo e(trans('labels.editprofile')); ?></label>
									</div>
									<label for="edit_na"></label>
								</div>
							</div>
						</div>
						<form method="post" action="<?php echo e(URL::to('/changePassword')); ?>">
						<div class="pro-cng-pswrd">
							  <span style="color: white;background-color: green;border: none;display: none;" id="done" class="form-control"><?php echo e(trans('labels.passwordchangesuccessful')); ?></span>
							<label><?php echo e(trans('labels.changePassword')); ?></label>
							<div class="pro-pswrd">
								<input type="password" name="password" id="txtPassword" class="form-control" placeholder="<?php echo e(trans('labels.password')); ?>">
								<img src="<?php echo e(URL::to('/resources/assets/img/lock-password.png')); ?>">
							</div>
							<div class="pro-pswrd">
								<input type="password"  id="txtConfirmPassword" class="form-control" placeholder="<?php echo e(trans('labels.Confirm Password')); ?>">
								<img src="<?php echo e(URL::to('/resources/assets/img/lock-password.png')); ?>">
							</div>
							<span id="valid_password" style="display:none;color:red;"><?php echo e(trans('labels.passwordNotMatch')); ?> *</span>
							<button class="pro-pass-btn" type="button" onclick="return confirm();"><?php echo e(trans('labels.save')); ?></button>
						</div>
						</form>
					</div>
					
					<div class="col-md-7 col-lg-8">
						<div class="pro-input">
							<label><?php echo e(trans('labels.FirstName')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="name" class="form-control" placeholder="<?php echo e(trans('labels.FirstName')); ?>" value="<?php echo e(@$detail->name); ?>">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
						</div>
						<div class="pro-input">
							<label><?php echo e(trans('labels.LastName')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="lname" class="form-control" placeholder="<?php echo e(trans('labels.LastName')); ?>" value="<?php echo e(@$detail->lname); ?>">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
						</div>
						<div class="pro-input">
							<label><?php echo e(trans('labels.phone')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="phone" class="form-control" placeholder="<?php echo e(trans('labels.phone')); ?>" value="<?php echo e(@$detail->phone); ?>">
								<i class="fas fa-phone"></i>
							</div>
						</div>
						<div class="pro-input">
							<label><?php echo e(trans('labels.email')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="email" class="form-control" placeholder="<?php echo e(trans('labels.email')); ?>" value="<?php echo e(@$detail->email); ?>">
								<i class="far fa-envelope"></i>
							</div>
						</div>

						<div class="pro-input">
							<label><?php echo e(trans('labels.userName')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="username" class="form-control" placeholder="<?php echo e(trans('labels.userName')); ?>" value="<?php echo e(@$detail->username); ?>">
								<i class="fa fa-id-card" aria-hidden="true"></i>
							</div>
						</div>
						
						<div class="pro-input">
							<label><?php echo e(trans('labels.dateOfBirth')); ?></label>
							<div class="inpt-txt">
								<input type="date" name="dob" class="form-control" placeholder="<?php echo e(trans('labels.dateOfBirth')); ?>" value="<?php echo e(@$detail->dob); ?>">
								<i class="far fa-calendar-alt"></i>
							</div>
						</div>
						<div class="pro-input">
							<label><?php echo e(trans('labels.address')); ?></label>
							<div class="inpt-txt">
								<input type="text" name="address" class="form-control" placeholder="<?php echo e(trans('labels.address')); ?>" value="<?php echo e(@$detail->address); ?>">
								<i class="fas fa-map-marker-alt"></i>
							</div>
						</div>
						<div class="pro-input">
							<label><?php echo e(trans('labels.gender')); ?></label>
							<div class="inpt-txt rdio">
								<div class="rdio-main">
									<div class="checkbox">
									  	  <div class="chec_bx_tr">
										  	  <input type="radio" name="gender" class="red"  value="1" <?php echo e(@$detail->gender == 1 || @$detail->gender == '' ? 'checked="checked"' : ''); ?>>
										  	  <label><i class="fas fa-circle"></i></label>
									  	  </div>
									  	  <label class="mt-rd" for="test5" ><?php echo e(trans('labels.male')); ?></label>
									</div>
								<div class="checkbox">
							  	  <div class="chec_bx_tr female">
								  	  <input type="radio" name="gender" class="red"  value="2" <?php echo e(@$detail->gender == 2 ? 'checked="checked"' : ''); ?>>
								  	  <label><i class="fas fa-circle"></i></label>
							  	  </div>
							  	  <label class="mt-rd" for="test5"><?php echo e(trans('labels.female')); ?></label>
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
							<button class="pro-btn" type="submit"><?php echo e(trans('labels.save')); ?></button>
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
      url: '<?php echo e(URL::to("/edituserimage")); ?>',
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
      url: '<?php echo e(URL::to("/changePassword")); ?>',
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>