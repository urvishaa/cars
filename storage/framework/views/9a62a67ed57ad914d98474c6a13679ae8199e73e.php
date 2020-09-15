<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
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
            <i class="fa fa-dashboard"></i> <span><?php echo e(trans('labels.header_dashboard')); ?></span>
          </a>
        </li>
        <?php endif; ?>

        <?php if(session('categories_view')==1  or auth()->guard('admin')->user()->adminType=='1'): ?>
        <li class="treeview <?php echo e(Request::is('admin/categories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addcategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editCategory/*') ? 'active' : ''); ?> <?php echo e(Request::is('admin/subcategories') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addsubcategory') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editsubcategory/*') ? 'active' : ''); ?>">
          <a href="#">
            <i class="fa fa-bars" aria-hidden="true"></i>
              <span><?php echo e(trans('labels.link_categories')); ?> </span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="<?php echo e(Request::is('admin/categories') ? 'active' : ''); ?> <?php echo e(Request::is('admin/addcategory') ? 'active' : ''); ?> <?php echo e(Request::is('admin/editcategory/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/categories')); ?>"><i class="fa fa-circle-o"></i> <?php echo e(trans('labels.link_main_categories')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/subcategories') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/addsubcategory') ? 'active' : ''); ?>  <?php echo e(Request::is('admin/editsubcategory/*') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('admin/subcategories')); ?>"><i class="fa fa-circle-o"></i><?php echo e(trans('labels.link_sub_categories')); ?></a></li>
          </ul>
        </li>
        <?php endif; ?>

       
          <li class="treeview <?php echo e(Request::is('admin/setting') ? 'active' : ''); ?>">
            <a href="<?php echo e(URL::to('admin/setting')); ?>">
              <i class="fa fa-dashboard"></i> <span><?php echo e(trans('labels.setting')); ?></span>
            </a>
          </li>               
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>