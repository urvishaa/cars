@extends('layouts.app')

@section('content')
    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.orderDetails') }}</h3>    
    <p><a href="{{ route('admin.orderlist') }}" class="btn btn-success">{{ trans('labels.cancel') }}</a>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.orderDetails') }}
        </div>
        <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
        <?php 
            $name = $result['orders']->Name ? $result['orders']->Name : '';
            $address = $result['orders']->address ? $result['orders']->address : '';
            $cityObj = $result['orders']->hasOneCity ? $result['orders']->hasOneCity : '';
            $cityName = $cityObj ? $cityObj->name : '';
            $pin = $result['orders']->pincode ? ' - '.$result['orders']->pincode : '';
            $mobile = $result['orders']->Mobile ? $result['orders']->Mobile : '';
        ?>   
        <div class="col-lg-4 col-md-6">
            <div class="rent-part">
                <div class="real_content">
                    <div class="estate_real">
                        <ul class="esta_ul">
                            <li class="esta_li">
                                <h3 class="prd-title">{{$name}}</h3>
                            </li>
                            <li class="esta_li">
                                <strong>{{ trans('labels.address') }}</strong> :{{$address}} , 
                                <br>{{$cityName}} - {{$pin}}.
                            </li>
                            <li class="esta_li">
                                <strong>{{ trans('labels.phone') }}</strong> :{{$mobile}} .
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>                        
                            <th>{{ trans('labels.image') }}</th>                     
                            <th>{{ trans('labels.Product') }}</th>                     
                            <th>{{ trans('labels.quantity') }}</th>
                            <th>{{ trans('labels.price') }}</th>
                            <th>{{ trans('labels.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $placeOrderObj = $result['orders']->hasManyPlaceOrder ? $result['orders']->hasManyPlaceOrder : '';
                            $grandTotal =0;
                            ?>
                        @if(count($placeOrderObj) > 0)
                            @foreach($placeOrderObj as $key=>$placeOrder)
                            <?php  ?>
                                <?php
                                    $productName = $placeOrder ? $placeOrder->Name : '';
                                    $quantity = $placeOrder ? $placeOrder->Quantity : 0;
                                    $price = $placeOrder ? $placeOrder->Price : 0;
                                    $total = $quantity * $price;
                                    $grandTotal = $grandTotal + $total;
                                    
                                    ?>
                                <tr>
                                    <td>
                                        <?php 
                                            $productImg = $placeOrder->hasManyProductImg ? $placeOrder->hasManyProductImg : '';
                                            if(count($productImg)){
                                                $img = '/public/productImage/'.$productImg[0]->img_name;
                                            }
                                            else{
                                                $img = '/public/default-image.jpeg';
                                            } 
                                        ?>

                                        <img src="{{url($img)}}" width="100px" height="100px" data-toggle="modal" data-target="#contactagent{{$key}}">
                                    </td>
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
                                        <select required autofocus id="status" name="status" class="field" onchange="changeStatus('{{route("admin.ordereditstatus",['id'=>$result['orders']->Order_ID])}}',this)">
                                            <option value="">--{{ trans('labels.orderStatus') }}--</option>
                                                <option value="Pending" @if($result['orders']->Status =='Pending') selected='selected'@endif>{{ trans('labels.pending') }}</option>                                                                              
                                                <option value="Shipping" @if($result['orders']->Status =='Shipping') selected='selected'@endif>{{ trans('labels.shipping') }}</option>                                                                              
                                                <option value="Deliver It" @if($result['orders']->Status =='Deliver It') selected='selected'@endif>{{ trans('labels.deliverIt') }}</option>                                                                              
                                                <option value="Rejected" @if($result['orders']->Status =='Rejected') selected='selected'@endif>{{ trans('labels.rejected') }}</option>                                                                              
                                        </select>            
                                </td>
                            </tr>
                        @endif
                    </tbody>       
                </table>
            </div>
        </div>
        </div>
        </div>
    </div>
    @if(count($placeOrderObj) > 0)
        @foreach($placeOrderObj as $key=>$placeOrder)
            <div id="contactagent{{$key}}" class="modal fade" role="dialog">
            
                <div class="modal-dialog">
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 style="color: #0d83a9;">{{ trans('labels.images') }}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <?php 
                                $productImg = $placeOrder->hasManyProductImg ? $placeOrder->hasManyProductImg : '';
                                if(count($productImg)){
                                    foreach($productImg as $productImage){
                                        $img = '/public/productImage/'.$productImage->img_name;
                            ?>
                                        <div class="col-md-8">
                                        <img src="{{url($img)}}" width="100px" height="100px" >
                                        </div>
                            <?php
                                    }
                                } 
                                else{
                                    echo "<center><h2>No Image Found</h2></center>";
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
<script type="text/javascript">

    
    function changeStatus(urls,obj){
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : obj.value},
            success: function(res){
                alert(res);
            }
        });
    }
</script>
@endsection