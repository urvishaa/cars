  
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>


   <!--== Preloader Area Start ==-->
    <div class="preloader">
        <div class="preloader-spinner">
            <div class="loader-content">
                <img src="<?php echo e($new.'/resources/assetsite/img/preloader.gif'); ?>" alt="JSOFT">
            </div>
        </div>
    </div>
    <!--== Preloader Area End ==-->

    <!--== Header Area Start ==-->
    <header id="header-area" class="fixed-top">
        <!--== Header Top Start ==-->
        <div id="header-top" class="d-none d-xl-block">
            <div class="container">
                <div class="top-header">
                    <div class="lang-chng"> 
                        <ul>
                         <li class="menu-head">

                          <?php if(isset($session['language']) AND $session['language'] == 'en'): ?>
                          
                          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/british.png')); ?>"><?php echo e(trans('labels.En')); ?></a>
                            
                          <?php elseif(isset($session['language']) AND $session['language'] == 'ku'): ?>

                          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/kurdish.jpg')); ?>"><?php echo e(trans('labels.Ku')); ?></a>

                          <?php else: ?>
                          
                             <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/arabic.png')); ?>"><?php echo e(trans('labels.Ar')); ?></a>
                          <?php endif; ?>
                          
                          <ul class="dropdown-menu">
                            <li><a href="<?php echo e(URL::to('/changelang/en')); ?>"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/british.png')); ?>"><?php echo e(trans('labels.En')); ?></a></li>
                            <li><a href="<?php echo e(URL::to('/changelang/ar')); ?>"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/arabic.png')); ?>"><?php echo e(trans('labels.Ar')); ?></a></li>
                            <li><a href="<?php echo e(URL::to('/changelang/ku')); ?>"><img style="margin-right: 10px" height="20px;" width="30px" src="<?php echo e(URL::to('/resources/assets/img/kurdish.jpg')); ?>"><?php echo e(trans('labels.Ku')); ?></a></li>
                          </ul>
                        </li>
                        </ul>
                    </div>
                    <?php $contact = DB::table('get_touch')->first(); ?>

                    <div class="top-head">
                        <!--== Single HeaderTop Start ==-->
                        <div class="top-head-txt">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($contact->address ? $contact->address : ''); ?>

                        </div>
                        <!--== Single HeaderTop End ==-->

                        <!--== Single HeaderTop Start ==-->
                        <div class="top-head-txt">
                            <i class="fas fa-mobile-alt"></i> <?php echo e($contact->phone ? $contact->phone : ''); ?>

                        </div>
                        <!--== Single HeaderTop End ==-->


                        <!--== Social Icons End ==-->
                    </div>
                </div>
            </div>
        </div>
        <!--== Header Top End ==-->

        <!--== Header Bottom Start ==-->
        <div id="header-bottom">
            <div class="container">
                <div class="row">
                    <!--== Logo Start ==-->
                    <div class="col-lg-1">
                        <a href="<?php echo e(url('/')); ?>" class="logo">
                            <img src="<?php echo e($new.'/resources/assetsite/img/logo.png'); ?>" alt="JSOFT">
                        </a>
                    </div>
                    <!--== Logo End ==-->

                    <!--== Main Menu Start ==-->
                    <div class="col-lg-11 d-xl-block rspnsv-mnu">
                                <?php $carts=session()->get('cart'); ?>
                        <div class="cart">
                        	<?php if(!empty($carts)): ?> 
                            <!-- <?php if(count($carts) != 0): ?> -->
                                <a href="<?php echo e(route('showcart')); ?>">
 							<!-- <?php endif; ?>                                	 -->
                            <?php else: ?>
                                <a href="javascript:void(0)">
                            <?php endif; ?>
                                <i class="fab fa-opencart"></i>
                                <div class="cart-counter">
                                    <span><?php if(!empty($carts)) { echo count($carts); }  ?></span>
                                </div>
                            </a>
                        </div>
                        <nav class="mainmenu alignright">
                            <ul>
                                <li class="<?php echo e(Request::segment(1) == '' ? 'active' : null); ?>" ><a href="<?php echo e(url('/')); ?>"><?php echo e(trans('labels.home')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'sell-list' ? 'active' : null); ?>" ><a href="<?php echo e(url('/sell-list')); ?>"><?php echo e(trans('labels.sellBuyCar')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'companyadminlist' ? 'active' : null); ?>" ><a href="<?php echo e(url('/companyadminlist')); ?>"><?php echo e(trans('labels.rentalCompanies')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'showroomlist' ? 'active' : null); ?>" ><a href="<?php echo e(url('/showroomlist')); ?>"><?php echo e(trans('labels.carShowrooms')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'storeadminlist' ? 'active' : null); ?>" ><a href="<?php echo e(url('/storeadminlist')); ?>"><?php echo e(trans('labels.store')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'contactus' ? 'active' : null); ?>"><a href="<?php echo e(url('/contactus')); ?>"><?php echo e(trans('labels.contact')); ?></a></li>
                                <li class="<?php echo e(Request::segment(1) === 'login' ? 'active' : null); ?> <?php echo e(Request::segment(1) === 'register' ? 'active' : null); ?>" ><a href="javascript:void(0)"><?php echo e(trans('labels.myAcount')); ?> <i class="fas fa-chevron-down"></i></a>


                                <?php if(Session::get('userId')): ?>
                                    <ul>
                                        <li><a href="<?php echo e(url('/profile')); ?>"><?php echo e(trans('labels.Profile')); ?></a></li>
                                        <li><a href="<?php echo e(url('/myCar')); ?>"><?php echo e(trans('labels.myCar')); ?></a></li>
                                        <li><a href="<?php echo e(url('/order/list')); ?>"><?php echo e(trans('labels.myorderlist')); ?></a></li> 
                                        <li><a href="<?php echo e(url('/book/list')); ?>"><?php echo e(trans('labels.carBookList')); ?></a></li> 
                                        <li><a href="<?php echo e(url('/userlogout')); ?>"><?php echo e(trans('labels.Logout')); ?></a></li>
                                    </ul>
                                <?php else: ?>
                                    <ul>
                                        <li><a href="<?php echo e(url('/login')); ?>"><?php echo e(trans('labels.Login')); ?></a></li>
                                        <li><a href="<?php echo e(url('/register')); ?>"><?php echo e(trans('labels.registration')); ?></a></li>
                                    </ul>
                                <?php endif; ?>



                                  
                                </li>
                                
                            </ul>
                        </nav>                        
                    </div>
                    <!--== Main Menu End ==-->
                </div>
            </div>
        </div>
        <!--== Header Bottom End ==-->
    </header>
    <!--== Header Area End ==-->