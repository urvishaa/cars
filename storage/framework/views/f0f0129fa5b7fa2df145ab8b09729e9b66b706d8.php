<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

   
<section class="chkoutfrm">
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div class="cart-car-img">
                    <img class="rvrc-img" src="<?php echo e(URL::to('/resources/assets/img/sports-car.png')); ?>">
                </div>

            </div>
            
            <div class="col-md-6">               
                      
                <!-- The timeline -->
                <?php echo Form::open(array('url' =>route('buynow.save'), 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','validate')); ?>



                    <div class="mb-3">
                        <label for="name"><?php echo e(trans('labels.name')); ?> <span style="color: red">*</span></label>
                        <input type="text" name="name" id="name" value="" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="mobile"><?php echo e(trans('labels.mobile')); ?><span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="" required>
                    </div>

                    <div class="mb-3">
                      <label for="address"><?php echo e(trans('labels.Address')); ?> <span style="color: red">*</span></label>
                      <textarea name="address" id="address" class="form-control"  required></textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for=""><?php echo e(trans('labels.City')); ?><span style="color: red">*</span></label>
                        <select class="custom-select d-block w-100" name="city"  required>
                            <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                            <?php $__currentLoopData = $result['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option  value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                     
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-myclr btn-block" type="submit"><?php echo e(trans('labels.placeOrder')); ?></button>

                <?php echo Form::close(); ?>

            </div>
              <!-- /.nav-tabs-custom -->
            <!-- /.col -->
        </div>
      <!-- /.row -->
 
    </div>
    <!-- /.container -->
</section>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>