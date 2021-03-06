<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.newCarModel')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/category/save')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/category')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                      <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.name')); ?><span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ar"><?php echo e(trans('labels.Ar')); ?><span class="clsred">*</span></label>
                              <input type="text" name="ar" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ku"><?php echo e(trans('labels.Ku')); ?><span class="clsred">*</span></label>
                              <input type="text" name="ku" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="car_brand_id"><?php echo e(trans('labels.carBrand')); ?><span class="clsred">*</span></label>
                              <select class="form-control" name="car_brand_id" required>
                                <option value="" >--Selece Car Brand--</option>
                                <?php $__currentLoopData = $carBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carBrand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($carBrand->id); ?>" ><?php echo e($carBrand->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="published"><?php echo e(trans('labels.published')); ?><span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" selected=""><?php echo e(trans('labels.published')); ?></option>
                                <option value="2"><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <a href="<?php echo e(url('admin/category')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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