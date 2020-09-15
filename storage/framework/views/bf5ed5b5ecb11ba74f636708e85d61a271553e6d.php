

<?php $__env->startSection('content'); ?>

<div class="super_container">
	<div class="super_overlay"></div>
	
	
</div>
<!-- Info message -->

<div class="login_main_cls">
	<div class="container">
		<div class="login_inr">
			<div class="login_info">
				<div class="log_info_left">

					<h6><?php echo e(trans('labels.Login')); ?></h6>
					<?php if(session()->has('message')): ?>
					    <div class="alert alert-danger">
					        <?php echo e(session()->get('message')); ?>

					    </div>
					<?php endif; ?>
					<form method="post" action="<?php echo e(URL::to('/checkuserLogin')); ?>">
						<?php echo e(csrf_field()); ?>

					    <div class="form-group">
					     
					      <input type="email" class="form-control" id="email" placeholder="<?php echo e(trans('labels.email')); ?> *" name="email" autofocus="" required=""> <label><img src="<?php echo e(URL::to('/resources/assets/img/user-login.png')); ?>"></label>
					    </div>
					    <div class="form-group">
					      <input type="password" class="form-control" placeholder="<?php echo e(trans('labels.password')); ?> *" name="password" autofocus="" required="">
					      <label><img src="<?php echo e(URL::to('/resources/assets/img/password-login.png')); ?>"></label>
					    </div>
					    <div class="check_log_rem">
						    <div class="checkbox_part">
						    	<div class="check_reti">
									<input type="checkbox" id="rember" class="check_decheck">
									<label><i class="fas fa-check"></i></label> 
							   </div>
							      <label for="checkOther"><?php echo e(trans('labels.Remember_me')); ?></label>
							 </div>

							 <div class="forget_password_check">
							 	<a href="#"><?php echo e(trans('labels.Forget_password')); ?> ?</a>
							 </div>
                        </div>
                        <div class="login">
					    	<button type="submit" class="btn btn-default"><?php echo e(trans('labels.Login')); ?></button>
						</div>
						<p class="crt-acunt"><?php echo e(trans("labels.Don't_have_an_account?")); ?><a href="<?php echo e(URL::to('/register')); ?>" ><?php echo e(trans('labels.Create your account')); ?>,</a><?php echo e(trans('labels.it_takes_less_than_a_minute')); ?></p>
					 </form>
				</div>	
			</div>
			<div class="login_img">
				<div class="log_reg_img">
					<img src="<?php echo e(URL::to('/resources/assets/img/car-image.png')); ?>">
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>