<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.editfuelType')); ?> </h3>  

        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(route('admin.fueltype.update',['id'=>$fueltype->id])); ?>" method="POST" >
                <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(route('admin.fueltype')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        
                    <?php echo csrf_field(); ?>


                    

                    <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="fename"><?php echo e(trans('labels.name')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="name" value="<?php echo e($fueltype->name); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="fename"><?php echo e(trans('labels.Ar')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="ar" value="<?php echo e($fueltype->ar); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="fename"><?php echo e(trans('labels.Ku')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="ku" value="<?php echo e($fueltype->ku); ?>" class="form-control" required autofocus>
                          </div>
                          
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" <?php if(isset($fueltype->published)): ?> <?php echo e(old('published',$fueltype->published)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($fueltype->published)): ?> <?php echo e(old('published',$fueltype->published)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>
                                          
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <a href="<?php echo e(route('admin.fueltype')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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