<?php $__env->startSection('content'); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.carBookingList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
            <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>          
                        <th><?php echo e(trans('labels.car')); ?></th>                     
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.email')); ?></th>
                        <th><?php echo e(trans('labels.status')); ?></th>
                        <th><?php echo e(trans('labels.phone')); ?></th>
                        <th><?php echo e(trans('labels.fromDate')); ?></th>
                        <th><?php echo e(trans('labels.toDate')); ?></th>
                        <th><?php echo e(trans('labels.detail')); ?></th>
                    </tr>

                </thead>
                <tbody>
                    <?php if(count($bookings)): ?>
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <tr>
                                <td><a href="<?php echo e(route('carBooking.edit',['id'=>$booking->id])); ?>"><?php echo e($booking->car_name ? $booking->car_name : ''); ?></a></td>
                                <td><?php echo e($booking->firstName ? $booking->firstName : ''); ?> <?php echo e($booking->lastName ? $booking->lastName : ''); ?></td>
                                <td><?php echo e($booking->contact_agent_email ? $booking->contact_agent_email : ''); ?></td>
                                <td><?php echo e($booking->status ? $booking->status : ''); ?></td>
                                <td><?php echo e($booking->contact_agent_phone ? $booking->contact_agent_phone : ''); ?></td>
                                <td><?php echo e($booking->dateFrom ? $booking->dateFrom : ''); ?></td>
                                <td><?php echo e($booking->dateTo ? $booking->dateTo : ''); ?></td>
                                <td><a href="<?php echo e(route('carBooking.detail',['id'=>$booking->contact_agent_id])); ?>" class="btn btn-primary">Detail</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
            </table>
        <div style="margin-top: 15px;"><?php echo e($bookings->links('vendor.pagination.default')); ?></div> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>