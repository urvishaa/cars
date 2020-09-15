<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('').auth()->guard('admin')->user()->image}}" class="img-circle" alt="{{ auth()->guard('admin')->user()->first_name }} {{ auth()->guard('admin')->user()->last_name }} Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->guard('admin')->user()->first_name }} {{ auth()->guard('admin')->user()->last_name }}</p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
   

         @if(session('user_group')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/usergroupList') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/usergroupList')}}">
            <i class="fa fa-user"></i> <span>{{ trans('labels.user_group') }}</span>
          </a>
        </li>
        @endif

        @if(session('categories_view')==1  or auth()->guard('admin')->user()->adminType=='1')
        <li class="treeview {{ Request::is('admin/categories') ? 'active' : '' }} {{ Request::is('admin/addcategory') ? 'active' : '' }} {{ Request::is('admin/editCategory/*') ? 'active' : '' }} {{ Request::is('admin/subcategories') ? 'active' : '' }}  {{ Request::is('admin/addsubcategory') ? 'active' : '' }}  {{ Request::is('admin/editsubcategory/*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-bars" aria-hidden="true"></i>
              <span>{{ trans('labels.link_categories') }} </span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
          	<li class="{{ Request::is('admin/categories') ? 'active' : '' }} {{ Request::is('admin/addcategory') ? 'active' : '' }} {{ Request::is('admin/editcategory/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/categories')}}"><i class="fa fa-circle-o"></i> {{ trans('labels.link_main_categories') }}</a></li>
            <li class="{{ Request::is('admin/subcategories') ? 'active' : '' }}  {{ Request::is('admin/addsubcategory') ? 'active' : '' }}  {{ Request::is('admin/editsubcategory/*') ? 'active' : '' }}"><a href="{{ URL::to('admin/subcategories')}}"><i class="fa fa-circle-o"></i>{{ trans('labels.link_sub_categories') }}</a></li>
          </ul>
        </li>
        @endif

       
          <li class="treeview {{ Request::is('admin/setting') ? 'active' : '' }}">
            <a href="{{ URL::to('admin/setting')}}">
              <i class="fa fa-dashboard"></i> <span>{{ trans('labels.setting') }}</span>
            </a>
          </li>               
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>