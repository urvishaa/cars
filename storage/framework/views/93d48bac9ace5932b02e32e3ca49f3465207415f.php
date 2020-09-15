<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.importFile')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <div class="panel-heading">
                    
                
                <form action="<?php echo e(route('carBrand.import.save')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.import')); ?></button>
                            <a href="<?php echo e(url('admin/carBrand')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter"> 
                            <div class="form-group">
                                <label for="Sample File"><?php echo e(trans('labels.sampleFile')); ?> <span class="clsred">*</span></label>
                                <!-- <input type="file" name="car_brand_csv" required> -->
                                <a href="<?php echo e(route('carBrand.sample.download')); ?>" class="btn btn-primary"><?php echo e(trans('labels.download')); ?></a>

                            </div>
                            
                            <div class="form-group">
                                <label for="name"><?php echo e(trans('labels.selectFile')); ?> <span class="clsred">*</span></label>
                                <input type="file" name="car_brand_csv" required>
                            </div>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.import')); ?></button>
                                  <a href="<?php echo e(url('admin/carBrand')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    


<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>