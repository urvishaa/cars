
@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2>{{ trans('labels.storeAdminList') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part">
                        @if(count($result['storeAdmins']))
                            @foreach($result['storeAdmins'] as $storeAdmin)
                                <div class="item">
                                    <div class="img_real_home Car-rent">
                                        <div class="img_real">
                                            <img src="{{ $storeAdmin->image ? $new.'/'.$storeAdmin->image : url('/public/default-image.jpeg' )}}">
                                        </div>
                                        <div class="real_content">
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                @if($storeAdmin->first_name !='' || $storeAdmin->last_name != '') 
                                                    
                                                    <li class="esta_li">
                                                        <a href="{{route('productlist',['id'=>$storeAdmin->myid])}}">{{$storeAdmin->first_name }} {{$storeAdmin->last_name}}</a>

                                                    </li>
                                                @endif

                                                @if($storeAdmin->phone !='') 
                                                    <li class="esta_li telp">
                                                        <a href="tel:{{$storeAdmin->phone}}">
                                                            <i class="fas fa-phone-alt"></i>{{$storeAdmin->phone}}
                                                        </a>
                                                        
                                                    </li>
                                                @endif

                                                @if($storeAdmin->email !='') 
                                                    <li class="esta_li telp">
                                                        <a href="mailto:{{$storeAdmin->email }}"><i class="fas fa-envelope"></i>{{$storeAdmin->email}}</a>
                                                    </li>                           
                                                @endif
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif                   
                    </div>
                    <div class="col-xs-12 text-right">
                        {{ $result['storeAdmins']->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection