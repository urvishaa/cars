<?php $__env->startSection('content'); ?>
<style>
  .wrapper{
    display:  none !important;
  }
</style>
<div class="login-box">
  <div class="login-logo">     
    <div style="
    font-size: 25px;
"><!-- <b> <?php echo e(trans('labels.welcome_message')); ?><?php echo e(trans('labels.welcome_message_to')); ?></b> -->
  <img src="/resources/assets/img/property-logo.png">
</div>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Change Password</p>
    
	<?php if(Session::has('message')): ?>
      <div class="alert alert-danger">
        <p><?php echo e(Session::get('message')); ?></p>
      </div>
    <?php endif; ?>

    
    <form action="<?php echo e(url('/ForgotPassword/save')); ?>" method="POST" enctype="multipart/form-data">
         <div class="panel-heading">
            </div>
            <?php echo csrf_field(); ?>


            <input type="hidden"  name="userId" value="<?php echo e($user_email->id); ?>" class="form-control">
                          
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


<?php echo $__env->make('admin.layoutLlogin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>