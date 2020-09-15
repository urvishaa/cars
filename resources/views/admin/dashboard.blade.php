@extends('layouts.app')
@section('content')
    <section class="content-header box-header-main">
      <h1>
        {{ trans('labels.title_dashboard') }}  
        <small>{{ trans('labels.title_dashboard') }} </small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</li>
      </ol>
    </section>

    <section class="content">  
      
      <div class="row">
          {{-- <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                <h3>{{ $usergroupCount }}</h3>
               <p>{{ trans('labels.user_group') }}</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="{{ URL::to('admin/usergroupList')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.user_group') }}">{{ trans('labels.user_group') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> --}}

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{$User}}</h3>
               <p>{{ trans('labels.user') }}</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
           <a href="{{ URL::to('admin/users')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllusers') }}">{{ trans('labels.viewAllusers') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{ $ShowRoomAdmin }}</h3>
               <p>{{ trans('labels.showrooms') }}</p>
              </div>
              <div class="icon">
              <i class="fa fa-address-card" ></i>

              </div>
            <a href="{{ URL::to('admin/showRoomAdmin')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllshowrooms') }}">{{ trans('labels.viewAllshowrooms') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{ $car }}</h3>
               <p>{{ trans('labels.car') }}</p>
              </div>
              <div class="icon">
                <i class="fa fa-car"></i>
              </div>
            <a href="{{ URL::to('admin/car')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllcar') }}">{{ trans('labels.viewAllcar') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{ $Ads }}</h3>
               <p>{{ trans('labels.ads') }}</p>
              </div>
              <div class="icon">
                <i class="fa fa-newspaper" aria-hidden="true"></i>
              </div>
            <a href="{{ URL::to('admin/ads')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllads') }}">{{ trans('labels.viewAllads') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

      </div>

      <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('labels.latestUsers') }}</h3>

                  <div class="box-tools pull-right">
                 
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    @foreach($userdetail as $userdata)
                      <li>
                          @if (!empty($userdata->image) && $userdata->image != '') 
                            <img src="{{ url('/public/profileImage/'.$userdata->image) }}"  height="30px" width="30px" alt="User Image">   
                          @else
                              <img src="{{ url('public/default-image.jpeg') }}"  height="50px" width="50px" alt="User Image">                    
                          @endif     
                        <a class="users-list-name" href="{{ url('/admin/users/'.$userdata->id.'/edit') }}">{{$userdata->name}}</a>
                        <span class="users-list-date">{{$userdata->email}}</span>
                      </li>
                    @endforeach
              
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ url('/admin/users') }}" class="uppercase">{{ trans('labels.viewAllusers') }}</a>
                </div>
                <!-- /.box-footer -->
      </div>




      <div class="row rec_box">
        <div class="col-md-6">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.recentlyAddedCars') }}</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"></button>
            </div>
          </div>
          <div class="box-body">
            <ul class="products-list product-list-in-box">

              @foreach($cardetail as $cardata)

              <li class="item">
                <div class="product-img">
                  @if (!empty($cardata->image) && $cardata->image != '') 
                    <img src="{{ url('/public/carImage/'.$cardata->image) }}" alt="Product Image">   
                  @else
                      <img src="{{ url('public/default-image.jpeg') }}" alt="Product Image">                    
                  @endif    
                  
                </div>
                <div class="product-info">
                  <a href="{{ url('/admin/car/'.$cardata->id.'/edit') }}" class="product-title">{{$cardata->car_name}}
                    <span class="label label-warning pull-right">{{ $cardata->sale_price}}</span></a>
                    <span class="product-description">
                        {{$cardata->description}}
                    </span>
                </div>
              </li>   
              @endforeach           
             
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="{{ url('/admin/car') }}" class="uppercase">{{ trans('labels.viewAllcar') }}</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.ads') }}</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"></button>
            </div>
          </div>
          <div class="box-body">
            <ul class="products-list product-list-in-box">

              @foreach($AdsDash as $Ads)
             
              <li class="item">
                <div class="product-img">
                  @if (!empty($Ads->image) && $Ads->image != '') 
                    <img src="{{ url('/public/dsaImage/'.$Ads->image) }}" alt="Product Image">   
                  @else
                      <img src="{{ url('public/default-image.jpeg') }}" alt="Product Image">                    
                  @endif    
                  
                </div>
                <div class="product-info">
                  <a href="{{ url('/admin/ads/'.$Ads->id.'/edit') }}" class="product-title">{{$Ads->name}}
                    {{-- <span class="label label-warning pull-right">{{ $Ads->sale_price}}</span></a> --}}
                    <span class="product-description">
                        {{$Ads->description}}
                      </span>
                </div>
              </li>   
              @endforeach           
             
            </ul>
          </div>
          <div class="box-footer text-center">
            <a href="{{ url('/admin/ads') }}" class="uppercase">{{ trans('labels.viewAllads') }}</a>
          </div>
        </div>
      </div>


    </section>

<script src="{!! asset('resources/views/admin/dist/js/pages/dashboard2.js') !!}"></script>
  @endsection