@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);

?>



    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2>Product List</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part">
                    @if(count($result['products']))
                        @foreach($result['products'] as $product)
                        <div class="item">
                            <div class="img_real_home Car-rent">
                            <div class="img_real">
                                <img src="{{ $product->img_name ? url('/public/productImage/'.$product->img_name) : url('/public/default-image.jpeg' )}}">
                            </div>
                            <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            @if($product->name !='')                                                 
                                                <li class="esta_li">
                                                    <a href="#">{{$product->name}}</a>
                                                    
                                                </li>
                                                @endif
                                            @if($product->description !='') 
                                                <li class="esta_li telp">
                                                    <a href="tel:{{$product->description}}">
                                                    {{ trans('labels.description') }} :{{$product->description}}
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            @if($product->price !='' || $product->size != '') 
                                                <li class="esta_li telp">
                                                    <a href="tel:{{$product->price}}">
                                                    {{ trans('labels.price') }} :{{$product->price}} , 
                                                    {{ trans('labels.size') }} :{{$product->size}}
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            @if($product->color !=''  || $product->model != '') 
                                                <li class="esta_li telp">
                                                    <a href="tel:{{$product->color}}">
                                                    {{ trans('labels.color') }} :{{$product->color}} , 
                                                    {{ trans('labels.model') }} :{{$product->model}}
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            
                                            @if($product->specification !='') 
                                                <li class="esta_li telp">
                                                    <a href="tel:{{$product->specification}}">
                                                    {{ trans('labels.specification') }} :{{$product->specification}}
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            @if($product->quantity !='') 
                                            <?php
                                                $productlist = \App\PlaceOrder::where('Product_ID',$product->id)->sum('Quantity');
                                                $compareQuantity = $product->quantity - $productlist;
                                            ?>
                                                @if($compareQuantity > 0)
                                                    <li class="esta_li telp">
                                                        <a href="tel:{{$product->quantity}}">
                                                        {{ trans('labels.availableQuantity') }} :{{$compareQuantity}}
                                                        </a>
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="{{route('addnewcart',['id'=>$product->id])}}" class="btn btn-success">{{ trans('labels.addToCart') }}</a>
                                                    </li>
                                                @else
                                                <li class="esta_li telp">
                                                {{ trans('labels.availableQuantity') }}:<div class="alert alert-danger">
                                                {{ trans('labels.outOfStock') }}
                                                    </div>
                                                </li>
                                               
                                                @endif
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
                        {{$result['products']->links('vendor.pagination.default')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection