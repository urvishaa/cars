<?php $__env->startSection('content'); ?>


<h3 class="page-title"><?php echo e(trans('labels.editCarBrand')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/carBrand/update/'.$carBrand->id)); ?>" method="POST" >
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/carBrand')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        
                    <?php echo csrf_field(); ?>


                    

                    <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.name')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="name" value="<?php echo e($carBrand->name); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ar"><?php echo e(trans('labels.Ar')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="ar" value="<?php echo e($carBrand->ar); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ku"><?php echo e(trans('labels.Ku')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="ku" value="<?php echo e($carBrand->ku); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus><?php echo e($carBrand->description); ?></textarea>
                          </div>
                          
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" <?php if(isset($carBrand->status)): ?> <?php echo e(old('status',$carBrand->status)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($carBrand->status)): ?> <?php echo e(old('status',$carBrand->status)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>
                                          
                          <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                    <a href="<?php echo e(url('admin/carBrand')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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