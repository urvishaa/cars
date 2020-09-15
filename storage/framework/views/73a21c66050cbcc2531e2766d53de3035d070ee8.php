<?php $__env->startSection('content'); ?>

<h3 class="page-title">New Users</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/users')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Create Users</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>


                     <div class="form-group">
                        <label for="name">User Type <span class="clsred">*</span></label>
                            <select name="u_type" id="u_type" class="field"  autofocus required>
                                 <option value="">--Select User Group--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $usergroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro->id); ?>"><?php echo e($pro->typeName); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>
                  
                     
                    <div class="form-group">
                        <label for="name">Name <span class="clsred">*</span></label>
                        <input type="text" name="name" value="" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="username">Username <span class="clsred">*</span></label>        
                        <input type="text" name="username" value="" onchange="userexist(this.value)" class="form-control" required autofocus> 
                        <span id="usersexist" style="color:red;"></span> 
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender </label>        
                        <input type="radio" name="gender" checked="checked" value="1"> Male
                        <input type="radio" name="gender" value="2"> Female
                    </div>


                    <div class="form-group">
                        <label for="password">password <span class="clsred">*</span></label>        
                        <input type="password" name="password" value="" class="form-control" required autofocus>    
                    </div>  

                    <div class="form-group">
                        <label for="email">Email <span class="clsred">*</span></label>        
                        <input type="Email" name="email" value="" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>                      
                        <input class="date form-control" name="dob"  placeholder="select date" value="" type="text">  
                    </div>

                    <div class="form-group">
                        <label for="dob">Profile Image</label>                      
                        <input class="form-control" name="image"  value="" type="file">  
                    </div>

                    <div class="form-group">
                        <label for="dob">Address</label>                      
                        <textarea name="address" placeholder="Enter Address"></textarea>
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