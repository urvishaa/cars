<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>





<div class="cart_page">
    <div class="container">
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

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
                <?php if(Session::has('cart')): ?>
                    <?php $allCarts=Session()->get('cart'); ?>
                    <?php if(count($allCarts) > 0): ?>
                        <thead>
                            <tr>
                              <th scope="col" class="border-0 bg-light">
                                <div class="p-2 px-3 text-uppercase"><?php echo e(trans('labels.Product')); ?></div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase"><?php echo e(trans('labels.price')); ?></div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase"><?php echo e(trans('labels.quantity')); ?></div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase"><?php echo e(trans('labels.total')); ?></div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase"><?php echo e(trans('labels.remove')); ?></div>
                              </th>
                            </tr>
                        </thead>
                        <?php $__currentLoopData = $allCarts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tbody>
                            <tr>
                              <th scope="row" class="border-0">
                                <div class="p-2" style="display: flex;">
                                  <img src="<?php echo e($cart['img_name'] ? url('/public/productImage/'.$cart['img_name']) : url('/public/default-image.jpeg' )); ?>" alt="" width="100" class="img-fluid rounded shadow-sm">
                                  <div class="ml-3 d-inline-block align-middle" style=" min-width: 200px;">
                                    <h5 class="mb-0">
                                        <a href="#" class="text-dark d-inline-block align-middle">
                                            <?php if($cart['name'] !=''): ?>                                                 
                                                <?php echo e($cart['name']); ?>

                                            <?php endif; ?>
                                        </a>
                                    </h5>
                                  </div>
                                </div>
                              </th>
                              <td class="border-0 align-middle">
                                <strong>
                                    <?php if($cart['price'] !=''): ?> 
                                        <?php echo e($cart['price']); ?>  
                                    <?php endif; ?>
                                </strong>
                            </td>
                              <td class="border-0 align-middle">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                        <button onclick="minusQuantitys('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" class="btn btn-default btn-number" style="box-shadow: none; cursor: pointer;"><i class="fas fa-minus"></i></button>
                                        </span>
                                        <input type='number' class="form-control input-number" value="<?php echo e($cart['quantity']); ?>" min="1"  id="quantity<?php echo e($index); ?>" onclick="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onkeyup="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onpaste="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onchange="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" style="width: auto; max-width: 60px; text-align: center; box-shadow: none;">   
                                        <span class="input-group-btn">
                                        <button onclick="addQuantitys('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" class="btn btn-default btn-number" style="box-shadow: none; cursor: pointer;"><i class="fas fa-plus"></i></button>
                                        </span>
                                    </div>
                              </td>
                              <td class="border-0 align-middle">
                                    <p id="price<?php echo e($index); ?>"><?php echo e($cart['quantity'] * $cart['price']); ?></p>
                              </td>
                              <td class="border-0 align-middle"><a href="<?php echo e(route('deletecart',['id'=>$index])); ?>" class="btn btn-outline-danger"><i class="fa fa-trash"></i> <?php echo e(trans('labels.remove')); ?></a></td>
                            </tr>
                            <?php 
                                $cartTotal = $cart['quantity'] * $cart['price'];
                                $grandTotal = $grandTotal+ $cartTotal;
                             ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td colspan="3">
                                <div class="cart-car-img">
                                    <img src="<?php echo e(URL::to('/resources/assets/img/car-image.png')); ?>">
                                </div>
                            </td>
                            <td colspan="2" >
                                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold"><?php echo e(trans('labels.orderSummary')); ?> </div>
                                  <div class="p-4">
                                    <ul class="list-unstyled mb-4">
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted"><?php echo e(trans('labels.totalPayable')); ?></strong>
                                        <h5 class="font-weight-bold" id="grand-total"><?php echo e($grandTotal); ?></h5>
                                      </li>
                                    </ul><a href="<?php echo e(route('buynow.form')); ?>" class="btn btn-myclr rounded-pill py-2 btn-block"><?php echo e(trans('labels.procceedToCheckout')); ?></a>
                                  </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                <?php endif; ?>
            </table>
          </div>
          <!-- End -->
        </div>
      </div>
    </div>
</div>
















    <!-- <div class="panel panel-default">       
        <div class="panel-body table-responsive progrmslistcls">  
           
            <div class="prolisttabcls">
                <table class="table table-bordered" >
                    <?php if(Session::has('cart')): ?>
                        <?php $allCarts=Session()->get('cart'); ?>
                        <?php if(count($allCarts) > 0): ?>
                    <thead>
                        <tr>                        
                            <th><?php echo e(trans('labels.image')); ?></th>
                            <th><?php echo e(trans('labels.name')); ?></th>
                            <th><?php echo e(trans('labels.price')); ?></th>
                            <th><?php echo e(trans('labels.quantity')); ?></th>
                            <th><?php echo e(trans('labels.total')); ?></th>
                            <th><?php echo e(trans('labels.action')); ?></th>
                        </tr>
                    </thead>       
                            <?php $__currentLoopData = $allCarts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tbody>
                                    <tr>
                                        
                                        <td>
                                            <div class="img_real">
                                                <img src="<?php echo e($cart['img_name'] ? url('/public/productImage/'.$cart['img_name']) : url('/public/default-image.jpeg' )); ?>" width="150px;">
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($cart['name'] !=''): ?>                                                 
                                                    <?php echo e($cart['name']); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($cart['price'] !=''): ?> 
                                                <?php echo e($cart['price']); ?>  
                                            <?php endif; ?>
                                        </td>
                                        <td>                        
                                            <?php if($cart['quantity'] !=''): ?> 
                                                <button onclick="minusQuantitys('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')">-</button>
                                                <input type='number' value="<?php echo e($cart['quantity']); ?>" min="1"  id="quantity<?php echo e($index); ?>" onclick="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onkeyup="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onpaste="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')" onchange="addQuantity('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')">   
                                                <button onclick="addQuantitys('<?php echo e(route('updatecart',['id'=>$index])); ?>','<?php echo e($index); ?>')">+</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($cart['quantity'] !='' && $cart['price']): ?> 
                                                <p id="price<?php echo e($index); ?>"><?php echo e($cart['quantity'] * $cart['price']); ?></p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('deletecart',['id'=>$index])); ?>" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                    <?php 
                                        $cartTotal = $cart['quantity'] * $cart['price'];
                                        $grandTotal = $grandTotal+ $cartTotal;
                                     ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td colspan="4">
                                    <a href="<?php echo e(route('buynow.form',['total'=>$grandTotal])); ?>"><img src="<?php echo e(asset('public/aboutImage/addToCartButton.jpeg')); ?>" alt=""></a>
                                </td>
                                
                                <td colspan="2">
                                        Total Payable:<p id="grand-total"><?php echo e($grandTotal); ?></p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    <?php endif; ?>                   
                </table>
            </div>               
        </div>
    </div> -->
<script type="text/javascript">

    
    function addQuantity(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        if(quantity <= 0){
            quantity = 1;
        }
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#price"+id).text(res.total);
                jQuery("#grand-total").text(res.grandTotal);
            }
        });
    }
    function addQuantitys(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        if(quantity <= 0){
            quantity = 1;
        }
        quantity++;
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#grand-total").text(res.grandTotal);
                jQuery("#price"+id).text(res.total);
            }
        });
    }
    function minusQuantitys(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        quantity--;
        if(quantity <= 0){
            quantity = 1;
        }
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#grand-total").text(res.grandTotal);
                jQuery("#price"+id).text(res.total);
            }
        });
    }  


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>