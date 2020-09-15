@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>





<div class="cart_page">
    <div class="container">
         <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                    <div class="alert alert-info">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                @endif
            </div>
        </div> 
      <div class="row">
        <div class="col-lg-12 bg-white rounded shadow-sm">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
                @if(Session::has('cart'))
                    <?php $allCarts=Session()->get('cart'); ?>
                    @if(count($allCarts) > 0)
                        <thead>
                            <tr>
                              <th scope="col" class="border-0 bg-light">
                                <div class="p-2 px-3 text-uppercase">{{ trans('labels.Product') }}</div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">{{ trans('labels.price') }}</div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">{{ trans('labels.quantity') }}</div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">{{ trans('labels.total') }}</div>
                              </th>
                              <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">{{ trans('labels.remove') }}</div>
                              </th>
                            </tr>
                        </thead>
                        @foreach($allCarts as $index=>$cart)
                        <tbody>
                            <tr>
                              <th scope="row" class="border-0">
                                <div class="p-2" style="display: flex;">
                                  <img src="{{ $cart['img_name'] ? url('/public/productImage/'.$cart['img_name']) : url('/public/default-image.jpeg' )}}" alt="" width="100" class="img-fluid rounded shadow-sm">
                                  <div class="ml-3 d-inline-block align-middle" style=" min-width: 200px;">
                                    <h5 class="mb-0">
                                        <a href="#" class="text-dark d-inline-block align-middle">
                                            @if($cart['name'] !='')                                                 
                                                {{$cart['name']}}
                                            @endif
                                        </a>
                                    </h5>
                                  </div>
                                </div>
                              </th>
                              <td class="border-0 align-middle">
                                <strong>
                                    @if($cart['price'] !='') 
                                        {{$cart['price']}}  
                                    @endif
                                </strong>
                            </td>
                              <td class="border-0 align-middle">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                        <button onclick="minusQuantitys('{{route('updatecart',['id'=>$index])}}','{{$index}}')" class="btn btn-default btn-number" style="box-shadow: none; cursor: pointer;"><i class="fas fa-minus"></i></button>
                                        </span>
                                        <input type='number' class="form-control input-number" value="{{$cart['quantity']}}" min="1"  id="quantity{{$index}}" onclick="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onkeyup="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onpaste="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onchange="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" style="width: auto; max-width: 60px; text-align: center; box-shadow: none;">   
                                        <span class="input-group-btn">
                                        <button onclick="addQuantitys('{{route('updatecart',['id'=>$index])}}','{{$index}}')" class="btn btn-default btn-number" style="box-shadow: none; cursor: pointer;"><i class="fas fa-plus"></i></button>
                                        </span>
                                    </div>
                              </td>
                              <td class="border-0 align-middle">
                                    <p id="price{{$index}}">{{ $cart['quantity'] * $cart['price'] }}</p>
                              </td>
                              <td class="border-0 align-middle"><a href="{{route('deletecart',['id'=>$index])}}" class="btn btn-outline-danger"><i class="fa fa-trash"></i> {{ trans('labels.remove') }}</a></td>
                            </tr>
                            <?php 
                                $cartTotal = $cart['quantity'] * $cart['price'];
                                $grandTotal = $grandTotal+ $cartTotal;
                             ?>
                        @endforeach
                        <tr>
                            <td colspan="3">
                                <div class="cart-car-img">
                                    <img src="{{ URL::to('/resources/assets/img/car-image.png')}}">
                                </div>
                            </td>
                            <td colspan="2" >
                                <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">{{ trans('labels.orderSummary') }} </div>
                                  <div class="p-4">
                                    <ul class="list-unstyled mb-4">
                                      <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{ trans('labels.totalPayable') }}</strong>
                                        <h5 class="font-weight-bold" id="grand-total">{{$grandTotal}}</h5>
                                      </li>
                                    </ul><a href="{{route('buynow.form')}}" class="btn btn-myclr rounded-pill py-2 btn-block">{{ trans('labels.procceedToCheckout') }}</a>
                                  </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                @endif
            </table>
          </div>
          <!-- End -->
        </div>
      </div>
    </div>
</div>
















    <!-- <div class="panel panel-default">       
        <div class="panel-body table-responsive progrmslistcls">  
           
            <div class="prolisttabcls">
                <table class="table table-bordered" >
                    @if(Session::has('cart'))
                        <?php $allCarts=Session()->get('cart'); ?>
                        @if(count($allCarts) > 0)
                    <thead>
                        <tr>                        
                            <th>{{ trans('labels.image') }}</th>
                            <th>{{ trans('labels.name') }}</th>
                            <th>{{ trans('labels.price') }}</th>
                            <th>{{ trans('labels.quantity') }}</th>
                            <th>{{ trans('labels.total') }}</th>
                            <th>{{ trans('labels.action') }}</th>
                        </tr>
                    </thead>       
                            @foreach($allCarts as $index=>$cart)
                                <tbody>
                                    <tr>
                                        
                                        <td>
                                            <div class="img_real">
                                                <img src="{{ $cart['img_name'] ? url('/public/productImage/'.$cart['img_name']) : url('/public/default-image.jpeg' )}}" width="150px;">
                                            </div>
                                        </td>
                                        <td>
                                            @if($cart['name'] !='')                                                 
                                                    {{$cart['name']}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($cart['price'] !='') 
                                                {{$cart['price']}}  
                                            @endif
                                        </td>
                                        <td>                        
                                            @if($cart['quantity'] !='') 
                                                <button onclick="minusQuantitys('{{route('updatecart',['id'=>$index])}}','{{$index}}')">-</button>
                                                <input type='number' value="{{$cart['quantity']}}" min="1"  id="quantity{{$index}}" onclick="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onkeyup="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onpaste="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')" onchange="addQuantity('{{route('updatecart',['id'=>$index])}}','{{$index}}')">   
                                                <button onclick="addQuantitys('{{route('updatecart',['id'=>$index])}}','{{$index}}')">+</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($cart['quantity'] !='' && $cart['price']) 
                                                <p id="price{{$index}}">{{ $cart['quantity'] * $cart['price'] }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('deletecart',['id'=>$index])}}" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                    <?php 
                                        $cartTotal = $cart['quantity'] * $cart['price'];
                                        $grandTotal = $grandTotal+ $cartTotal;
                                     ?>
                            @endforeach
                            <tr>
                                <td colspan="4">
                                    <a href="{{route('buynow.form',['total'=>$grandTotal])}}"><img src="{{asset('public/aboutImage/addToCartButton.jpeg')}}" alt=""></a>
                                </td>
                                
                                <td colspan="2">
                                        Total Payable:<p id="grand-total">{{$grandTotal}}</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    @endif                   
                </table>
            </div>               
        </div>
    </div> -->
<script type="text/javascript">

    
    function addQuantity(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        if(quantity <= 0){
            quantity = 1;
        }
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#price"+id).text(res.total);
                jQuery("#grand-total").text(res.grandTotal);
            }
        });
    }
    function addQuantitys(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        if(quantity <= 0){
            quantity = 1;
        }
        quantity++;
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#grand-total").text(res.grandTotal);
                jQuery("#price"+id).text(res.total);
            }
        });
    }
    function minusQuantitys(urls,id){
        var quantity = jQuery("#quantity"+id).val();
        quantity--;
        if(quantity <= 0){
            quantity = 1;
        }
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'quantity':quantity},
            success: function(res){
                jQuery("#quantity"+id).val(res.quantity);
                jQuery("#grand-total").text(res.grandTotal);
                jQuery("#price"+id).text(res.total);
            }
        });
    }  


</script>

@endsection