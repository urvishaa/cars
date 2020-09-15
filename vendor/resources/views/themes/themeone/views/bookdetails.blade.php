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
                    <h2>{{ trans('labels.bookingDetail') }}</h2>
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
        <!-- <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
               
                <div class="col-lg-6 col-md-6">
                        
                    <div class="rent-part">
                            
                        <div class="real_content">
                            
                            <div class="estate_real detail">
                               <div class="user-deatils">
                                  <h4 style="color: #363636;">Contact Agent</h4>
                                  <div class="user-deti">
                                    <div class="user-info">
                                        <p><label>First Name:</label>
                                            <span>Alexa</span></p>
                                     </div>
                                     <div class="user-info">
                                        <p><label>Last Name:</label>
                                            <span>Liza</span></p>
                                     </div>
                                     <div class="user-info">
                                        <p><label>Email:</label>
                                            <span>Alex@gmail.com</span></p>
                                     </div>  
                                    <div class="user-info">
                                        <p><label>Nationality:</label>
                                            <span>Alex@gmail.com</span></p>
                                     </div>
                                    <div class="user-info">
                                        <p><label>Phone:</label>
                                            <span>0123456789</span></p>
                                     </div>
                                      <div class="user-info">
                                        <p><label>Phone:</label>
                                            <span>0123456789</span></p>
                                     </div>

                                  </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
           
            </div>
        </div> -->

        <div class="bookcarcls">
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="panel-heading">
                          <div class="form-group">
                              <label>{{ trans('labels.myDetails') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label>{{ trans('labels.name') }} :</label><span>{{ $detail->firstName }} {{ $detail->lastName }}</span>                                        
                          </div>
                          <div class="form-group">                    
                              <label>{{ trans('labels.email') }} :</label><span>{{ $detail->email }}</span>
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.phone') }} :</label><span>{{ $detail->phone }}</span>
                          </div>
                          <div class="form-group">                        
                              <label>{{ trans('labels.dateFrom') }} :</label><span>{{ $detail->dateFrom }}</span>
                          </div>
                          <div class="form-group">
                              
                              <label>{{ trans('labels.dateTo') }} :</label><span>{{ $detail->dateTo }}</span>
                          </div>
                          @if($detail->nationality != '' AND $detail->nationality > 0)
                            <?php @$nationalitys = DB::table('countries')->where('countries_id',@$detail->nationality)->first(); ?>
                          @endif
                          <div class="form-group">
                              <label>{{ trans('labels.Country') }} :</label><span>{{ $nationalitys->countries_name }}</span>
                          </div>
                         <!--  <div class="form-group">
                              <label>Status :</label>
                              <span>Pendig</span>
                          </div> -->
                      </div>
                      <div class="col-md-6">
                          <div class="car-details-content">
                              <!--Thumbnail slider container--> 
                              <div class="thumbnail-slider-container"> 
                                 <div class="lcnc-imgs">
                                  <h3>License</h3> 
                                    @forelse($licence as $ln) 
                                        @if(file_exists(public_path().'/driverLicense/'.$ln->license))
                                        <div class="lcnc-imgs-img"> 
                                          <img src="{{ url('/public/driverLicense/'.$ln->license) }}" alt="JSOFT"> 
                                         
                                        </div> 
                                        @endif
                                    @empty
                                    @endforelse
                                     
                                 </div> 
                              </div>
                              <div class="thumbnail-slider-container"> 
                                 <div class="lcnc-imgs">
                                  <h3>Upload Id</h3>    
                                    
                                                                             
                                    @forelse($uploadid as $uid) 
                                        @if(file_exists(public_path().'/uploadId/'.$uid->image))
                                        <div class="lcnc-imgs-img"> 
                                          <img src="{{ url('/public/uploadId/'.$uid->image) }}" alt="JSOFT"> 
                                        </div> 
                                        @endif
                                    @empty
                                    @endforelse
                                       
                                 </div> 
                              </div>
                              <!-- <div class="car-details-info blog-content tert-ert">
                                  <h3>Car</h3>
                                  <p>new add car</p>
                              </div> -->
                          </div>
                      </div>
                    </div>
                    <div class="row">                      
                      <div class="col-md-12">
                        <div class="panel-heading">
                          <div class="form-group">
                              <label>{{ trans('labels.carDetails') }}</label>
                          </div>
                        </div>
                      </div>

                      @if($detail->prop_category != '' AND $detail->prop_category > 0)
                          <?php @$carmodel = DB::table('car_model')->where('id',@$detail->prop_category)->first(); ?>
                      @endif

                      @if($detail->car_brand != '' AND $detail->car_brand > 0)
                          <?php @$carbrand = DB::table('car_brand')->where('id',@$detail->car_brand)->first(); ?>
                      @endif

                       @if($detail->city != '' AND $detail->city > 0)
                         <?php @$city = DB::table('city')->where('id',$detail->city)->first(); ?>         
                      @endif

                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label>{{ trans('labels.carName') }}</label><span>{{ $detail->car_name }}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.year') }}</label><span>{{ $detail->year_of_car }}</span>                                        
                          </div>
                          <div class="form-group">                    
                              <label>{{ trans('labels.carBrand') }}</label><span>{{ $carbrand->name }}</span>
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.carModel') }}</label><span>{{ $carmodel->name }}</span>
                          </div>
                          <div class="form-group">        

                                     
                          <label>{{ trans('labels.city') }}</label><span>@if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</span>
                          </div>
                          <div class="form-group">
                              
                              <label>{{ trans('labels.dailyRentPrice') }}</label><span>{{ $detail->daily_rentprice ? $detail->daily_rentprice : '0' }}</span>
                          </div>
                              
                          <div class="form-group">
                              <label>{{ trans('labels.weeklyRentPrice') }}</label><span>{{ $detail->weekly_rentprice ? $detail->weekly_rentprice : '0' }}</span>
                          </div>
                              
                          <div class="form-group">
                              <label>{{ trans('labels.monthRentPrice') }}</label><span>{{ $detail->month_rentprice ? $detail->month_rentprice : '0' }}</span>
                          </div>
                      </div>
                      <div class="col-md-6 car-tre">
                          <div class="car-main-imgcls owl-carousel owl-theme property-slider7">
                          
                                
                                @forelse($image as $images) 
                                   <div class="item">
                                    @if(file_exists(public_path().'/carImage/'.$images->img_name))
                                      <img src="{{ url('/public/carImage/'.$images->img_name) }}" alt="JSOFT"> 
                                    @else
                                      <img src="{{ url('/public/default-image.jpeg') }}" alt="JSOFT"> 
                                    @endif
                                  </div>
                                @empty
                                 <img src="{{ url('/public/default-image.jpeg') }}" alt="JSOFT"> 
                                @endforelse
                          </div>
                      </div>
                    </div>
                </div>
            </div>
    </div>
</div>


@endsection



