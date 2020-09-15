<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

   <!-- Main content -->
<section class="content">

    <div class="row">
        
        <div class="nav-tabs-custom">
           
            <div class="tab-content">
                <div class=" active tab-pane" id="profile">
                  
                  <!-- The timeline -->
                    <?php echo Form::open(array('url' =>route('buynow.save'), 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','validate')); ?>

                     
                        <input type="hidden" name="total" value="<?php echo e($result['total']); ?>">   
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label"><?php echo e(trans('labels.name')); ?><span style="color: red">*</span></label>
        
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" value="" class="form-control" required autofocus>
                                
                            </div>
                        </div>
                      
                      
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label"><?php echo e(trans('labels.mobile')); ?>

                            </label>
        
                            <div class="col-sm-10">
                                <input type="text" name="mobile" id="mobile" value="" class="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pincode" class="col-sm-2 control-label"><?php echo e(trans('labels.pincode')); ?>

                            </label>
        
                            <div class="col-sm-10">
                                <input type="text" name="pincode" id="pincode" value="" class=""  required>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.Address')); ?> <span style="color: red">*</span></label>
        
                            <div class="col-sm-10">
                                <textarea name="address" id="address" class="form-control"  required></textarea>
                                
                            </div>
                        </div>

                      
                        <div class="form-group">
                            <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.City')); ?></label>
                            <div class="col-sm-10">                       
                                <select class="form-control" name="city"  required>
                                    <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                        <?php $__currentLoopData = $result['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option  value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger"><?php echo e(trans('labels.placeOrder')); ?></button>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
          <!-- /.nav-tabs-custom -->
        <!-- /.col -->
    </div>
      <!-- /.row -->

  </section>
  <!-- /.content --> 


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>