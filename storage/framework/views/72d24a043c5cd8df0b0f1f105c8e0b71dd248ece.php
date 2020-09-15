<?php $__env->startSection('content'); ?>


<h3 class="page-title"><?php echo e(trans('labels.editPdfFile')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">

                <form action="<?php echo e(url('admin/pdf_report/update_pdfFile/'.$Pdf_report->id)); ?>" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    <h3 style="text-align: center;"><?php echo e(trans('labels.editPdfFile')); ?></h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/pdf_report')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        
                    <?php echo csrf_field(); ?>


                 
                    <div class="form-group">
                        <label for="pro_name"><?php echo e(trans('labels.propertyName')); ?> <span class="clsred">*</span></label>
                            <select name="pro_name" id="pro_name" class="field"  autofocus required>
                                 <option value=""><?php echo e(trans('labels.selectPropertyName')); ?></option>
                                    <?php $__empty_1 = true; $__currentLoopData = $Property; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro_name->id); ?>" <?php echo e($Pdf_report->pro_name ==  $pro_name->id ? 'selected="selected"' : ''); ?> ><?php echo e($pro_name->property_name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo e(trans('labels.pdfUpload')); ?></label>
                        <div class="form-group">
                        <?php if (isset($Pdf_report->pdf_upload)) { ?>
                          <input type="file" name="pdf_upload" id="pdf_upload" class="form-control" value="">
                          <input type="hidden" class="form-control" name="oldpdf_upload" id="oldpdf_upload" value="<?php if(isset($Pdf_report->pdf_upload)): ?><?php echo e($Pdf_report->pdf_upload); ?> <?php endif; ?>">
                        <?php } ?>
                        </div>
                    </div>
                                    
                    
                   <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/pdf_report')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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