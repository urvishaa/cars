<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

<?php
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
    ?>

      <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- <span class="logo-mini" style="font-size:12px"><b><?php echo e(trans('labels.admin')); ?></b></span> -->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><!-- <b><?php echo e(trans('labels.admin')); ?></b> --> <img src="<?php echo $new.'/resources/assets/img/propertry-admin.png'; ?>"></span>
      </a>
      
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(asset('').auth()->guard('admin')->user()->image); ?>" class="img-circle" alt="<?php echo e(auth()->guard('admin')->user()->first_name); ?> <?php echo e(auth()->guard('admin')->user()->last_name); ?> Image">
        </div>
        <div class="pull-left info">
          <p><?php echo e(auth()->guard('admin')->user()->first_name); ?> <?php echo e(auth()->guard('admin')->user()->last_name); ?></p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <?php if(session('dashboard_view')==1 or auth()->guard('admin')->user()->adminType=='1'): ?>
        <li class="treeview <?php echo e(Request::is('admin/dashboard/this_month') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>">
            <i class="fas fa-tachometer-alt"></i> <span><?php echo e(trans('labels.header_dashboard')); ?></span>
          </a>
        </li>
        <?php endif; ?>

         <?php if(session('user_group')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/usergroupList') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/usergroupList')); ?>">
            <i class="fa fa-users"></i> <span><?php echo e(trans('labels.user_group')); ?></span>
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

        <?php if(session('template')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/template') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/template')); ?>">
            <i class="far fa-file-alt"></i> <span><?php echo e(trans('labels.template')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('property')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/property') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/property')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.property')); ?></span>
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

        <?php if(session('property_features')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/property_features') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/property_features')); ?>">
            <i class="fas fa-home"></i> <span><?php echo e(trans('labels.property_features')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('price_list')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/price_list') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/price_list')); ?>">
            <i class="fas fa-home"></i> <span>Price List</span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('setting_payment')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/setting_payment') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/setting_payment')); ?>">
            <i class="fas fa-home"></i> <span>Setting</span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('pdf_report')==1 or auth()->guard('admin')->user()->adminType=='1'): ?> 
        <li class="treeview <?php echo e(Request::is('admin/pdf_report') ? 'active' : ''); ?>">
          <a href="<?php echo e(URL::to('admin/pdf_report')); ?>">
            <i class="fas fa-home"></i> <span>PDF Report</span>
          </a>
        </li>
        <?php endif; ?>

        

       
                         
          
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>