@extends('layouts.app')

@section('content')


<style>
#map {
  height: 50%;
}
#description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}
#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}
</style>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDImcjjRxyJMDrtMz3JWOQa2AhHkyq1xng&libraries=places&callback=initMap"
        async defer></script>

<script>
function initMap() { //alert('hello'); return false;
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat:23.8859, lng:45.0792 },
    zoom: 13
  });
  var card = document.getElementById('pac-card');
  var input = document.getElementById('pac-input');
  var types = document.getElementById('type-selector');
  var strictBounds = document.getElementById('strict-bounds-selector');

  map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  autocomplete.setFields(
      ['address_components', 'geometry', 'icon', 'name']);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

    var marker = new google.maps.Marker({
    position: {lat:23.8859, lng:45.0792},
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
      marker.setPosition(place.geometry.location);
      var myStr=place.geometry.location + '';
      myStr.replace(/\w+[.!?]?$/, '')
      var strArray = myStr.split(",");
      var a = strArray[0].replace('(','');
      var b=strArray[1].replace(')','');
    //   alert(a);
    //   alert(b);
      jQuery('#lat').val(a.trim());
      jQuery('#lng').val(b.trim());

    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindowContent.children['place-icon'].src = place.icon;
    infowindowContent.children['place-name'].textContent = place.name;
    infowindowContent.children['place-address'].textContent = address;
    infowindow.open(map, marker);
  });
}
  </script>
<h3 class="page-title">{{ trans('labels.createCar') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/car') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                       <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/car') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter">      
                    <?php  $admin = auth()->guard('admin')->user();
                        if ($admin['issubadmin'] == 0) { ?>
                          
                          <div class="form-group">
                              <label for="usertype">{{ trans('labels.userType') }} <span class="clsred">*</span></label>
                                  <select name="userType" id="usertype" class="field"  autofocus required>
                                      <option value="">{{ trans('labels.selectUserType') }}</option>
                                      <option value="1">{{ trans('labels.users') }}</option>                          
                                      <option value="2">{{ trans('labels.showRoomAdmin') }}</option> 
                                      <option value="3">{{ trans('labels.rentalCompanies') }}</option>                            
                                  </select>
                          </div>

                          <div class="form-group" id="usershide" style="display: none">
                              <label for="userId">{{ trans('labels.users') }} <span class="clsred">*</span></label>
                                <select name="userId" id="userId" class="field" >
                                    <option value="" disabled="" selected="">{{ trans('labels.selectUser') }}</option>
                                        @forelse($users as $user) 
                                          <option value="{{ $user->id }}">{{ $user->name }}</option>                          
                                        @empty    
                                        @endforelse                                  
                                </select>
                          </div>

                         

                          <div class="form-group" id="ShowRoomAdminhide" style="display: none">
                              <label for="showRoomId">{{ trans('labels.showRoomAdmin') }} <span class="clsred">*</span></label>
                                  <select name="showRoomId" id="showRoomId" class="field">
                                       <option value="" disabled="" selected="">{{ trans('labels.selectShowRoomAdmin') }}</option>
                                          @forelse($ShowRoomAdmin as $ShowRoom) 
                                                <option value="{{ $ShowRoom->myid }}">{{ $ShowRoom->first_name }} {{ $ShowRoom->last_name }}</option>   
                                          @empty    
                                          @endforelse                                  
                                  </select>
                          </div>


                          

                            <div class="form-group" id="CompanyAdminhide" style="display: none">
                              <label for="CompanyId">{{ trans('labels.rentalCompanies') }} <span class="clsred">*</span></label>
                                  <select name="companyId" id="companyId" class="field">
                                       <option value="" disabled="" selected="">{{ trans('labels.rentalCompanies') }}</option>
                                          @forelse($Company as $Com) 
                                                <option value="{{ $Com->myid }}">{{ $Com->first_name }} {{ $Com->last_name }}</option>   
                                          @empty    
                                          @endforelse                                  
                                  </select>
                          </div>
                           <div class="form-group" id="onestep">
                              <label for="pro_type">{{ trans('labels.carType') }} </label>
                                <select name="pro_type" id="pro_type" class="field" onchange="inputPrice(this)">
                                     <option value="" disabled="" selected="">{{ trans('labels.selectCarType') }}</option>
                                        @forelse($car_type as $cars_type) 
                                              <option value="{{ $cars_type->id }}">{{ $cars_type->name }}</option>                          
                                        @empty    
                                        @endforelse                                
                                </select>
                          </div>

                           <div class="form-group" id="twostep" style="display:none;">
                              <label for="pro_type">{{ trans('labels.carType') }} <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                                 
                                      <option value="{{ $car_type[0]->id }}">{{ $car_type[0]->name }}</option>                                     
                                </select>
                          </div>

                          <div class="form-group" id="threestep" style="display:none;">
                              <label for="pro_type">{{ trans('labels.carType') }} <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                               
                                      <option value="{{ $car_type[1]->id }}" >{{ $car_type[1]->name }}</option>                                     
                                </select>
                          </div>

                           <div style="display:none" class="salePrice">
                              <div class="form-group" >
                                  <label for="sale_price">{{ trans('labels.salePrice') }}</label>        
                                  <input type="text" name="sale_price" value="" class="form-control"  >    
                              </div>
                            </div>
                            <div style="display:none" class="rentPrice">
                              <div class="form-group" >
                                  <label for="daily_rentprice">{{ trans('labels.dailyRentPrice') }} </label>        
                                  <input type="text" name="daily_rentprice" value="" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="weekly_rentprice">{{ trans('labels.weeklyRentPrice') }} </label>        
                                  <input type="text" name="weekly_rentprice" value="" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="month_rentprice">{{ trans('labels.monthRentPrice') }} </label>        
                                  <input type="text" name="month_rentprice" value="" class="form-control"  >    
                              </div> 
                            </div>


                           



                            <?php } elseif($admin['issubadmin'] == 4 ){ ?>
                            <input name="userType" value="3" type="hidden">
                            <input name="companyId" value="{{ $admin['myid'] }}" type="hidden">

                            <div class="form-group" id="threestep" >
                              <label for="pro_type">{{ trans('labels.carType') }} <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                               
                                      <option value="{{ $car_type[1]->id }}" >{{ $car_type[1]->name }}</option>                                     
                                </select>
                            </div>

                            <div class="form-group" >
                                  <label for="daily_rentprice">{{ trans('labels.dailyRentPrice') }} </label>        
                                  <input type="text" name="daily_rentprice" value="" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="weekly_rentprice">{{ trans('labels.weeklyRentPrice') }} </label>        
                                  <input type="text" name="weekly_rentprice" value="" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="month_rentprice">{{ trans('labels.monthRentPrice') }} </label>        
                                  <input type="text" name="month_rentprice" value="" class="form-control"  >    
                              </div> 
                          
                            <?php } elseif($admin['issubadmin'] == 2 ) { ?>
                            <input name="userType" value="2" type="hidden">
                            <input name="showRoomId" value="{{ $admin['myid'] }}" type="hidden">

                            <div class="form-group" id="twostep">
                              <label for="pro_type">{{ trans('labels.carType') }} <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                                 
                                      <option value="{{ $car_type[0]->id }}">{{ $car_type[0]->name }}</option>                                     
                                </select>
                            </div>

                            <div class="form-group" >
                              <label for="sale_price">{{ trans('labels.salePrice') }}</label>        
                              <input type="text" name="sale_price" value="" class="form-control"  >    
                            </div>

                            <?php } ?>

                          

                      

                          <div class="form-group">
                            <label for="car_brand">{{ trans('labels.carBrand') }} </label>
                            <select class="field select2" name="car_brand" autofocus id="car_brand" data-placeholder="{{ trans('labels.selectCarBrand') }}" onchange="filterCategory(this.value)">
                                      <option value="">{{ trans('labels.selectCarBrand') }}</option>
                                @forelse($carBrand as $brand) 
                                      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @empty    
                                @endforelse  
                            </select>
                          </div>

               
                          <div class="form-group">
                            <label for="car_category">{{ trans('labels.model') }} </label>
                            <select class="field select2" name="prop_category" autofocus  data-placeholder="{{ trans('labels.selectCategoryType') }}" id="filterCategorys" >
                                      
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="car_brand">{{ trans('labels.yearOfCar') }} </label>
                            <select class="field select2" name="year_of_car" autofocus id="year_of_car" data-placeholder="{{ trans('labels.yearOfCar') }}" >
                            <option value="">Select Year</option>                            
                            @foreach($years as $year)
                              <option value="{{ $year->year }}" >{{ $year->year }}</option>
                            @endforeach
                          </select>
                          </div>

                          <div class="form-group">
                              <label for="car_name">{{ trans('labels.carName') }} <span class="clsred">*</span></label>
                              <input type="text" name="car_name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="kilometer">{{ trans('labels.kilometer') }} <span class="clsred">*</span></label>
                              <input type="text" name="kilometer" value="" class="form-control" required autofocus>
                          </div>

                         


                          <div class="form-group">
                              <label for="fueltype">{{ trans('labels.fuelType') }} <span class="clsred">*</span></label>
                              <select name="fueltype" class="field"  autofocus required>
                                     <option value="">{{ trans('labels.selectfuelType') }}</option>
                                        @forelse($fueltype as $ft) 
                                              <option value="{{ @$ft->id }}">{{ @$ft->name }}</option>                          
                                        @empty    
                                        @endforelse                                
                              </select>
                              <!-- <textarea name="specification" id="specification" value="" class="form-control" required autofocus></textarea> -->
                          </div>
                       
                          <div class="form-group">
                              <label for="address">{{ trans('labels.address') }} <span class="clsred">*</span></label>        
                              <textarea name="address" id="address" value="" class="form-control" required autofocus></textarea>
                          </div>

                          <div class="form-group" >
                              <label for="pro_type">{{ trans('labels.city') }} <span class="clsred">*</span></label>
                                <select name="city" class="field"  autofocus required>
                                     <option value="">{{ trans('labels.selectCity') }}</option>
                                        @forelse($city as $ct) 
                                              <option value="{{ @$ct->id }}">{{ @$ct->name }}</option>                          
                                        @empty    
                                        @endforelse                                
                                </select>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }} <span class="clsred">*</span></label>        
                              <textarea name="description" id="description" value="" class="form-control" required autofocus></textarea>
                          </div>
                
                              

                          <div class="form-group">
                              <label for="email">{{ trans('labels.email') }}</label>
                              <input type="email" name="email" value="" class="form-control" autofocus>
                          </div>    

                          <div class="form-group">
                              <label for="phone">{{ trans('labels.phone') }}</label>
                              <input type="text" name="phone" value="" class="form-control" autofocus>
                          </div>   


                          <div class="form-group" >
                              <label for="video">{{ trans('labels.video') }}</label>        
                              <input type="text" name="video" value="" class="form-control"  >    
                          </div>             

                          <div class="form-group">
                              <label for="name">{{ trans('labels.gear_type') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="gear_type" id="gear_type">
                                <option value="Automatic" >{{ trans('labels.Automatic') }}</option>
                                <option value="Manual" >{{ trans('labels.Manual') }}</option>
                              </select>
                          </div>

                          <div class="form-group">
                            <label for="area"> {{ trans('labels.location') }}<span class="clsred">*</span></label>                    
                              <input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="{{ trans('labels.chooseLocation') }}" data-parsley-required="true" required="" value="" />
                          </div>

                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" >{{ trans('labels.published') }}</option>
                                <option value="2" >{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>

                        <input class="form-control" type="hidden" id="lat" name="lat"  />
                        <input class="form-control" type="hidden" id="lng" name="lng"   />


                          <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <?php if (isset($result['edittemplate']->image)) { ?>
                              <input type="file" name="image" id="image" value="">
                                <input type="hidden" class="form-control" name="oldimage" id="oldimage" value="@if(isset($result['edittemplate']->image)){{ $result['edittemplate']->image }} @endif">
                                  <img src="@if(isset($result['edittemplate']->image)){{ url('/public/templateImage/'.$result['edittemplate']->image) }} @endif" class="btn popup_image" height="100px" width="100px"/>  
                              <?php } else { ?>
                                <input type="file" name="image[]" id="image" required="" value="" accept="image/x-png,image/jpeg">
                              <?php } ?>
                              <input type="button" onclick="add_new_img()" value="{{ trans('labels.addNewImage') }}">
                              
                              <div id="add_img"></div>
                          </div>


                      <script type="text/javascript">
                          function add_new_img()
                          {
                              jQuery('#add_img').append('<div class="form-group"><input type="file" name="image[]" id="image" accept="image/x-png,image/jpeg"></div>');
                          }
                      </script>



                          {{-- <div class="form-group">
                              <label for="dob">Date of Birth</label>                      
                              <input class="date form-control" name="dob" placeholder="select date" value="" type="text">  
                          </div> --}}
        
                      

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/car') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
                        </div>
                      </div>
                </form>
                            
            </div> 
            <div id="map" style="height: 300px"></div>
        </div>


<script type="text/javascript">
function inputPrice(input){
  if(input.value == 1){
    jQuery(".rentPrice").hide();
      jQuery(".salePrice").show();
  }
  else if(input.value == 2){
      jQuery(".rentPrice").show();
      jQuery(".salePrice").hide();
  }
  else if(input.value == ""){
    jQuery(".rentPrice").hide();
      jQuery(".salePrice").hide();
  }
}

    $('#usertype').on('click',function() {
      var usertype = $('#usertype').val();
    

        if (usertype == 1) {
            $('#onestep').css('display','block');
             $('#threestep').css('display','none');
            $('#twostep').css('display','none');
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
            $('#CompanyAdminhide').css('display','none');
             jQuery(".rentPrice").hide();
            jQuery(".salePrice").hide();
            
        } else if (usertype == 2) {
           $('#twostep').css('display','block');
            $('#threestep').css('display','none');
           $('#onestep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','none');
            jQuery(".salePrice").show();
            jQuery(".rentPrice").hide();
        }
        else if (usertype == 3) {
           $('#onestep').css('display','none');
           $('#threestep').css('display','block');
           $('#twostep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','none');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','block');
            jQuery(".rentPrice").show();
            jQuery(".salePrice").hide();
        }
    });


</script>

<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
    function filterCategory(name){
			jQuery("#filterCategorys").empty();
			jQuery.ajax({
				type: "GET",
				url: '{{route("category.filter")}}',
				data: {'id':name},
				success: function(res){
					jQuery("#filterCategorys").html(res);
				}
			});
		}

    // function filterCategory1(name){
    //   jQuery("#year_of_car").empty();
    //   jQuery.ajax({
    //     type: "GET",
    //     url: '{{route("category.filter1")}}',
    //     data: {'id':name},
    //     success: function(res){
    //       jQuery("#year_of_car").html(res);
    //     }
    //   });
    // }

</script> 



@endsection


