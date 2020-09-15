@extends('layouts.app')

@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.orderList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
            <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>          
                        <th>{{ trans('labels.orderid') }}</th>                     
                        <th>{{ trans('labels.name') }}</th>
                        <th>{{ trans('labels.status') }}</th>
                        <th>{{ trans('labels.total') }}</th>
                        <th>{{ trans('labels.date') }}</th>
                        <th>{{ trans('labels.mobile') }}</th>
                        <th>{{ trans('labels.action') }}</th>
                    </tr>

                </thead>
                <tbody>
                    @if(count($orders))
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->Order_ID ? $order->Order_ID : ''}}</td>
                                <td>{{$order->Name ? $order->Name : ''}}</td>
                                <td>{{$order->Status ? $order->Status : ''}}</td>
                                <td>{{$order->TotalCount ? $order->TotalCount : ''}}</td>
                                <td>{{$order->datetime ? $order->datetime : ''}}</td>
                                <td>{{$order->Mobile ? $order->Mobile : ''}}</td>
                                <td><a href="{{route('storeOrder.detail',['id'=>$order->Order_ID])}}" class='btn btn-primary'>Detail</a></td>
                            </tr>
                        @endforeach
                    @endif
            </table>
        <div style="margin-top: 15px;">{{ $orders->links('vendor.pagination.default') }}</div> 
        </div>
    </div>
</div>
@endsection