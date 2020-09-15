@extends('layouts.app')

@section('content')
    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.orderDetails') }}</h3>    
    <p><a href="{{ route('storeOrder.list') }}" class="btn btn-success">{{ trans('labels.cancel') }}</a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.orderDetails') }}
        </div>
       
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>                        
                            <th>{{ trans('labels.Product') }}</th>                     
                            <th>{{ trans('labels.quantity') }}</th>
                            <th>{{ trans('labels.price') }}</th>
                            <th>{{ trans('labels.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $grandTotal =0;
                       ?>
                        @if(count($orders) > 0)
                            @foreach($orders as $order)
                                <?php
                                    $productName = $order->name ? $order->name : '';
                                    $quantity = $order ? $order->Quantity : 0;
                                    $price = $order ? $order->Price : 0;
                                    $total = $quantity * $price;
                                    $grandTotal = $grandTotal + $total;
                                ?>
                                <tr>
                                    <td>
                                        {{$productName}}
                                    </td>
                                    <td>
                                        {{$quantity}}                                
                                    </td>
                                    <td>
                                        {{$price}}                                
                                    </td>
                                    <td>
                                        {{$total}}                                    
                                    </td>
                                </tr>
                            @endforeach    
                            <tr>
                                <td colspan="2">
                                {{ trans('labels.grandTotal') }} :{{$grandTotal}}
                                </td>
                                <td colspan="2">
                                    {{ trans('labels.status') }} :
                                        <select required autofocus id="status" name="status" class="field" onchange="changeStatus('{{route("admin.ordereditstatus",['id'=>$order->Order_ID])}}',this)">
                                            <option value="">--{{ trans('labels.orderStatus') }}--</option>
                                                <option value="Pending" @if($order->Status =='Pending') selected='selected'@endif>{{ trans('labels.pending') }}</option>                                                                              
                                                <option value="Delivered" @if($order->Status =='Delivered') selected='selected'@endif>{{ trans('labels.delivered') }}</option>                                                                              
                                                <option value="Shipping" @if($order->Status =='Shipping') selected='selected'@endif>{{ trans('labels.shipping') }}</option>                                                                              
                                        </select>            
                                </td>
                            </tr>
                        @endif

                    </tbody>       
                </table>
            </div>
            @if(count($orders))
                <div class="car-details-inr">
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                            <h4>{{ trans('labels.name') }} : {{$orders[0]->Name ? $orders[0]->Name : ''}}</h4> 
                        </div>
                    </div>
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4>{{ trans('labels.mobile') }} : {{$orders[0]->Mobile ? $orders[0]->Mobile : ''}}</h4> 
                        </div>
                    </div>
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4>{{ trans('labels.address') }} : {{$orders[0]->address ? $orders[0]->address : ''}}</h4> 
                        </div>
                    </div> 
                    <div class="car-det-inr">
                        <div class="car-det-inr left">
                        <h4>{{ trans('labels.city') }} : {{$orders[0]->city_name ? $orders[0]->city_name : ''}} {{$orders[0]->pincode ? '-'. $orders[0]->pincode : ''}}.</h4> 
                        </div>
                    </div> 
                </div>
            @endif
        </div>
    </div>
<script type="text/javascript">

    
    function changeStatus(urls,obj){
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : obj.value},
            success: function(res){
            }
        });
    }
</script>
@endsection