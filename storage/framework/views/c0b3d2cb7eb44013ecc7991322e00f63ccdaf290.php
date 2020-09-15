<header id="header-area" class="header-area bg-primary">
    <div class="container">
        <div class="header-mini">
            <div class="headminione">
                <div class="headinone">
                    <ul class="navbar-nav wlcm_msg ">
                        <?php if(Auth::guard('customer')->check()): ?>
                            <li class="nav-item">
                                <div class="nav-link">
                                    <span class="p-pic"><img src="<?php echo e(asset('').auth()->guard('customer')->user()->customers_picture); ?>" alt="image"></span><?php echo app('translator')->getFromJson('website.Welcome'); ?>&nbsp;<?php echo e(auth()->guard('customer')->user()->customers_firstname); ?>&nbsp;<?php echo e(auth()->guard('customer')->user()->customers_lastname); ?>!
                                </div>
                            </li>
                   <!--          <li class="nav-item"> <a href="<?php echo e(URL::to('/profile')); ?>" class="nav-link -before"><?php echo app('translator')->getFromJson('website.Profile'); ?></a> </li>
                            <li class="nav-item"> <a href="<?php echo e(URL::to('/wishlist')); ?>" class="nav-link -before"><?php echo app('translator')->getFromJson('website.Wishlist'); ?></a> </li>
                            <li class="nav-item"> <a href="<?php echo e(URL::to('/orders')); ?>" class="nav-link -before"><?php echo app('translator')->getFromJson('website.Orders'); ?></a> </li>
                            
                            <li class="nav-item"> <a href="<?php echo e(URL::to('/shipping-address')); ?>" class="nav-link -before"><?php echo app('translator')->getFromJson('website.Shipping Address'); ?></a> </li> -->
                            <li class="nav-item"> <a href="<?php echo e(URL::to('/logout')); ?>" class="nav-link -before"><?php echo app('translator')->getFromJson('website.Logout'); ?></a> </li>
                        <?php else: ?>
                           <!--  <li class="nav-item"><div class="nav-link"><?php echo app('translator')->getFromJson('website.Welcome Guest!'); ?></div></li> -->
                            <li class="nav-item"> <a href="<?php echo e(URL::to('/login')); ?>" class="nav-link -before"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;<?php echo app('translator')->getFromJson('website.Login/Register'); ?></a> </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="headintwo">
                    <ul class="top-right-list">                           
                        <li class="cart-header dropdown head-cart-content">
                        </li>
                    </ul>
                </div>
                    
            </div>

            <div class="headminitwo">
                <div class="headoutone">
                    <img src="<?php echo e(URL::to('/public/images/logo.png')); ?>">
                </div>

                <div class="headouttwo">                      
                    <nav class="navbar navbar-expand-lg navbar-light">                      
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                <a class="nav-link" href="<?php echo e(URL::to('/')); ?>">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(URL::to('/news/')); ?>">Gallery</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(URL::to('/shop')); ?>">Shop</a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(URL::to('/contact-us')); ?>">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>    
        </div>  
    </div>   


    <div class="header-maxi">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-lg-3 col-xl-2 header-navi">
                    <nav id="navbar_1" class="navbar navbar-expand-lg navbar-dark navbar-1 p-0 d-none d-lg-block">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_collapse_1" aria-controls="navbar_collapse_1" aria-expanded="false" aria-label="Toggle navigation"> <?php echo app('translator')->getFromJson('website.Menu'); ?> </button>
                    
                    </nav>
                    
                    <nav id="navbar_2" class="navbar navbar-expand-lg navbar-dark navbar-2 p-0 d-block d-lg-none">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_collapse_2" aria-controls="navbar_collapse_2" aria-expanded="false" aria-label="Toggle navigation"> <?php echo app('translator')->getFromJson('website.Menu'); ?> </button>
                        
                        <div class="collapse navbar-collapse" id="navbar_collapse_2">
                        
                          <ul class="navbar-nav"> 
                            <li class="nav-item first"><a href="<?php echo e(URL::to('/')); ?>" class="nav-link"><i class="fa fa-home"></i></a></li>   
                            <li class="nav-item dropdown open">
                                <div class="nav-link dropdown-toggle"><?php echo app('translator')->getFromJson('website.homePages'); ?></div>
                                <ul class="dropdown-menu" >
                                    <li> <a class="dropdown-item" href="<?php echo e(URL::to('/setStyle?style=one')); ?>" ><?php echo app('translator')->getFromJson('website.homePage1'); ?></a> </li>
                                    <li> <a class="dropdown-item" href="<?php echo e(URL::to('/setStyle?style=two')); ?>"><?php echo app('translator')->getFromJson('website.homePage2'); ?></a> </li>
                                    <li> <a class="dropdown-item" href="<?php echo e(URL::to('/setStyle?style=three')); ?>"><?php echo app('translator')->getFromJson('website.homePage3'); ?></a> </li>
                                </ul>
                            </li>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo e(URL::to('/shop')); ?>"><?php echo app('translator')->getFromJson('website.Shop'); ?></a> </li>
                            <li class="nav-item dropdown mega-dropdown open">
                              <div class="nav-link dropdown-toggle">
                                <?php echo app('translator')->getFromJson('website.collection'); ?>
                                <span class="badge badge-secondary"><?php echo app('translator')->getFromJson('website.hot'); ?></span>
                              </div>
                    
                              <ul class="dropdown-menu mega-dropdown-menu row" >
                                <li class="col-sm-3">
                                  <ul>
                                    <li class="dropdown-header underline"><?php echo app('translator')->getFromJson('website.new in Stores'); ?></li>
                                    
                                    <?php if($result['commonContent']['recentProducts']['success']==1): ?>
                                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                                          <div class="carousel-inner">
                                          
                                        <?php $__currentLoopData = $result['commonContent']['recentProducts']['product_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="carousel-item <?php if($key==0): ?> active <?php endif; ?>">
                                                <span products_id = '<?php echo e($products->products_id); ?>' class="fa <?php if($products->isLiked==1): ?> fa-heart <?php else: ?> fa-heart-o <?php endif; ?> is_liked"><span class="badge badge-secondary">2</span></span>
                                                <a href="<?php echo e(URL::to('/product-detail/'.$products->products_slug)); ?>" class="fa fa-eye"><img src="<?php echo e(asset('').$products->products_image); ?>" alt="<?php echo e($products->products_name); ?>"></a>
                                                <small><?php $__currentLoopData = $products->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($category->categories_name); ?><?php if(++$key === count($products->categories)): ?> <?php else: ?>, <?php endif; ?>                                                    
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></small>
                                                <h5><?php echo e($products->products_name); ?></h5>
                                                
                                                <div class="block">
                                                    <span class="price">
                                                        <?php if(!empty($products->discount_price)): ?>
                                                            <span class="line-through"><?php echo e($web_setting[19]->value); ?><?php echo e($products->discount_price+0); ?></span>
                                                            <?php echo e($web_setting[19]->value); ?><?php echo e($products->products_price+0); ?>

                                                        <?php else: ?>
                                                            <?php echo e($web_setting[19]->value); ?><?php echo e($products->products_price+0); ?>

                                                        <?php endif; ?>
                                                    </span>
                                                    
                                                    <div class="buttons">
                                                        <button  class="btn btn-secondary cart" products_id="<?php echo e($products->products_id); ?>"><?php echo app('translator')->getFromJson('website.Add to Cart'); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Item -->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                          </div>
                                          <!-- End Carousel Inner -->
                                        </div>
                                    <?php endif; ?>
                                    
                                  </ul>
                                </li>
                                <li class="col-sm-9 pl-4 row">
                                <?php $__currentLoopData = $result['commonContent']['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                      <ul class="col-sm-4">
                                            
                                        <li class="dropdown-header"><a href="<?php echo e(URL::to('/shop')); ?>?category=<?php echo e($categories_data->slug); ?>"><?php echo e($categories_data->name); ?></a></li>
                                          <?php if(count($categories_data->sub_categories)>0): ?>
                                             <?php $__currentLoopData = $categories_data->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_categories_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><a href="<?php echo e(URL::to('/shop')); ?>?category=<?php echo e($sub_categories_data->sub_slug); ?>"><?php echo e($sub_categories_data->sub_name); ?></a></li>                     
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                          <?php endif; ?> 
                                      
                                      </ul>        
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                </li>
                                
                                
                              </ul>
                    
                            </li>
                            
                            <li class="nav-item dropdown open">
                                <div class="nav-link dropdown-toggle"><?php echo app('translator')->getFromJson('website.News'); ?></div>
                    
                                <ul class="dropdown-menu" > 
                                <?php $__currentLoopData = $result['commonContent']['newsCategories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                 
                                    <li>                
                                        <a class="dropdown-item" href="<?php echo e(URL::to('/news?category='.$categories->slug)); ?>"><?php echo e($categories->name); ?></a>                 
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>    
                            </li>
                            <li class="nav-item dropdown open">
                                <div class="nav-link dropdown-toggle"><?php echo app('translator')->getFromJson('website.infoPages'); ?></div>
                            
                                <ul class="dropdown-menu">
                                    <?php if(count($result['commonContent']['pages'])): ?>
                                    <?php $__currentLoopData = $result['commonContent']['pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li> <a href="<?php echo e(URL::to('/page?name='.$page->slug)); ?>" class="dropdown-item"><?php echo e($page->name); ?></a> </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>  
                                </ul>
                            </li>
                            
                            <li class="nav-item"> <a class="nav-link" href="<?php echo e(URL::to('/contact-us')); ?>"><?php echo app('translator')->getFromJson('website.Contact Us'); ?></a> </li>
                            <li class="nav-item last"><a class="nav-link"><span><?php echo app('translator')->getFromJson('website.hotline'); ?></span>(<?php echo e($result['commonContent']['setting'][11]->value); ?>)</a></li>
                          </ul>
                        </div>
                    </nav>
                </div>                

                <div class="col-12 col-sm-12 col-lg-3 col-xl-4 cartcls">

                </div>
            </div>
        </div>
    </div>

</header>




