<?php $__env->startSection('content'); ?>
    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.orderDetails')); ?></h3>    
    <p><a href="<?php echo e(route('admin.orderlist')); ?>" class="btn btn-success"><?php echo e(trans('labels.cancel')); ?></a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.orderDetails')); ?>

        </div>
        <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
        <?php 
            $name = $result['orders']->Name ? $result['orders']->Name : '';
            $address = $result['orders']->address ? $result['orders']->address : '';
            $cityObj = $result['orders']->hasOneCity ? $result['orders']->hasOneCity : '';
            $cityName = $cityObj ? $cityObj->name : '';
            $pin = $result['orders']->pincode ? ' - '.$result['orders']->pincode : '';
            $mobile = $result['orders']->Mobile ? $result['orders']->Mobile : '';
        ?>   
        <div class="col-lg-4 col-md-6">
            <div class="rent-part">
                <div class="real_content">
                    <div class="estate_real">
                        <ul class="esta_ul">
                            <li class="esta_li">
                                <h3 class="prd-title"><?php echo e($name); ?></h3>
                            </li>
                            <li class="esta_li">
                                <strong><?php echo e(trans('labels.address')); ?></strong> :<?php echo e($address); ?> , 
                                <br><?php echo e($cityName); ?> - <?php echo e($pin); ?>.
                            </li>
                            <li class="esta_li">
                                <strong><?php echo e(trans('labels.phone')); ?></strong> :<?php echo e($mobile); ?> .
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>                        
                            <th><?php echo e(trans('labels.image')); ?></th>                     
                            <th><?php echo e(trans('labels.Product')); ?></th>                     
                            <th><?php echo e(trans('labels.quantity')); ?></th>
                            <th><?php echo e(trans('labels.price')); ?></th>
                            <th><?php echo e(trans('labels.total')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $placeOrderObj = $result['orders']->hasManyPlaceOrder ? $result['orders']->hasManyPlaceOrder : '';
                            $grandTotal =0;
                            ?>
                        <?php if(count($placeOrderObj) > 0): ?>
                            <?php $__currentLoopData = $placeOrderObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$placeOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php  ?>
                                <?php
                                    $productName = $placeOrder ? $placeOrder->Name : '';
                                    $quantity = $placeOrder ? $placeOrder->Quantity : 0;
                                    $price = $placeOrder ? $placeOrder->Price : 0;
                                    $total = $quantity * $price;
                                    $grandTotal = $grandTotal + $total;
                                    
                                    ?>
                                <tr>
                                    <td>
                                        <?php 
                                            $productImg = $placeOrder->hasManyProductImg ? $placeOrder->hasManyProductImg : '';
                                            if(count($productImg)){
                                                $img = '/public/productImage/'.$productImg[0]->img_name;
                                            }
                                            else{
                                                $img = '/public/default-image.jpeg';
                                            } 
                                        ?>

                                        <img src="<?php echo e(url($img)); ?>" width="100px" height="100px" data-toggle="modal" data-target="#contactagent<?php echo e($key); ?>">
                                    </td>
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
                                        <select required autofocus id="status" name="status" class="field" onchange="changeStatus('<?php echo e(route("admin.ordereditstatus",['id'=>$result['orders']->Order_ID])); ?>',this)">
                                            <option value="">--<?php echo e(trans('labels.orderStatus')); ?>--</option>
                                                <option value="Pending" <?php if($result['orders']->Status =='Pending'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.pending')); ?></option>                                                                              
                                                <option value="Shipping" <?php if($result['orders']->Status =='Shipping'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.shipping')); ?></option>                                                                              
                                                <option value="Deliver It" <?php if($result['orders']->Status =='Deliver It'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.deliverIt')); ?></option>                                                                              
                                                <option value="Rejected" <?php if($result['orders']->Status =='Rejected'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.rejected')); ?></option>                                                                              
                                        </select>            
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
    <?php if(count($placeOrderObj) > 0): ?>
        <?php $__currentLoopData = $placeOrderObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$placeOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="contactagent<?php echo e($key); ?>" class="modal fade" role="dialog">
            
                <div class="modal-dialog">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 style="color: #0d83a9;"><?php echo e(trans('labels.images')); ?></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <?php 
                                $productImg = $placeOrder->hasManyProductImg ? $placeOrder->hasManyProductImg : '';
                                if(count($productImg)){
                                    foreach($productImg as $productImage){
                                        $img = '/public/productImage/'.$productImage->img_name;
                            ?>
                                        <div class="col-md-8">
                                        <img src="<?php echo e(url($img)); ?>" width="100px" height="100px" >
                                        </div>
                            <?php
                                    }
                                } 
                                else{
                                    echo "<center><h2>No Image Found</h2></center>";
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<script type="text/javascript">

    
    function changeStatus(urls,obj){
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : obj.value},
            success: function(res){
                // alert(res);
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>