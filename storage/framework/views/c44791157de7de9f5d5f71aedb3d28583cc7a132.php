
<?php $__env->startSection('content'); ?>
<section class="content-header box-header-main">
      <h1>
        <?php echo e(trans('labels.downloads')); ?>  
       
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.downloads')); ?></li>
      </ol>
</section>

 <section class="content">  
      
      <div class="row">
        

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($android); ?></h3>
               <p><?php echo e(trans('labels.android')); ?></p>
              </div>
              <div class="icon">
             <i class="fab fa-android"></i>
              </div>
           <a href="javascript:void(0)" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.androidDownloads')); ?>"><?php echo e(trans('labels.androidDownloads')); ?> <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3><?php echo e($ios); ?></h3>
               <p><?php echo e(trans('labels.ios')); ?></p>
              </div>
              <div class="icon">
             <i class="fab fa-apple"></i>

              </div>
            <a href="javascript:void(0)" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.iosDownloads')); ?>"><?php echo e(trans('labels.iosDownloads')); ?> <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
          </div>

          
      </div>

     

    </section>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>