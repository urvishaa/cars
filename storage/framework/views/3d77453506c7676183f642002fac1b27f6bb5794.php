<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $compareQuantity = 0;
  $data = $result['storeList'];
?>


<?php $__env->startSection('iamge'); ?>
  <?php if(@$data->image != ''): ?> 
    <?php if(file_exists(@$data->image)  AND @$data->image != ''): ?>
     <?php echo URL::to('/'.$data->image); ?>
    <?php else: ?> 
      <?php echo URL::to('/public/default-image.jpeg'); ?>
    <?php endif; ?> 
  <?php else: ?>
  <?php echo URL::to('/public/default-image.jpeg'); ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
  <?php if(@$data->first_name != ''): ?>
    <?php echo @$data->first_name.' '.@$data->last_name ; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
 
<?php $__env->stopSection(); ?>

 <?php $__env->startSection('description'); ?>
  <?php if(@$data->phone != ''): ?>
    <?php echo @$data->phone; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
  <?php if(@$data->email != ''): ?>
    <?php echo @$data->email; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?> 


<?php $__env->startSection('content'); ?>

<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d73ab59ab6f1000123c8260&product=inline-share-buttons' async='async'></script>

    <section class="section-padding product-detil">
        <div class="container">
            <div class="section-title  text-center sthowroom-detail">
                <div class="show-ret"> 
                    <h2><?php echo e(@$data->first_name); ?> <?php echo e(@$data->last_name); ?></h2>
                </div>
            </div>
            <div class="row">
                <!-- Car List Content Start -->
                <div class="col-lg-5">
                    <div class="detail-car car-deta-res">
                        <div class="img_real_home Car-rent">
                                <div class="img_real">
                                    <?php if(file_exists(@$data->image)  AND @$data->image != ''): ?>
                                        <img src="<?php echo e(URL::to('/'.$data->image)); ?>" id="chimg">
                                    <?php else: ?>
                                        <img src="<?php echo e($new.'/public/default-image.jpeg'); ?>">
                                    <?php endif; ?>
                                </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                                                                             
                                                <li class="esta_li">
                                                    <a href="javascript:void(0)"><?php echo e(@$data->first_name); ?> <?php echo e(@$data->last_name); ?> </a>
                                                    
                                                </li>
                                                                                             
                                                <?php if($data->phone != ''): ?>
                                                <li class="esta_li telp">
                                                    <a href="tel:<?php echo e(@$data->phone); ?>">
                                                       <label><i class="fa fa-mobile-alt"></i></label><span><?php echo e(@$data->phone); ?></span>
                                                    </a>
                                                    
                                                </li>
                                                <?php endif; ?>
                                                                                         
                                                <?php if($data->email != ''): ?>
                                                <li class="esta_li telp">
                                                     <a href="mailto:<?php echo e(@$data->email); ?>"><label><i class="far fa-envelope"></i></label><span><?php echo e(@$data->email); ?></span></a>
                                                </li> 
                                                <?php endif; ?>
                                                                      
                                            </ul>
                                            
                                        </div>
                                    </div>
                                     <div class="sharethis-inline-share-buttons" id="myDIV"></div>
                                </div>               
                               <!--  <div class="tag_price listing_price detail_rent agent">
                                  <a href="#"><i class="fas fa-comment-dots"></i><?php echo e(trans('labels.contact_agent')); ?></a>
                                </div> -->
                                
                      </div>
                      
                </div>
                <div class="col-lg-7">
                    <div class="derti-app">
                      <div class="details-content">
                       <h2><?php echo e(trans('labels.about')); ?></h2>
                        <?php if($data->description != ''): ?><p><?php echo e(@$data->description); ?></p><?php else: ?> <p><?php echo e(trans('labels.notAvailable')); ?></p> <?php endif; ?>
                        
                    </div>
                       
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <div class="detail-term">
    <div class="container">
    <div class="details gerti tert-ert">
        
    <?php if(count($result['products'])): ?>
        <div class="section-title  text-center">
            <h2><?php echo e(trans('labels.ProductList')); ?></h2>
            <span class="title-line"><i class="fa fa-car"></i></span>
        </div>
    <?php endif; ?>
            <?php if(count($result['products'])): ?>
                <div class="row">
                    <?php $__currentLoopData = $result['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6">
                            
                            <div class="rent-part">
                                    <div class="img_real_home prdct-dtil">
                                    <div class="img_real">
                                        <img src="<?php echo e($product->img_name ? url('/public/productImage/'.$product->img_name) : url('/public/default-image.jpeg' )); ?>">
                                    </div>
                                    <div class="real_content">
                                        
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            <?php if($product->name !=''): ?>                                                 
                                                <li class="esta_li">
                                                    <h3 class="prd-title"><?php echo e($product->name); ?></h3>
                                                </li>
                                            <?php endif; ?>
                                            <?php if($product->price !='' || $product->size != ''): ?> 
                                                <li class="esta_li">
                                                    <strong><?php echo e(trans('labels.price')); ?></strong> :<?php echo e($product->price); ?> , 
                                                    <strong><?php echo e(trans('labels.size')); ?></strong> :<?php echo e($product->size); ?>

                                                </li>
                                            <?php endif; ?>
                                            <?php if($product->color !=''  || $product->model != ''): ?> 
                                                <li class="esta_li">
                                                    <strong><?php echo e(trans('labels.color')); ?></strong> :<?php echo e($product->color); ?> , 
                                                    <strong><?php echo e(trans('labels.model')); ?></strong> :<?php echo e($product->model); ?>

                                                </li>
                                            <?php endif; ?>
                                            </ul>

                                        </div>
                                        </div>
                                        <div class="prod-disc">
                                            <?php if($product->description !=''): ?> 
                                                <p><strong><?php echo e(trans('labels.description')); ?></strong> : <?php echo e(substr($product->description,0,120)); ?> 
                                                    <?php if(strlen($product->description)>120): ?>
                                                    <?php @$content = $product->description; ?>
                                                    <p style="display: none" id="testa_<?php echo e(@$product->id); ?>"><?php echo substr( preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", @$content),120); ?></p>

                                                         <div class="button intro_button"><a href="javascript:void(0)" id="test_<?php echo e(@$product->id); ?>"><?php echo e(trans('labels.READ MORE')); ?>..</a></div>
                                                         <script>
                                                         $(document).ready(function(){
                                                            var ii = '<?php echo e(@$product->id); ?>';
                                                            $("a#test_"+ii).click(function(){
                                                            $("#testa_"+ii).toggle();
                                                            
                                                            });
                                                             
                                                          });
                                                        </script>
                                                    <?php else: ?>
                                                    <?php endif; ?>
                                                    </p>
                                            <?php endif; ?>
                                            <ul class="esta_ul">
                                                <?php if($product->specification !=''): ?> 
                                                    <li class="esta_li">
                                                        <strong><?php echo e(trans('labels.specification')); ?></strong> :<?php echo e($product->specification); ?>

                                                    </li>
                                                <?php endif; ?>

                                                <?php if($product->quantity !=''): ?> 
                                                <?php
                                                    $productlist = \App\PlaceOrder::where('Product_ID',$product->id)->sum('Quantity');
                                                    $compareQuantity = $product->quantity - $productlist;
                                                    ?>
                                                <?php endif; ?>
                                                <?php if($compareQuantity > 0): ?>
                                                    <li class="esta_li">
                                                        <strong><?php echo e(trans('labels.availableQuantity')); ?></strong> :<?php echo e($compareQuantity); ?>

                                                    </li>
                                                    <li class="esta_li">
                                                        <a href="<?php echo e(route('addnewcart',['id'=>$product->id])); ?>" class="btn adtcrt"><?php echo e(trans('labels.addToCart')); ?></a>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="esta_li addtocart"><div class="alert alert-danger">
                                                    <?php echo e(trans('labels.outOfStock')); ?>

                                                    </div></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                                                
                            <div class="col-xs-12 text-right">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="section-title  text-center">
                    <center><h5><?php echo e(trans('labels.noResultFound')); ?></h5></center>
                </div>        
            <?php endif; ?>   

            <div style="margin-top: 25px;"> <?php echo e(@$result['products']->links('vendor.pagination.default')); ?></div>
        </div>
    </div>
</div>
    </section>
    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>