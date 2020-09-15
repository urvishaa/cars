@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

<div class="myordr-list section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>{{ trans('labels.myorderlist') }}</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>
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
               
                <div class="table-responsive prolisttabcls">
                    <table class="table" >
                        <thead>
                            <tr>                        
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.orderid') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.name') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.city') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.date') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.status') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.total') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.action') }}</div></th>
                            </tr>
                        </thead>       
                            <tbody>
                            @if(count($result['orders']) > 0)
                                @foreach($result['orders'] as $order)
                                    <tr>
                                        <td class="align-middle text-center">
                                            {{$order->Order_ID ? $order->Order_ID : 0}}
                                        </td>
                                        <td class="align-middle text-center">
                                            {{$order->Name ? $order->Name : ''}}
                                        </td>
                                        <td class="align-middle text-center">
                                        <?php 
                                            $cityObj = $order->hasOneCity ? $order->hasOneCity : '';
                                            $cityName = $cityObj ? $cityObj->name : '';
                                        ?>
                                            {{$cityName}}

                                        </td>
                                        <td class="align-middle text-center">                        
                                            {{$order->datetime ? $order->datetime : 0}}

                                        </td>
                                        <td class="align-middle text-center">                        
                                            {{$order->Status ? $order->Status : ''}}

                                        </td>
                                        <td class="align-middle text-center">                        
                                            {{$order->TotalCount ? $order->TotalCount : ''}}

                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{route('order.detail',['id'=>$order->Order_ID])}}" class="btn btn-primary">{{ trans('labels.detail') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <center><h5>{{ trans('labels.noResultFound') }}</h5></center>
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
@endsection