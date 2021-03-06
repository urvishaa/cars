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
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat:{{$property->lat}}, lng: {{$property->lng}}},
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
    position: {lat: {{$property->lat}}, lng: {{$property->lng}}},
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



<h3 class="page-title">{{ trans('labels.editProperty') }}</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/car/'.$property->id) }}" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/car') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{ method_field('PUT') }}
                    {!! csrf_field() !!}

    
                <?php //echo "<pre>"; print_r($property); die; ?>
                  <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="usertype">{{ trans('labels.userType') }} <span class="clsred">*</span></label>
                                  <select name="userType" id="usertype" class="field"  autofocus required>
                                      <option value="">{{ trans('labels.selectUserType') }}</option>
                                      <option value="1" <?php if($property->userType == 1) { echo 'selected'; } ?>>{{ trans('labels.users') }}</option>                          
                                      <option value="2" <?php if($property->userType == 2) { echo 'selected'; } ?>>{{ trans('labels.showRoomAdmin') }}</option>                          
                                  </select>
                          </div>

                          <div class="form-group" id="usershide" style="display: none">
                              <label for="userId">{{ trans('labels.users') }} <span class="clsred">*</span></label>
                                  <select name="userId" id="userId" class="field" >
                                       <option value="">{{ trans('labels.selectUser') }}</option>
                                          @forelse($users as $user) 
                                                <option @if($property->userId == $user->id) selected="" @endif value="{{ $user->id }}">{{ $user->name }}</option>                          
                                          @empty    
                                          @endforelse  
                                      
                                  </select>
                          </div>

                          <div class="form-group" id="ShowRoomAdminhide" style="display: none">
                              <label for="showRoomId">{{ trans('labels.showRoomAdmin') }} <span class="clsred">*</span></label>
                                  <select name="showRoomId" id="showRoomId" class="field">
                                       <option value="">{{ trans('labels.selectShowRoomAdmin') }}</option>
                                          @forelse($ShowRoomAdmin as $ShowRoom) 
                                                <option @if($property->showRoomId == $ShowRoom->myid) selected="" @endif value="{{ $ShowRoom->myid }}">{{ $ShowRoom->first_name }} {{ $ShowRoom->last_name }}</option>                          
                                          @empty    
                                          @endforelse  
                                      
                                  </select>
                          </div>

                          <div class="form-group">
                              <label for="pro_type">{{ trans('labels.propertyType') }} <span class="clsred">*</span></label>
                                  <select name="pro_type" id="pro_type" class="field"  autofocus required>
                                       <option value="">{{ trans('labels.selectPropertyType') }}</option>
                                          @forelse($property_type as $pro_type) 
                                                <option value="{{ $pro_type->id }}" {{ $property->pro_type ==  $pro_type->id ? 'selected="selected"' : '' }} >{{ $pro_type->name }}</option>                          
                                          @empty    
                                          @endforelse  
                                      
                                  </select>
                          </div>    
                          <?php $var = explode(',', $property->prop_category); ?>
                          <div class="form-group">
                            <label for="prop_category">{{ trans('labels.propertyCategory') }} <span class="clsred">*</span></label>
                            <select class="field select2" name="prop_category[]" autofocus required id="prop_category" multiple="multiple" data-placeholder="{{ trans('labels.selectCategoryType') }}">
                                @forelse($property_category as $pro_cat) 
                                    <option value="{{ $pro_cat->id }}" @if(in_array($pro_cat->id, $var)) {{ 'selected="selected"' }} @endif >{{ $pro_cat->name }}</option>
                                  
                                @empty    
                                @endforelse  
                            </select>
                          </div>


                          <div class="form-group">
                              <label for="property_name">{{ trans('labels.propertyName') }} <span class="clsred">*</span></label>
                              <input type="text" name="property_name" value="{{ $property->property_name }}" class="form-control" required autofocus>
                          </div>
                          <div class="form-group">
                              <label for="address">{{ trans('labels.address') }} <span class="clsred">*</span></label>        
                              <textarea name="address" id="address" value="" class="form-control" required autofocus>{{ $property->address }}</textarea>
                          </div>

                           <div class="form-group">
                              <label for="description">{{ trans('labels.description') }} <span class="clsred">*</span></label>        
                              <textarea name="description" id="description" value="" class="form-control" required autofocus>{{ $property->description }}</textarea>
                          </div>



                          <div class="form-group">
                              <label for="sale_price">{{ trans('labels.salePrice') }} <span class="clsred">*</span></label>        
                              <input type="text" name="sale_price" value="{{ $property->sale_price }}" class="form-control" required autofocus>    
                          </div>
                          <div class="form-group">
                              <label for="month_rentprice">{{ trans('labels.monthRentPrice') }} <span class="clsred">*</span></label>        
                              <input type="text" name="month_rentprice" value="{{ $property->month_rentprice }}" class="form-control" required autofocus>    
                          </div>   

                          <div class="form-group">
                              <label for="email">{{ trans('labels.email') }} <span class="clsred">*</span></label>
                              <input type="email" name="email" value="{{ $property->email }}"class="form-control" required autofocus>
                          </div>    

                          <div class="form-group">
                              <label for="phone">{{ trans('labels.phone') }} <span class="clsred">*</span></label>
                              <input type="text" name="phone" value="{{ $property->phone }}" class="form-control" required autofocus>
                          </div>       

                          <div class="form-group">
                            <label for="area">{{ trans('labels.location') }}<span class="clsred">*</span></label>
                          
                              <input class="form-control" type="text"  id="pac-input"  name="googleLocation" placeholder="{{ trans('labels.chooseLocation') }}" data-parsley-required="true" required="" value="<?php echo @$property->googleLocation;?>" />
                          </div>

                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" @if(isset($property->published)) {{ old('published',$property->published)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($property->published)) {{ old('published',$property->published)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>

                        <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$property->lat;?>" />
                        <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$property->lng;?>" />
             

                          <div class="form-group">
                              <label>{{ trans('labels.images') }}</label>
                              <div class="form-group">
                                <?php 
                                if (isset($property_name)) {
                                    foreach ($property_name as $key => $proImg) {
                                       ///$show_img = date('Ymd') . "." . $proImg->img_name;
                                 ?>
                                  <input type="hidden" class="form-control" name="image[]" id="image" value="@if(isset($proImg->img_name)){{ $proImg->img_name }} @endif">
                                  <input type="hidden" class="form-control" name="image_id[]" id="image_id" value="@if(isset($proImg->id)){{ $proImg->id }} @endif">
                                    <div class="col-md-3"><img src="@if(isset($proImg->img_name)){{ url('/public/propertyImage/'.$proImg->img_name ) }} @endif" class="btn popup_image" height="100px" width="100px"/>
                                        <?php $proid = $proImg->id; ?>
                                    <div class="form-group"><input type="button" class="btn btn-danger" name="" onclick="delete_img(<?php echo $proid ?>)" value="{{ trans('labels.delete') }}"></div></div>
                                <?php } 
                                }   ?>
                                    <div id="add_img"></div>
                                    <div class="form-group"><input type="button" onclick="add_new_img()" value="{{ trans('labels.addNewImage') }}"></div>
                              </div>
                          </div>                              
                          
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

    $( document ).ready(function() {

        var usertype = $('#usertype').val();
        if (usertype == 1) {
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
        } else {
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
        }

        $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
    });  


    $('#usertype').on('change',function() {
      var usertype = $('#usertype').val();
        if (usertype == 1) {
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
        } else {
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
        }
    });


    function add_new_img()
    {
        jQuery('#add_img').append('<div class="col-md-3"><div class="form-group"><input type="file" name="image[]" id="image" accept="image/x-png,image/jpeg"></div></div>');
    }

    function delete_img(del_id)
    {
        //alert(del_id);
        $.ajax({
            type: "POST",
            url: "{{ url('admin/car/delete_img') }}",
            data: {del_id:del_id},
            
            success: function(result){
                location.reload();
            }
        });

    }
</script>




@endsection

