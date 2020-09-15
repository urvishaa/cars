<?php $__env->startSection('content'); ?>
    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.orderDetails')); ?></h3>    
    <p><a href="<?php echo e(route('storeOrder.list')); ?>" class="btn btn-success"><?php echo e(trans('labels.cancel')); ?></a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.orderDetails')); ?>

        </div>
       
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>                        
                            <th><?php echo e(trans('labels.Product')); ?></th>                     
                            <th><?php echo e(trans('labels.quantity')); ?></th>
                            <th><?php echo e(trans('labels.price')); ?></th>
                            <th><?php echo e(trans('labels.total')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $grandTotal =0;
                       ?>
                        <?php if(count($orders) > 0): ?>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $productName = $order->name ? $order->name : '';
                                    $quantity = $order ? $order->Quantity : 0;
                                    $price = $order ? $order->Price : 0;
                                    $total = $quantity * $price;
                                    $grandTotal = $grandTotal + $total;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo e($productName); ?>

                                    </td>
                                    <td>
                                        <?php echo e($quantity); ?>                                
                                    </td>
                                    <td>
                                        <?php echo e($price); ?>                                
                                    </td>
                                    <td>
                                        <?php echo e($total); ?>                                    
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                            <tr>
                                <td colspan="2">
                                <?php echo e(trans('labels.grandTotal')); ?> :<?php echo e($grandTotal); ?>

                                </td>
                                <td colspan="2">
                                    <?php echo e(trans('labels.status')); ?> :
                                        <select required autofocus id="status" name="status" class="field" onchange="changeStatus('<?php echo e(route("admin.ordereditstatus",['id'=>$order->Order_ID])); ?>',this)">
                                            <option value="">--<?php echo e(trans('labels.orderStatus')); ?>--</option>
                                                <option value="Pending" <?php if($order->Status =='Pending'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.pending')); ?></option>                                                                              
                                                <option value="Delivered" <?php if($order->Status =='Delivered'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.delivered')); ?></option>                                                                              
                                                <option value="Shipping" <?php if($order->Status =='Shipping'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.shipping')); ?></option>                                                                              
                                        </select>            
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>       
                </table>
            </div>
            <?php if(count($orders)): ?>
                <div class="car-details-inr">
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                            <h4><?php echo e(trans('labels.name')); ?> : <?php echo e($orders[0]->Name ? $orders[0]->Name : ''); ?></h4> 
                        </div>
                    </div>
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4><?php echo e(trans('labels.mobile')); ?> : <?php echo e($orders[0]->Mobile ? $orders[0]->Mobile : ''); ?></h4> 
                        </div>
                    </div>
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4><?php echo e(trans('labels.address')); ?> : <?php echo e($orders[0]->address ? $orders[0]->address : ''); ?></h4> 
                        </div>
                    </div> 
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4><?php echo e(trans('labels.city')); ?> : <?php echo e($orders[0]->city_name ? $orders[0]->city_name : ''); ?> <?php echo e($orders[0]->pincode ? '-'. $orders[0]->pincode : ''); ?>.</h4> 
                        </div>
                    </div> 
                </div>
            <?php endif; ?>
        </div>
    </div>
<script type="text/javascript">

    
    function changeStatus(urls,obj){
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : obj.value},
            success: function(res){
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>