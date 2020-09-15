@extends('layouts.app')
@section('content')
<section class="content-header box-header-main">
      <h1>
        {{ trans('labels.downloads') }}  
       
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> {{ trans('labels.downloads') }}</li>
      </ol>
</section>

 <section class="content">  
      
      <div class="row">
        

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{ $android }}</h3>
               <p>{{ trans('labels.android') }}</p>
              </div>
              <div class="icon">
             <i class="fab fa-android"></i>
              </div>
           <a href="javascript:void(0)" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.androidDownloads') }}">{{ trans('labels.androidDownloads') }} <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="small-box bg-white">
              <div class="inner">
                   <h3>{{ $ios }}</h3>
               <p>{{ trans('labels.ios') }}</p>
              </div>
              <div class="icon">
             <i class="fab fa-apple"></i>

              </div>
            <a href="javascript:void(0)" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.iosDownloads') }}">{{ trans('labels.iosDownloads') }} <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
          </div>

          
      </div>

     

    </section>
@endsection 