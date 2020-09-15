<?php $__env->startSection('content'); ?>


<h3 class="page-title"><?php echo e(trans('labels.editUser')); ?></h3>  


    <div class="panel panel-default programcrcls">
        
            <div class="panel-body">
                <form action="<?php echo e(url('admin/users/'.$user->id)); ?>" method="POST" enctype="multipart/form-data">
                    <div class="panel-heading">
              
                        <div class="form-group abovebtn-right">
                             
                              <div class="col-md-12">
                                <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                              </div>
                        </div>
                    </div>
                        <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter">
                            <div class="form-group">
                                <label for="name"><?php echo e(trans('labels.name')); ?> <span class="clsred">*</span></label>
                                <input type="text" name="name" value="<?php echo e($user->name); ?>" class="form-control" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="lname"><?php echo e(trans('labels.LastName')); ?> <span class="clsred">*</span></label>
                                <input type="text" name="lname" id="lname" value="<?php echo e($user->lname); ?>" class="form-control" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="username"><?php echo e(trans('labels.userName')); ?> <span class="clsred">*</span></label>        
                                <input type="text" name="username" value="<?php echo e($user->username); ?>" class="form-control" required autofocus> 
                            </div>

                            <div class="form-group">
                                <label for="gender"><?php echo e(trans('labels.gender')); ?></label>        
                                <input type="radio" name="gender" value="1" <?php echo e($user->gender == 1 || $user->gender == '' ? 'checked="checked"' : ''); ?>> <?php echo e(trans('labels.male')); ?>

                                <input type="radio" name="gender" value="2" <?php echo e($user->gender == 2 ? 'checked="checked"' : ''); ?>> <?php echo e(trans('labels.female')); ?>

                            </div>

                            <div class="form-group">
                                <label for="aged"><?php echo e(trans('labels.aged')); ?> </label>        
                                <input type="checkbox" name="aged" value="1" <?php echo e($user->aged == 1 ? 'checked="checked"' : ''); ?> > <?php echo e(trans('labels.aged')); ?>

                            </div>
                            
                            <div class="form-group">
                                <label for="password"><?php echo e(trans('labels.password')); ?> </label>        
                                <input type="password" name="password" value="" class="form-control" >    
                                <input type="hidden" name="old_password" id="old_password" value="<?php echo e($user->password); ?>" >
                            </div>

                            <div class="form-group">
                                <label for="email"><?php echo e(trans('labels.email')); ?> <span class="clsred">*</span></label>        
                                <input type="Email" name="email" value="<?php echo e($user->email); ?>" class="form-control" required autofocus>    
                            </div>
                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.dateOfBirth')); ?> </label>        
                                <input type="text" name="dob" value="<?php echo e($user->dob); ?>" class="date form-control">    
                            </div>       

                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.profileImage')); ?></label>                      
                                <input class="col-md-3" name="image"  value="" type="file">  

                                <?php if($user->image != ""): ?>
                                    <div class="col-md-2"><img src="<?php if(isset($user->image)): ?><?php echo e(url('/public/profileImage/'.$user->image )); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/></div>
                                <?php else: ?>
                                    <div class="col-md-2"><img src="<?php echo e(url('/public/default-image.jpeg' )); ?>" class="btn popup_image" height="100px" width="100px"/></div>
                                <?php endif; ?>
                                <input type="hidden" name="oldimage" value="<?php echo e($user->image); ?>">
                            </div>

                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.address')); ?></label>                      
                                <textarea name="address" placeholder="Enter Address"><?php echo e($user->address); ?></textarea>
                            </div>
                            
                            
                            <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                    <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                  </div>
                            </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        
    </div>
    
    

<script type="text/javascript">

    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    });  

</script> 

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>