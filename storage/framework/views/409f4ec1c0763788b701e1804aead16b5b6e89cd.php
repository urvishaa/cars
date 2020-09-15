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
                    <h2><?php echo e(trans('labels.myorderdetail')); ?></h2>
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
                <?php 
                        $name = $result['orders']->Name ? $result['orders']->Name : '';
                        $address = $result['orders']->address ? $result['orders']->address : '';
                        $cityObj = $result['orders']->hasOneCity ? $result['orders']->hasOneCity : '';
                        $cityName = $cityObj ? $cityObj->name : '';
                        $pin = $result['orders']->pincode ? $result['orders']->pincode : '';
                        $mobile = $result['orders']->Mobile ? $result['orders']->Mobile : '';
                        $placeOrderObj = $result['orders']->hasManyPlaceOrder ? $result['orders']->hasManyPlaceOrder : '';
                        
                    // if(count($result['orders']) > 0)
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


                <div class="table-responsive prolisttabcls">
                    <table class="table" >
                        <thead>
                            <tr>                        
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.image')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.Product')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.quantity')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.price')); ?></div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.total')); ?></div></th>
                            </tr>
                        </thead>       
                            <tbody>
                        <?php if(count($placeOrderObj) != 0): ?>
                            <?php $__currentLoopData = $placeOrderObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $placeOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $imgObj = $placeOrder->hasManyProductImg ? $placeOrder->hasManyProductImg : ''; 
                                
                                $imgName = '';
                                if(count($imgObj) != 0){
                                    $imgName = $imgObj[0]->img_name ? $imgObj[0]->img_name : '';
                                }
                            ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                        <img src="<?php echo e($imgName != '' ? url('/public/productImage/'.$imgName) : url('/public/default-image.jpeg' )); ?>" width="150px" height="150px">                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo e($placeOrder->Name ? $placeOrder->Name : ''); ?>

                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo e($placeOrder->Quantity ? $placeOrder->Quantity : 0); ?>

                                        </td>
                                        <td class="align-middle text-center">
                                            <?php echo e($placeOrder->Price ? $placeOrder->Price : 0); ?>

                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <?php if($placeOrder->Quantity != '' && $placeOrder->Price): ?>
                                                <?php echo e($placeOrder->Quantity*$placeOrder->Price); ?>

                                                <?php $grandTotal = $grandTotal + ($placeOrder->Quantity*$placeOrder->Price);?>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="3">
                                        <div class="">
                                            <ul class="list-unstyled mb-4">
                                              <li class="d-flex justify-content-around py-3 border-bottom"><strong class="text-muted"><?php echo e(trans('labels.totalPayable')); ?></strong>
                                                <h5 class="font-weight-bold" id="grand-total"><?php echo e($grandTotal); ?></h5>
                                              </li>
                                            </ul>
                                        </div>
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