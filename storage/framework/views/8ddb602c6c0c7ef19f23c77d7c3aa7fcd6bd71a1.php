<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.newUsers')); ?></h3>   


    <div class="panel panel-default programcrcls">
        <div class="centerdiv">
            <div class="panel-body">
                <form action="<?php echo e(url('admin/users')); ?>" method="POST" enctype="multipart/form-data">
                    <div class="panel-heading">
                        <div class="form-group abovebtn-right">
                            <div class="col-md-12">
                                <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                            </div>
                        </div>
                    </div>

                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter">
                            <div class="form-group">
                                <label for="name"><?php echo e(trans('labels.FirstName')); ?> <span class="clsred">*</span></label>
                                <input type="text" name="name"  class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="lname"><?php echo e(trans('labels.LastName')); ?> <span class="clsred">*</span></label>
                                <input type="text" name="lname" id="lname" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="username"><?php echo e(trans('labels.UserName')); ?> <span class="clsred">*</span></label>        
                                <input type="text" name="username" onchange="userexist(this.value)" class="form-control" required> 
                                <span id="usersexist" style="color:red;"></span> 
                            </div>

                            <div class="form-group">
                                <label for="gender"><?php echo e(trans('labels.Gender')); ?> </label>        
                                <input type="radio" name="gender" checked="checked" value="1"><?php echo e(trans('labels.male')); ?>

                                <input type="radio" name="gender" value="2"> <?php echo e(trans('labels.female')); ?>

                            </div>

                            <div class="form-group">
                                <label for="gender"><?php echo e(trans('labels.aged')); ?> </label>        
                                <input type="checkbox" name="aged" value="1"> <?php echo e(trans('labels.aged')); ?>

                            </div>

                            <div class="form-group">
                                <label for="password"><?php echo e(trans('labels.Password')); ?> <span class="clsred">*</span></label>        
                                <input type="password" name="password" value="" class="form-control" required>    
                            </div>  

                            <div class="form-group">
                                <label for="email"><?php echo e(trans('labels.email')); ?> <span class="clsred">*</span></label>        
                                <input type="email" name="email" value="" class="form-control" required>    
                            </div>
                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.dateOfBirth')); ?></label>                      
                                <input class="date form-control" name="dob"  placeholder="<?php echo e(trans('labels.selectDate')); ?>" value="" type="text">  
                            </div>

                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.profileImage')); ?></label>                      
                                <input class="" name="image"  value="" type="file">  
                            </div>

                            <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.address')); ?></label>                      
                                <textarea name="address" placeholder="<?php echo e(trans('labels.enterAddress')); ?>"></textarea>
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
    </div>
    

<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
    function userexist(name)
    {
        $.ajax({
            type:'GET',
            url:'/schoolpro/users/userexist',
            data:'name='+name,
            success:function(data){
                if(data.val=="1")
                {
                    // document.getElementById("usersexist").innerHTML = "User already Exist!"; 
                }
                     
           }
        });

    }

</script> 
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>