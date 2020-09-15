
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
      <!-- <div class="row">
          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo e($usergroupCount); ?></h3>
               <p><?php echo e(trans('labels.user_group')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="<?php echo e(URL::to('admin/usergroupList')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.user_group')); ?>"><?php echo e(trans('labels.user_group')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-light-blue">
              <div class="inner">
                   <h3><?php echo e($owner); ?></h3>
               <p><?php echo e(trans('labels.owner')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
           <a href="<?php echo e(URL::to('admin/users')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllowner')); ?>"><?php echo e(trans('labels.viewAllowner')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-teal">
              <div class="inner">
                   <h3><?php echo e($agent); ?></h3>
               <p><?php echo e(trans('labels.agent')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/users')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllagent')); ?>"><?php echo e(trans('labels.viewAllagent')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-green">
              <div class="inner">
                   <h3><?php echo e($property); ?></h3>
               <p><?php echo e(trans('labels.property')); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/property')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllproperty')); ?>"><?php echo e(trans('labels.viewAllproperty')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
      </div -->
      <div class="row">
          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                <h3><?php echo e($usergroupCount); ?></h3>
               <p><?php echo e(trans('labels.user_group')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="<?php echo e(URL::to('admin/usergroupList')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.user_group')); ?>"><?php echo e(trans('labels.user_group')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($owner); ?></h3>
               <p><?php echo e(trans('labels.owner')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
           <a href="<?php echo e(URL::to('admin/users')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllowner')); ?>"><?php echo e(trans('labels.viewAllowner')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($agent); ?></h3>
               <p><?php echo e(trans('labels.agent')); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/users')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllagent')); ?>"><?php echo e(trans('labels.viewAllagent')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($property); ?></h3>
               <p><?php echo e(trans('labels.property')); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/property')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllproperty')); ?>"><?php echo e(trans('labels.viewAllproperty')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
      </div>
    </section>

<script src="<?php echo asset('resources/views/admin/dist/js/pages/dashboard2.js'); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>