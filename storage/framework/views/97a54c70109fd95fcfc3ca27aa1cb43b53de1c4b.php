
<?php $__env->startSection('content'); ?>
    <section class="content-header box-header-main">
      <h1>
        <?php echo e(trans('labels.title_dashboard')); ?>  
        <small><?php echo e(trans('labels.title_dashboard')); ?> </small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></li>
      </ol>
    </section>

    <section class="content">  
      
      <div class="row">
          

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($User); ?></h3>
               <p><?php echo e(trans('labels.user')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
           <a href="<?php echo e(URL::to('admin/users')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllusers')); ?>"><?php echo e(trans('labels.viewAllusers')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($ShowRoomAdmin); ?></h3>
               <p><?php echo e(trans('labels.showrooms')); ?></p>
              </div>
              <div class="icon">
              <i class="fa fa-address-card" ></i>

              </div>
            <a href="<?php echo e(URL::to('admin/showRoomAdmin')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllshowrooms')); ?>"><?php echo e(trans('labels.viewAllshowrooms')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($car); ?></h3>
               <p><?php echo e(trans('labels.car')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/car')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllcar')); ?>"><?php echo e(trans('labels.viewAllcar')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($Ads); ?></h3>
               <p><?php echo e(trans('labels.ads')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-newspaper" aria-hidden="true"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/ads')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllads')); ?>"><?php echo e(trans('labels.viewAllads')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

      </div>

      <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo e(trans('labels.latestUsers')); ?></h3>

                  <div class="box-tools pull-right">
                 
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php $__currentLoopData = $userdetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li>
                          <?php if(!empty($userdata->image) && $userdata->image != ''): ?> 
                            <img src="<?php echo e(url('/public/profileImage/'.$userdata->image)); ?>"  height="30px" width="30px" alt="User Image">   
                          <?php else: ?>
                              <img src="<?php echo e(url('public/default-image.jpeg')); ?>"  height="50px" width="50px" alt="User Image">                    
                          <?php endif; ?>     
                        <a class="users-list-name" href="<?php echo e(url('/admin/users/'.$userdata->id.'/edit')); ?>"><?php echo e($userdata->name); ?></a>
                        <span class="users-list-date"><?php echo e($userdata->email); ?></span>
                      </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="<?php echo e(url('/admin/users')); ?>" class="uppercase"><?php echo e(trans('labels.viewAllusers')); ?></a>
                </div>
                <!-- /.box-footer -->
      </div>




      <div class="row rec_box">
        <div class="col-md-6">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo e(trans('labels.recentlyAddedCars')); ?></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"></button>
            </div>
          </div>
          <div class="box-body">
            <ul class="products-list product-list-in-box">

              <?php $__currentLoopData = $cardetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cardata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <li class="item">
                <div class="product-img">
                  <?php if(!empty($cardata->image) && $cardata->image != ''): ?> 
                    <img src="<?php echo e(url('/public/carImage/'.$cardata->image)); ?>" alt="Product Image">   
                  <?php else: ?>
                      <img src="<?php echo e(url('public/default-image.jpeg')); ?>" alt="Product Image">                    
                  <?php endif; ?>    
                  
                </div>
                <div class="product-info">
                  <a href="<?php echo e(url('/admin/car/'.$cardata->id.'/edit')); ?>" class="product-title"><?php echo e($cardata->car_name); ?>

                    <span class="label label-warning pull-right"><?php echo e($cardata->sale_price); ?></span></a>
                    <span class="product-description">
                        <?php echo e($cardata->description); ?>

                    </span>
                </div>
              </li>   
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>           
             
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="<?php echo e(url('/admin/car')); ?>" class="uppercase"><?php echo e(trans('labels.viewAllcar')); ?></a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo e(trans('labels.ads')); ?></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"></button>
            </div>
          </div>
          <div class="box-body">
            <ul class="products-list product-list-in-box">

              <?php $__currentLoopData = $AdsDash; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Ads): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             
              <li class="item">
                <div class="product-img">
                  <?php if(!empty($Ads->image) && $Ads->image != ''): ?> 
                    <img src="<?php echo e(url('/public/dsaImage/'.$Ads->image)); ?>" alt="Product Image">   
                  <?php else: ?>
                      <img src="<?php echo e(url('public/default-image.jpeg')); ?>" alt="Product Image">                    
                  <?php endif; ?>    
                  
                </div>
                <div class="product-info">
                  <a href="<?php echo e(url('/admin/ads/'.$Ads->id.'/edit')); ?>" class="product-title"><?php echo e($Ads->name); ?>

                    
                    <span class="product-description">
                        <?php echo e($Ads->description); ?>

                      </span>
                </div>
              </li>   
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>           
             
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="<?php echo e(url('/admin/ads')); ?>" class="uppercase"><?php echo e(trans('labels.viewAllads')); ?></a>
          </div>
        </div>
      </div>


    </section>

<script src="<?php echo asset('resources/views/admin/dist/js/pages/dashboard2.js'); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>