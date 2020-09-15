<?php $__env->startSection('content'); ?>


<h3 class="page-title">Edit User</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/users/'.$user->id)); ?>" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    <h3 style="text-align: center;">Edit User</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                        <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>


                    <div class="form-group">
                        <label for="prolevid">User Type <span class="clsred">*</span></label>  
                        <select required autofocus id="u_type" name="u_type" class="field">
                            <option value="">--Select User Group--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $usergroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro->id); ?>" <?php echo e($user->u_type ==  $pro->id ? 'selected="selected"' : ''); ?>><?php echo e($pro->typeName); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                        </select>            
                    </div>   

                 
                    <div class="form-group">
                        <label for="name">Name <span class="clsred">*</span></label>
                        <input type="text" name="name" value="<?php echo e($user->name); ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="username">Username <span class="clsred">*</span></label>        
                        <input type="text" name="username" value="<?php echo e($user->username); ?>" class="form-control" required autofocus> 
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>        
                        <input type="radio" name="gender" value="1" <?php echo e($user->gender == 1 || $user->gender == '' ? 'checked="checked"' : ''); ?>> Male
                        <input type="radio" name="gender" value="2" <?php echo e($user->gender == 2 ? 'checked="checked"' : ''); ?>> Female
                    </div>

                    <div class="form-group">
                        <label for="password">password </label>        
                        <input type="password" name="password" value="" class="form-control" >    
                        <input type="hidden" name="old_password" id="old_password" value="<?php echo e($user->password); ?>" >
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="clsred">*</span></label>        
                        <input type="Email" name="email" value="<?php echo e($user->email); ?>" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth </label>        
                        <input type="text" name="dob" value="<?php echo e($user->dob); ?>" class="date form-control">    
                    </div>       

                    <div class="form-group">
                        <label for="dob">Profile Image</label>                      
                        <input class="form-control" name="image"  value="" type="file">  
                        <input type="hidden" name="oldimage" value="<?php echo e($user->image); ?>">
                    </div>

                    <div class="form-group">
                        <label for="dob">Address</label>                      
                        <textarea name="address" placeholder="Enter Address"><?php echo e($user->address); ?></textarea>
                    </div>
                    

                    
                   <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
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