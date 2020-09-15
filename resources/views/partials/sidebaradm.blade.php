<aside class="main-sidebar">

    <section class="sidebar">

    <?php
      $admin = auth()->guard('admin')->user(); 
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
    ?>
      @if ($admin['issubadmin'] == 0) 
        <a href="{{ URL::to('admin/dashboard')}}" class="logo">
          <span class="logo-lg"> <img src="<?php echo $new.'/resources/assets/img/iraq_car.png'; ?>"></span>
        </a>
       @else
        <a href="{{ URL::to('admin/profile')}}" class="logo">
          <span class="logo-lg"> <img src="<?php echo $new.'/resources/assets/img/iraq_car.png'; ?>"></span>
        </a>
      @endif

      <div class="user-panel">
        <div class="pull-left image">
           @if(auth()->guard('admin')->user()->image != "")
          <img src="{{ asset('').auth()->guard('admin')->user()->image}}" class="img-circle">
           @else 
              <img class="profile-user-img img-responsive img-circle" src="{{ url('public/default-image.jpeg')}}" alt="profile picture">
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ auth()->guard('admin')->user()->first_name }} {{ auth()->guard('admin')->user()->last_name }}</p>
        </div>
      </div>
      <ul class="sidebar-menu">
      @if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4 ) 


        @if(session('dashboard_view')==1 or auth()->guard('admin')->user()->adminType=='1')
        <li class="treeview {{ Request::is('admin/dashboard') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/dashboard')}}">
            <i class="fas fa-tachometer-alt"></i> <span>{{ trans('labels.header_dashboard') }}</span>
          </a>
        </li>
        @endif


        @if(session('user')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/user') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/user')}}">
            <i class="fa fa-user"></i> <span>{{ trans('labels.user') }}</span>
          </a>
        </li>
        @endif

        @if(session('showRoomAdmin')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/showRoomAdmin') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/showRoomAdmin')}}">
           <i class="fa fa-user-plus" aria-hidden="true"></i><span>{{ trans('labels.showRoomAdmin') }}</span>
          </a>
        </li>
        @endif

      
          @if(session('StoreAdmin')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/StoreAdmin') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/StoreAdmin')}}">
           <i class="fa fa-users" aria-hidden="true"></i><span>{{ trans('labels.StoreAdmin') }}</span>
          </a>
        </li>
        @endif

       @if(session('companyAdmin')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/companyAdmin') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/companyAdmin')}}">
            <i class="fa fa-building" aria-hidden="true"></i> <span>{{ trans('labels.rentalCompanies') }}</span>
          </a>
        </li>
        @endif



     
        @if(session('orderList')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/orderlist') ? 'active' : '' }}">
          <a href="{{ route('admin.orderlist')}}">
           <i class="fas fa-sort-numeric-down"></i><span>{{ trans('labels.orderList') }}</span>
          </a>
        </li>
        @endif


        
        

        @if(session('carBrand')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/carBrand') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/carBrand')}}">
            <i class="fa fa-plus-square" aria-hidden="true"></i> <span>{{ trans('labels.carBrand') }}</span>
          </a>
        </li>
        @endif

          

        @if(session('fuelType')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/fueltype') ? 'active' : '' }}">
          <a href="{{ route('admin.fueltype')}}">
            <i class="fa fa-list" aria-hidden="true"></i> <span>{{ trans('labels.fuelType') }}</span>
          </a>
        </li>
        @endif

        @if(session('category')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/category') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/category')}}">
            <i class="fa fa-bus" aria-hidden="true"></i> <span>{{ trans('labels.carCategory') }}</span>
          </a>
        </li>
        @endif

        @if(session('car_year')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/year') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/year')}}">
           <i class="fas fa-calendar-alt"></i> <span>{{ trans('labels.carYear') }}</span>
          </a>
        </li>
        @endif

        @if(session('homeslide')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/homeslide') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/homeslide')}}">
            <i class="fa fa-bars" aria-hidden="true"></i> <span>{{ trans('labels.homeslide') }}</span>
          </a>
        </li>
        @endif

        @if(session('car_type')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/car_type') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/car_type')}}">
            <i class="fa fa-braille" aria-hidden="true"></i> <span>{{ trans('labels.car_type') }}</span>
          </a>
        </li>
        @endif

        @if(session('ads')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/ads') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/ads')}}">
            <i class="fab fa-buysellads"></i> <span>{{ trans('labels.ads') }}</span>
          </a>
        </li>
        @endif

        @if(session('notification')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/notification/create') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/notification/create')}}">
           <i class="fas fa-envelope"></i></i> <span>{{ trans('labels.notification') }}</span>
          </a>
        </li>
        @endif      

        @if(session('topCar')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/topCar') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/topCar/create')}}">
          <i class="fa fa-trophy" aria-hidden="true"></i><span>{{ trans('labels.topCar') }}</span>
          </a>
        </li>
        @endif


        <!-- @if(session('contactAgent')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/contactAgent') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/contactAgent')}}">
           <i class="fa fa-address-card" aria-hidden="true"></i> <span>{{ trans('labels.contactAgent') }}</span>
          </a>
        </li>
        @endif -->

        @if(session('contactAgent')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/city') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/city')}}">
           <i class="fa fa-map-marker" aria-hidden="true"></i> <span>{{ trans('labels.addCity') }}</span>
          </a>
        </li>
        @endif

        @if(session('downloads')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/downloads') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/downloads')}}">
          <i class="fa fa-download" aria-hidden="true"></i> <span>{{ trans('labels.downloads') }}</span>
          </a>
        </li>
        @endif


    @endif  

      @if($admin->issubadmin == 2 || $admin->issubadmin == 0 || $admin->issubadmin == 4)
        @if(session('car')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/car') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/car')}}">
            <i class="fas fa-car"></i> <span>{{ trans('labels.car') }}</span>
          </a>
        </li>
        @endif
      @endif    


      @if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4)
        @if(session('procategory')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/procategory') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/procategory')}}">
           <i class="fa fa-sitemap" aria-hidden="true"></i> <span>{{ trans('labels.proCategory') }}</span>
          </a>
        </li>
        @endif
      @endif

    @if($admin->issubadmin == 3 || $admin->issubadmin == 0)
        @if(session('car_accessories')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/car_accessories') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/car_accessories')}}">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span>{{ trans('labels.Product') }}</span>
          </a>
        </li>
        @endif   
     @endif        
        
     @if($admin->issubadmin == 3 || $admin->issubadmin == 0)
        @if(session('orderList')==1 or $admin->issubadmin == 3) 
        <li class="treeview {{ Request::is('order/list') ? 'active' : '' }}">
          <a href="{{ route('storeOrder.list')}}">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span>{{ trans('labels.orderList') }}</span>
          </a>
        </li>
        @endif   
     @endif
    

        @if($admin->issubadmin != 2 && $admin->issubadmin != 3 && $admin->issubadmin != 4 ) 

          @if(session('contactUs')==1 or auth()->guard('admin')->user()->adminType=='1') 
            <li class="treeview {{ Request::is('admin/contact/create') ? 'active' : '' }}">
              <a href="{{ route('contact.create')}}">
                <i class="fas fa-id-card"></i> <span>{{ trans('labels.contact') }}</span>
              </a>
            </li>
          @endif



        @if(session('aboutus')==1 or auth()->guard('admin')->user()->adminType=='1') 
        <li class="treeview {{ Request::is('admin/about') ? 'active' : '' }}">
          <a href="{{ URL::to('admin/about/create')}}">
            <i class="far fa-address-book"></i> <span>{{ trans('labels.about') }}</span>
          </a>
        </li>
        @endif
        @endif
      
       @if($admin->issubadmin == 4 || $admin->issubadmin == 0)
      
            <li class="treeview {{ Request::is('booking/list') ? 'active' : '' }}">
            <a href="{{ route('carBooking.list')}}"> 
              <i class="fa fa-tasks" aria-hidden="true"></i> <span>{{ trans('labels.carBookingList') }}</span>
            </a>
        @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>