<?php $__env->startSection('content'); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.orderList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
            <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>          
                        <th><?php echo e(trans('labels.orderid')); ?></th>                     
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.status')); ?></th>
                        <th><?php echo e(trans('labels.total')); ?></th>
                        <th><?php echo e(trans('labels.date')); ?></th>
                        <th><?php echo e(trans('labels.mobile')); ?></th>
                        <th><?php echo e(trans('labels.action')); ?></th>
                    </tr>

                </thead>
                <tbody>
                    <?php if(count($orders)): ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->Order_ID ? $order->Order_ID : ''); ?></td>
                                <td><?php echo e($order->Name ? $order->Name : ''); ?></td>
                                <td><?php echo e($order->Status ? $order->Status : ''); ?></td>
                                <td><?php echo e($order->TotalCount ? $order->TotalCount : ''); ?></td>
                                <td><?php echo e($order->datetime ? $order->datetime : ''); ?></td>
                                <td><?php echo e($order->Mobile ? $order->Mobile : ''); ?></td>
                                <td><a href="<?php echo e(route('storeOrder.detail',['id'=>$order->Order_ID])); ?>" class='btn btn-primary'>Detail</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
            </table>
        <div style="margin-top: 15px;"><?php echo e($orders->links('vendor.pagination.default')); ?></div> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>