<?php $__env->startSection('content'); ?>

<h3 class="page-title">Setting</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/setting_payment/updatePaymentKey/'.$settingPayment['id'])); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Setting</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/setting_payment')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>


                     
                  
                     
                    <div class="form-group">
                        <label for="price">Stripe Key <span class="clsred">*</span></label>
                        <input type="text" name="stripe_key" value="<?php echo e($settingPayment['stripe_key']); ?>" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="name">Published Key <span class="clsred">*</span></label>
                        <input type="text" name="published_key" value="<?php echo e($settingPayment['published_key']); ?>" class="form-control" required autofocus>
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