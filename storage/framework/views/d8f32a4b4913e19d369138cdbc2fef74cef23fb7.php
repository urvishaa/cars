
<?php $__env->startSection('content'); ?>

<div class="super_container">
	<div class="super_overlay"></div>
	
</div>

<div class="login_main_cls regis_main">
	<div class="container">
		<div class="login_inr regis_inr">
			<div class="login_info">
				<div class="log_info_left regis_tmr">
					<h6><?php echo e(trans('labels.Register')); ?></h6>
					
					<?php if(session()->has('message')): ?>
					    <div class="alert alert-danger">
					        <?php echo e(session()->get('message')); ?>

					    </div>
					<?php endif; ?>

					<form method="post" action="<?php echo e(URL::to('/insertuser')); ?>">
					    <div class="form-group">
					     
					      <input type="text" class="form-control"  placeholder="<?php echo e(trans('labels.userName')); ?> *" name="username" value="" required=""> <label><img src="<?php echo e(URL::to('/resources/assets/img/user-login.png')); ?>"></label>
					    </div>
					    <div class="form-group">
					      <input type="email" class="form-control"  placeholder="<?php echo e(trans('labels.email')); ?> *" name="email" value="" required="">
					      <label><img src="<?php echo e(URL::to('/resources/assets/img/message.png')); ?>"></label>
					    </div>
					     <div class="form-group">
					      <input type="password" class="form-control" id="txtPassword" placeholder="<?php echo e(trans('labels.password')); ?> *" name="password">
					      <label><img src="<?php echo e(URL::to('/resources/assets/img/password-login.png')); ?>"></label>
					    </div>
					     <div class="form-group">
					      <input type="password" class="form-control" id="txtConfirmPassword" placeholder="<?php echo e(trans('labels.Confirm Password')); ?> *">
					      <label><img src="<?php echo e(URL::to('/resources/assets/img/password-login.png')); ?>"></label>
					      <span id="valid_password" style="display:none;color:red;"><?php echo e(trans('labels.passwordAndConfirmPasswordSame')); ?> *</span>
					    </div>
					    
                        <div class="register login">
					    	<button type="submit" onclick="return confirm();" class="btn btn-default"><?php echo e(trans('labels.Register')); ?></button>
						</div>
						<p class="crt-acunt"><?php echo e(trans('labels.Already_have_an_account?')); ?><span><a href="<?php echo e(URL::to('/login')); ?>" ><?php echo e(trans('labels.Login')); ?>.</a></span></p>
					 </form>
				</div>	
			</div>
			<div class="login_img">
				<div class="log_reg_img">
					<img class="rvrc-img" src="<?php echo e(URL::to('/resources/assets/img/sports-car.png')); ?>">
					<div class="log_img">
						<div class="log_wel">
							<h6><?php echo e(trans('labels.Welcome')); ?></h6>
							<p><?php echo e(trans('labels.Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy & sell')); ?> </p>
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
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>