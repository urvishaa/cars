<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
  
  <!-- Main content -->
     <h3 class="page-title"><?php if(empty($result['edituser']->id)) { ?>
               <?php echo e(trans('labels.add_userGroup')); ?>  
     <?php } else { ?>
              <?php echo e(trans('labels.edit_userGroup')); ?>

     <?php } ?> </h3>    
     <div class="panel panel-default">
        <div class="panel-heading">
           <?php if(empty($result['edituser']->id)) { ?>
               <?php echo e(trans('labels.add_userGroup')); ?>  
           <?php } else { ?>
               <?php echo e(trans('labels.edit_userGroup')); ?>

           <?php } ?>
        </div>
      <!-- SELECT2 EXAMPLE -->
        <div class="panel-body table-responsive progrmslistcls">  
          <div class="prolisttabcls">
            <form action="<?php echo e(url('admin/saveUserGroup')); ?>" method="POST" >
              <?php echo e(csrf_field()); ?>

                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($result['edituser']->id)): ?> <?php echo e($result['edituser']->id); ?> <?php endif; ?>">
            
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo e(trans('labels.TYPE')); ?></label>
                        <input type="text" class="form-control" required="" name="typeName" id="typeName" value="<?php if(isset($result['edituser']->typeName)): ?> <?php echo e($result['edituser']->typeName); ?> <?php endif; ?>">
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.PARENTGROUP')); ?></label>
                        <select class="form-control" id="parentGroup" name="parentGroup" style="width: 100%;">
                          <option value=""><?php echo e(trans('labels.select_parentGroup')); ?></option>
                            <?php  
                              $test=0;
                             ?>
                            <?php $__currentLoopData = $result['getparentName']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parenName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($test == 0): ?> 
                              <?php if(isset($result['edituser']->parentGroup)): ?> 
                              <?php if($result['edituser']->parentGroup == $parenName->id): ?> 
                                <option selected value="<?php echo e($parenName->id); ?>"><?php echo e($parenName->typeName); ?></option>
                                
                              <?php else: ?>
                                <option value="<?php echo e($parenName->id); ?>"><?php echo e($parenName->typeName); ?></option>
                              <?php endif; ?>
                            <?php else: ?> 
                                <option value="<?php echo e($parenName->id); ?>"><?php echo e($parenName->typeName); ?></option>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>

                      <input type="submit" class="btn btn-default" name="submit" id="submit_button" value="<?php echo e(trans('labels.SUBMIT')); ?>">

                    </div>
                  </div>
                </div>        
            </form>
          </div>
        </div>
    </div>
  <!-- /.content --> 
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>