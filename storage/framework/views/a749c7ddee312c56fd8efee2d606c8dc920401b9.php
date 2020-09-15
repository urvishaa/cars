<?php $__env->startSection('content'); ?>

<div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.orderDetails')); ?></h3>    
    <p><a href="<?php echo e(route('carBooking.list')); ?>" class="btn btn-success"><?php echo e(trans('labels.cancel')); ?></a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.orderDetails')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  



            <div class="row">
                <!-- Car List Content Start -->
                

                <!-- Sidebar Area Start -->
                <div class="col-lg-4">
                    <div class="sidebar-content-wrap m-t-50">
                        <!-- Single Sidebar Start -->
                            
                        <div class="sidebar-left">
                             <div class="estate_real">
                                <ul class="esta_ul">
                                    <li class="esta_li telp">
                                       
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="tel:012345-01234">
                                            <label><i class="fas fa-mobile-alt"></i></label><span><?php echo e($booking->phone ? $booking->phone : ''); ?>

                                            </span>
                                        </a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="mailto:abc@gmail.com"><label><i class="far fa-envelope"></i></label><span><?php echo e($booking->email ? $booking->email : ''); ?></span></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <!-- Single Sidebar End -->

                        <!-- Single Sidebar Start -->
                        
                        <div class="car-details-inr">
                          <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.name')); ?></h4> 
                             </div>
                             
                             <div class="car-det-inr right">
                                 <h4><?php echo e($booking->firstName ? $booking->firstName : ''); ?> <?php echo e($booking->lastName ? $booking->lastName : ''); ?> </h4>
                             </div>
                          </div>
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.fromDate')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4> <?php echo e($booking->dateFrom ? $booking->dateFrom : ''); ?> </h4>
                             </div>
                          </div>
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.toDate')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo e($booking->dateTo ? $booking->dateTo : ''); ?></h4>
                             </div>
                          </div> 
                          
                        </div>
                        <!-- Single Sidebar End -->
                    </div>
                </div>
                <!-- Sidebar Area End -->
            </div>
        </div>
    </section>
    
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>