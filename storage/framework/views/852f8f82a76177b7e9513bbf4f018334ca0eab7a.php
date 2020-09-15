<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

<div class="myordr-list section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2><?php echo e(trans('labels.myorderlist')); ?></h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info">
                        <p><?php echo e(Session::get('message')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div> 
        <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
               
                <div class="table-responsive prolisttabcls">
                    <table class="table" >
                        <thead>
                            <tr>                        
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.orderid')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.name')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.city')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.date')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.status')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.total')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.action')); ?></div></th>
                            </tr>
                        </thead>       
                            <tbody>
                            <?php if(count($result['orders']) > 0): ?>
                                <?php $__currentLoopData = $result['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <?php echo e($order->Order_ID ? $order->Order_ID : 0); ?>

                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo e($order->Name ? $order->Name : ''); ?>

                                        </td>
                                        <td class="align-middle text-center">
                                        <?php 
                                            $cityObj = $order->hasOneCity ? $order->hasOneCity : '';
                                            $cityName = $cityObj ? $cityObj->name : '';
                                        ?>
                                            <?php echo e($cityName); ?>


                                        </td>
                                        <td class="align-middle text-center">                        
                                            <?php echo e($order->datetime ? $order->datetime : 0); ?>


                                        </td>
                                        <td class="align-middle text-center">                        
                                            <?php echo e($order->Status ? $order->Status : ''); ?>


                                        </td>
                                        <td class="align-middle text-center">                        
                                            <?php echo e($order->TotalCount ? $order->TotalCount : ''); ?>


                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="<?php echo e(route('order.detail',['id'=>$order->Order_ID])); ?>" class="btn btn-primary"><?php echo e(trans('labels.detail')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <center><h5><?php echo e(trans('labels.noResultFound')); ?></h5></center>
                                    </td>
                                </tr>
                            <?php endif; ?>                   
                            </tbody>
                    </table>
                </div>               
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>