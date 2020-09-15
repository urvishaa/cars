@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
// echo '<pre>'; print_r($result['book']);die;
?>

<div class="myordr-list section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>{{ trans('labels.carBookList') }}</h2>
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
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.bookingId') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.carName') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.carBrand') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.carModel') }}</div></th>
                              
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.dateFrom') }}</div></th>
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.dateTo') }}</div></th>
                            
                                <th class="border-0 bg-light text-center"><div class="p-2 px-3 text-uppercase">{{ trans('labels.action') }}</div></th>
                            </tr>
                        </thead>       
                            <tbody>
                            @if(count($result['book']) > 0)
                                @foreach($result['book'] as $book)

                                    @if($book->prop_category != '' AND $book->prop_category > 0)
                                        <?php @$carmodel = DB::table('car_model')->where('id',@$book->prop_category)->first(); ?>
                                    @endif

                                    @if($book->car_brand != '' AND $book->car_brand > 0)
                                        <?php @$carbrand = DB::table('car_brand')->where('id',@$book->car_brand)->first(); ?>
                                    @endif
                                    <tr>
                                        <td class="align-middle text-center">
                                            {{ '#' }}{{ $book->id }}
                                        </td>
                                        <td class="align-middle text-center">
                                           <a href="{{ URL::to('/rentalcar_detail/'.$book->carId) }}"> {{ @$book->car_name }} </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ @$carbrand->name }}
                                        </td>
                                         <td class="align-middle text-center">
                                            
                                            {{ @$carmodel->name }}
                                       
                                        </td>
                                        <td class="align-middle text-center">                        
                                            {{$book->dateFrom}}

                                        </td>
                                        <td class="align-middle text-center">                        
                                            {{$book->dateTo}}

                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <a href="{{ url('/book-detail/'.base64_encode($book->id)) }}" class="btn btn-primary">{{ trans('labels.detail') }}</a>
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
                @if(count($result['book']) > 0)           
                      {{$result['book']->links('vendor.pagination.default')}}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection