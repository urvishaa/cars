<?php $__env->startSection('content'); ?>

<h3 class="page-title">Add PDF report</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/pdf_report')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Add PDF report</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/pdf_report')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>


                     
                  
                     
                    <div class="form-group">
                        <label for="price">Property Name<span class="clsred">*</span></label>
                            <select name="pro_name" id="pro_name" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $Property; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro_name->id); ?>"><?php echo e($pro_name->property_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">PDF Upload <span class="clsred">*</span></label>
                        <input type="file" name="pdf_upload" value="" class="form-control" required autofocus>
                    </div>
                    
                    
                    <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property_features')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
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