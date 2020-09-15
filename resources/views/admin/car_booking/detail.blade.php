@extends('layouts.app')

@section('content')
<?php 
    $firstName = $carBooking->firstName ? $carBooking->firstName : '';
    $lastName = $carBooking->lastName ? $carBooking->lastName : '';
    $email = $carBooking->email ? $carBooking->email : '';
    $phone = $carBooking->phone ? $carBooking->phone : '';
    $dateFrom = $carBooking->dateFrom ? $carBooking->dateFrom : '';
    $dateTo = $carBooking->dateTo ? $carBooking->dateTo : '';
    
    $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
    $carName = $carObj ? $carObj->car_name : ''; 
    $countryObj = $carBooking->hasOneCountry ? $carBooking->hasOneCountry : '';
    $countryName = $countryObj ? $countryObj->countries_name : '';
?>



<div class="panel panel-default carbookcls">
    <div class="panel-body">
        <div id="car-list-area" class="section-padding">
        
            @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session()->get('message') }}
            </div>
            @endif
            
            @if(session()->has('errorMessage'))
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session()->get('errorMessage') }}
                </div>
            @endif
            <div class="box-header-main" style="box-shadow: none;"><h3 class="page-title">{{ trans('labels.orderDetails') }}</h3>    
                <p><a href="{{ route('carBooking.list')}}" class="btn btn-success">{{ trans('labels.cancel') }}</a>
                </div>
            
            
            <div class="bookcarcls">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Car List Content Start -->
                        <div class="col-md-6 car-detl-cls">
                            <div class="form-group">
                                <label>{{ trans('labels.name') }} :</label><span>{{$firstName}}</span>                                        
                            </div>
                            <div class="form-group">                    
                                <label>{{ trans('labels.email') }} :</label><span>{{$email}}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('labels.phone') }} :</label><span>{{$phone}}</span>
                            </div>
                            <div class="form-group">                        
                                <label>{{ trans('labels.dateFrom') }} :</label><span>{{$dateFrom}}</span>
                            </div>
                            <div class="form-group">
                                
                                <label>{{ trans('labels.dateTo') }} :</label><span>{{$dateTo}}</span>
                            </div>
                                
                            <div class="form-group">
                                <label>{{ trans('labels.car') }} :</label><span>{{$carName}}</span>
                            </div>
                                
                            <div class="form-group">
                                <label>{{ trans('labels.Country') }} :</label><span>{{$countryName}}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('labels.status') }} :</label>
                                <select name="status" id="" class="select2 form-control" onchange="changeStatus('{{route("rentalCar.status",['id'=>$carBooking->id])}}',this.value)">
                                    <option value="">--{{ trans('labels.orderStatus') }}--</option>
                                    <option value="Pending" @if($carBooking->status == 'Pending')selected @endif>{{ trans('labels.Pending') }}</option>
                                    <option value="Accepted" @if($carBooking->status == 'Accepted') selected @endif>{{ trans('labels.Accepted') }}</option>
                                    <option value="Deliver It" @if($carBooking->status == 'Deliver It') selected @endif>{{ trans('labels.Deliver It') }}</option>
                                    <option value="Rejected" @if($carBooking->status =='Rejected') selected='selected'@endif>{{ trans('labels.rejected') }}</option>                                                                                                              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="car-details-content">
                                <!--Thumbnail slider container--> 
                                <div class="thumbnail-slider-container"> 
                                   <div class="lcnc-imgs">
                                    <h3>License</h3>    
                                    <?php 
                                        $licenseObj = $carBooking->hasManyLicense ? $carBooking->hasManyLicense : '';                 
                                        if(count($licenseObj)){
                                            foreach($licenseObj as $license){
                                               $licenseImage = $license->license ? $license->license : '';
                                        ?>
                                                <div class="lcnc-imgs-img"> 
                                                    <img src="{{ url('/public/driverLicense/'.$licenseImage)}}" width="100px" height="100px" alt='JSOFT'> 
                                                </div> 
                                      <?php } 
                                       }
                                    ?> 
                                   </div> 
                                </div>
                                <div class="thumbnail-slider-container"> 
                                   <div class="lcnc-imgs">
                                    <h3>Upload Id</h3>    
                                      
                                   <?php 
                                        $uploadObj = $carBooking->hasManyUploadId ? $carBooking->hasManyUploadId : '';

                                        if(count($uploadObj)){
                                            foreach($uploadObj as $uploadImage){ 
                                            $uploadImg = $uploadImage->image ? $uploadImage->image : '';
                                                ?>
                                            <div class="lcnc-imgs-img"> 
                                            <img src="{{ url('/public/uploadId/'.$uploadImg)}}" width="100px" height="100px" alt='JSOFT'> 
                                            </div> 
                                        <?php } 
                                        }?> 
                                   </div> 
                                </div>
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
                      <?php 
                        $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
                        $carName = $carObj ? $carObj->car_name : '';
                        $yearOfCar = $carObj ? $carObj->year_of_car : '';
                        $monthRentPrice = $carObj ? $carObj->month_rentprice : 0;
                        $dailyRentPrice = $carObj ? $carObj->daily_rentprice : 0;
                        $weeklyRentPrice = $carObj ? $carObj->weekly_rentprice : 0;
                        $salePrice = $carObj ? $carObj->sale_price : 0;
                        $brandName = $modelName = $cityName = '';
                        if($carObj != ''){
                            // echo count($carObj);exit;
                            $brandObj = $carObj->hasOneCarBrand ? $carObj->hasOneCarBrand : '';
                            $brnadName = $brandObj ? $brandObj->name : '';
                            $modelObj = $carObj->hasOneCarModel ? $carObj->hasOneCarModel : '';
                            $modelName = $modelObj ? $modelObj->name : '';
                            $cityObj = $carObj->hasOneCarCity ? $carObj->hasOneCarCity : '';
                            $cityName = $cityObj ? $cityObj->name : '';
                        }
                        $imageObj = $carObj->hasManyCarImage ? $carObj->hasManyCarImage : '';
                      ?>
                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label>{{ trans('labels.carName') }}</label><span>{{$carName}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.year') }}</label><span>{{$yearOfCar}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.carBrand') }}</label><span>{{$brnadName}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.model') }}</label><span>{{$modelName}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.city') }}</label><span>{{$cityName}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.dailyRentPrice') }}</label><span>{{$dailyRentPrice}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.weeklyRentPrice') }}</label><span>{{$weeklyRentPrice}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.monthRentPrice') }}</label><span>{{$monthRentPrice}}</span>                                        
                          </div>
                          <div class="form-group">
                              <label>{{ trans('labels.salePrice') }}</label><span>{{$salePrice}}</span>                                        
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="car-main-imgcls">
                              <div class="car-det-cls"> 
                              @if(count($imageObj))
                                @if(file_exists(public_path().'/carImage/'))
                                    <img src="{{ url('/public/carImage/'.$imageObj[0]->img_name) }}" alt="JSOFT"> 
                                @else
                                    <img src="{{ url('/public/default-image.jpeg') }}" alt="JSOFT"> 
                                @endif
                            @endif
                              </div>
                          </div>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>    
</div>



    <script type="text/javascript">    
    function changeStatus(urls,status){
     
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : status},
            success: function(res){
            }
        });
    }
</script>
@endsection