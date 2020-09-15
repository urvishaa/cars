<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
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
          <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo e(1); ?></h3>
  			       <p><?php echo e(trans('labels.Category')); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo e(URL::to('admin/categories')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewAllCategory')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-light-blue">
              <div class="inner">
                   <h3><?php echo e(2); ?></h3>
               <p><?php echo e(trans('labels.Category')); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
           <a href="<?php echo e(URL::to('admin/categories')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewAllCategory')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-teal">
              <div class="inner">
                   <h3><?php echo e(33); ?></h3>
               <p><?php echo e(trans('labels.Category')); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            <a href="<?php echo e(URL::to('admin/categories')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewAllCategory')); ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
    
        </div>
    </section>

  </div>
<script src="<?php echo asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<script src="<?php echo asset('resources/views/admin/dist/js/pages/dashboard2.js'); ?>"></script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>