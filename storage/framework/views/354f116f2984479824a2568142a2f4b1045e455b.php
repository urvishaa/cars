<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

<?php

  $admin = auth()->guard('admin')->user(); 



      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
    ?>

      <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>" class="logo">

        <span class="logo-lg"><!-- <b><?php echo e(trans('labels.admin')); ?></b> --> <img src="<?php echo $new.'/resources/assets/img/property_logo.png'; ?>"></span>
      </a>

      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(asset('').auth()->guard('admin')->user()->image); ?>" class="img-circle" alt="<?php echo e(auth()->guard('admin')->user()->first_name); ?> <?php echo e(auth()->guard('admin')->user()->last_name); ?> Image">
        </div>
        <div class="pull-left info">
          <p><?php echo e(auth()->guard('admin')->user()->first_name); ?> <?php echo e(auth()->guard('admin')->user()->last_name); ?></p>
        </div>
      </div>
      <ul class="sidebar-menu">
  <?php if($admin->issubadmin != 2): ?>; 

        <?php if(session('dashboard_view')==1 or auth()->guard('admin')->user()->adminType=='1'): ?>
        <li class="treeview <?php echo e(Request::is('admin/dashboard/this_month') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>">
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
            <i class="fa fa-user"></i> <span><?php echo e(trans('labels.showRoomAdmin')); ?></span>
          </a>
        </li>
        <?php endif; ?>


          <?php if(session('property_features')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/category') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/category')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.propertyCategory')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('property_type')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/property_type') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/property_type')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.property_type')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('ads')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/ads') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/ads')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.ads')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('topProperty')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/topProperty') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/topProperty/create')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.topProperty')); ?></span>
          </a>
        </li>
        <?php endif; ?>

    <?php endif; ?>  

        <?php if(session('property')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/property') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/property')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.property')); ?></span>
          </a>
        </li>
        <?php endif; ?>

      

        

        

        

        

       
                         
          
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>