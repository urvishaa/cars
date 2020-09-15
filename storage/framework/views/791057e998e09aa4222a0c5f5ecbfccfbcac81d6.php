<aside class="main-sidebar">

    <section class="sidebar">

    <?php
      $admin = auth()->guard('admin')->user(); 
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
    ?>
      <?php if($admin['issubadmin'] == 0): ?> 
        <a href="<?php echo e(URL::to('admin/dashboard')); ?>" class="logo">
          <span class="logo-lg"> <img src="<?php echo $new.'/resources/assets/img/iraq_car.png'; ?>"></span>
        </a>
       <?php else: ?>
        <a href="<?php echo e(URL::to('admin/profile')); ?>" class="logo">
          <span class="logo-lg"> <img src="<?php echo $new.'/resources/assets/img/iraq_car.png'; ?>"></span>
        </a>
      <?php endif; ?>

      <div class="user-panel">
        <div class="pull-left image">
           <?php if(auth()->guard('admin')->user()->image != ""): ?>
          <img src="<?php echo e(asset('').auth()->guard('admin')->user()->image); ?>" class="img-circle">
           <?php else: ?> 
              <img class="profile-user-img img-responsive img-circle" src="<?php echo e(url('public/default-image.jpeg')); ?>" alt="profile picture">
          <?php endif; ?>
        </div>
        <div class="pull-left info">
          <p><?php echo e(auth()->guard('admin')->user()->first_name); ?> <?php echo e(auth()->guard('admin')->user()->last_name); ?></p>
        </div>
      </div>
      <ul class="sidebar-menu">
      <?php if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4 ): ?> 


        <?php if(session('dashboard_view')==1 or auth()->guard('admin')->user()->adminType=='1'): ?>
        <li class="treeview <?php echo e(Request::is('admin/dashboard') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/dashboard')); ?>">
            <i class="fas fa-tachometer-alt"></i> <span><?php echo e(trans('labels.header_dashboard')); ?></span>
          </a>
        </li>
        <?php endif; ?>


        <?php if(session('user')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/user') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/user')); ?>">
            <i class="fa fa-user"></i> <span><?php echo e(trans('labels.user')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('showRoomAdmin')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/showRoomAdmin') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/showRoomAdmin')); ?>">
           <i class="fa fa-user-plus" aria-hidden="true"></i><span><?php echo e(trans('labels.showRoomAdmin')); ?></span>
          </a>
        </li>
        <?php endif; ?>

      
          <?php if(session('StoreAdmin')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/StoreAdmin') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/StoreAdmin')); ?>">
           <i class="fa fa-users" aria-hidden="true"></i><span><?php echo e(trans('labels.StoreAdmin')); ?></span>
          </a>
        </li>
        <?php endif; ?>

       <?php if(session('companyAdmin')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/companyAdmin') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/companyAdmin')); ?>">
            <i class="fa fa-building" aria-hidden="true"></i> <span><?php echo e(trans('labels.rentalCompanies')); ?></span>
          </a>
        </li>
        <?php endif; ?>



     
        <?php if(session('orderList')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/orderlist') ? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.orderlist')); ?>">
           <i class="fas fa-sort-numeric-down"></i><span><?php echo e(trans('labels.orderList')); ?></span>
          </a>
        </li>
        <?php endif; ?>


        
        

        <?php if(session('carBrand')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/carBrand') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/carBrand')); ?>">
            <i class="fa fa-plus-square" aria-hidden="true"></i> <span><?php echo e(trans('labels.carBrand')); ?></span>
          </a>
        </li>
        <?php endif; ?>

          

        <?php if(session('fuelType')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/fueltype') ? 'active' : ''); ?>">
          <a href="<?php echo e(route('admin.fueltype')); ?>">
            <i class="fa fa-list" aria-hidden="true"></i> <span><?php echo e(trans('labels.fuelType')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('category')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/category') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/category')); ?>">
            <i class="fa fa-bus" aria-hidden="true"></i> <span><?php echo e(trans('labels.carCategory')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('car_year')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/year') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/year')); ?>">
           <i class="fas fa-calendar-alt"></i> <span><?php echo e(trans('labels.carYear')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('homeslide')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/homeslide') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/homeslide')); ?>">
            <i class="fa fa-bars" aria-hidden="true"></i> <span><?php echo e(trans('labels.homeslide')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('car_type')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/car_type') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/car_type')); ?>">
            <i class="fa fa-braille" aria-hidden="true"></i> <span><?php echo e(trans('labels.car_type')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('ads')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/ads') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/ads')); ?>">
            <i class="fab fa-buysellads"></i> <span><?php echo e(trans('labels.ads')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('notification')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/notification/create') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/notification/create')); ?>">
           <i class="fas fa-envelope"></i></i> <span><?php echo e(trans('labels.notification')); ?></span>
          </a>
        </li>
        <?php endif; ?>      

        <?php if(session('topCar')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/topCar') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/topCar/create')); ?>">
          <i class="fa fa-trophy" aria-hidden="true"></i><span><?php echo e(trans('labels.topCar')); ?></span>
          </a>
        </li>
        <?php endif; ?>


        <!-- <?php if(session('contactAgent')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/contactAgent') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/contactAgent')); ?>">
           <i class="fa fa-address-card" aria-hidden="true"></i> <span><?php echo e(trans('labels.contactAgent')); ?></span>
          </a>
        </li>
        <?php endif; ?> -->

        <?php if(session('contactAgent')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/city') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/city')); ?>">
           <i class="fa fa-map-marker" aria-hidden="true"></i> <span><?php echo e(trans('labels.addCity')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('downloads')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/downloads') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/downloads')); ?>">
          <i class="fa fa-download" aria-hidden="true"></i> <span><?php echo e(trans('labels.downloads')); ?></span>
          </a>
        </li>
        <?php endif; ?>


    <?php endif; ?>  

      <?php if($admin->issubadmin == 2 || $admin->issubadmin == 0 || $admin->issubadmin == 4): ?>
        <?php if(session('car')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/car') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/car')); ?>">
            <i class="fas fa-car"></i> <span><?php echo e(trans('labels.car')); ?></span>
          </a>
        </li>
        <?php endif; ?>
      <?php endif; ?>    


      <?php if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4): ?>
        <?php if(session('procategory')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/procategory') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/procategory')); ?>">
           <i class="fa fa-sitemap" aria-hidden="true"></i> <span><?php echo e(trans('labels.proCategory')); ?></span>
          </a>
        </li>
        <?php endif; ?>
      <?php endif; ?>

    <?php if($admin->issubadmin == 3 || $admin->issubadmin == 0): ?>
        <?php if(session('car_accessories')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/car_accessories') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/car_accessories')); ?>">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('labels.Product')); ?></span>
          </a>
        </li>
        <?php endif; ?>   
     <?php endif; ?>        
        
     <?php if($admin->issubadmin == 3 || $admin->issubadmin == 0): ?>
        <?php if(session('orderList')==1 or $admin->issubadmin == 3): ?> 
        <li class="treeview <?php echo e(Request::is('order/list') ? 'active' : ''); ?>">
          <a href="<?php echo e(route('storeOrder.list')); ?>">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('labels.orderList')); ?></span>
          </a>
        </li>
        <?php endif; ?>   
     <?php endif; ?>
    

        <?php if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4 ): ?> 

          <?php if(session('contactUs')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
            <li class="treeview <?php echo e(Request::is('admin/contact/create') ? 'active' : ''); ?>">
              <a href="<?php echo e(route('contact.create')); ?>">
                <i class="fas fa-id-card"></i> <span><?php echo e(trans('labels.contact')); ?></span>
              </a>
            </li>
          <?php endif; ?>



        <?php if(session('aboutus')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/about') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/about/create')); ?>">
            <i class="far fa-address-book"></i> <span><?php echo e(trans('labels.about')); ?></span>
          </a>
        </li>
        <?php endif; ?>
        <?php endif; ?>
      
       <?php if($admin->issubadmin == 4 || $admin->issubadmin == 0): ?>
      
            <li class="treeview <?php echo e(Request::is('booking/list') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('carBooking.list')); ?>"> 
              <i class="fa fa-tasks" aria-hidden="true"></i> <span><?php echo e(trans('labels.carBookingList')); ?></span>
            </a>
        <?php endif; ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>