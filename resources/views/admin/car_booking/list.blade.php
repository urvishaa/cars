@extends('layouts.app')

@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.carBookingList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
            <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>          
                        <th>{{ trans('labels.car') }}</th>                     
                        <th>{{ trans('labels.name') }}</th>
                        <th>{{ trans('labels.email') }}</th>
                        <th>{{ trans('labels.status') }}</th>
                        <th>{{ trans('labels.phone') }}</th>
                        <th>{{ trans('labels.fromDate') }}</th>
                        <th>{{ trans('labels.toDate') }}</th>
                        <th>{{ trans('labels.detail') }}</th>
                    </tr>

                </thead>
                <tbody>
                    @if(count($bookings))
                        @foreach($bookings as $booking) 
                            <tr>
                                <td><a href="{{route('carBooking.edit',['id'=>$booking->id])}}">{{$booking->car_name ? $booking->car_name : ''}}</a></td>
                                <td>{{$booking->firstName ? $booking->firstName : ''}} {{$booking->lastName ? $booking->lastName : ''}}</td>
                                <td>{{$booking->contact_agent_email ? $booking->contact_agent_email : ''}}</td>
                                <td>{{$booking->status ? $booking->status : ''}}</td>
                                <td>{{$booking->contact_agent_phone ? $booking->contact_agent_phone : ''}}</td>
                                <td>{{$booking->dateFrom ? $booking->dateFrom : ''}}</td>
                                <td>{{$booking->dateTo ? $booking->dateTo : ''}}</td>
                                <td><a href="{{route('carBooking.detail',['id'=>$booking->contact_agent_id])}}" class="btn btn-primary">Detail</a></td>
                            </tr>
                        @endforeach
                    @endif
            </table>
        <div style="margin-top: 15px;">{{ $bookings->links('vendor.pagination.default') }}</div> 
        </div>
    </div>
</div>
@endsection