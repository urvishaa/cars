@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
 
?>

<style>
	.pac-container {
        z-index: 10000 !important;
    }
</style>

<script>   

function initMap() {
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDImcjjRxyJMDrtMz3JWOQa2AhHkyq1xng&libraries=places&callback=initMap"
        async defer></script>
 <div id="map" style="display: none;"></div>

<section class="section-padding mycar-list">
	<div class="container">
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
		<div class="section-title mycar-head" style="border-bottom: none;padding: none;margin: none">

          
			<div id="addCar" style="margin: auto;">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 style="color: #0d83a9;">{{ trans('labels.editCar') }}</h4>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="{{ URL::to('/useraddCar') }}" enctype="multipart/form-data">
                          	<input type="hidden" name="userId" value="{{ @$session['userId'] }}">
                          	<input type="hidden" name="userType" value="1">
                          	<input type="hidden" name="id" value="{{ @$myCar->id }}">
                            <div class="row">
                            	<div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.images') }}</label>
	                                  <div class="choose-id">
	                                    <input type="file" class="" name="upload_id[]" multiple="" onchange="uploadId(this)"> 
	                                    <label>{{ trans('labels.uploadImage') }}</label>
	                                  </div>
	                                
	                                  <div class="upload_image upload_id">
	                                  	<?php //echo '<pre>'; print_r($images); die; ?>
	                                  	@if(!empty($images))
		                                  	@foreach($images as $key=>$img)
			                                  	@if(file_exists(public_path('/carImage/'.$img->img_name)))
			                                  	<div class="upload_image id_image" id="removeimage_{{ $img->id }}">
				                                  	<div class="mycar_image" style="float:left">
				                                      <img style="height:100px; width:100px;" src="{{ URL::to('/public/carImage/'.$img->img_name) }}">
				                                      <button type="button" onclick="delete_img('{{ $img->id }}')">x</button>
				                                    </div>
				                                </div>
			                                    @endif
		                                  	@endforeach
		                                @endif
	                                  	
	                                    
	                                  </div>
	                                </div>
	                            </div>
	                           
	                            <input type="hidden" name="pro_type" value="1">

		                        <div class="col-md-6">
		                            <div class="form-group">
		                              	<label>{{ trans('labels.carBrand') }}<span style="color: red">*</span></label>
		                              	<select class="form-control" name="car_brand" required="" onchange="filterCategory(this.value)">
		                                    <option value="">{{ trans('labels.carBrand') }}</option>
		                                      @forelse($carBrand as $brands) 
		                                            <option value="{{ $brands->id }}" @if($brands->id == $myCar->car_brand)  {{ "selected='selected'"}} @endif>
		                                            @if(isset($session['language']) AND $session['language']=='en') {{ $brands->name }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $brands->ku }} @else {{ $brands->ar }} @endif</option>
		                                      @empty    
		                                      @endforelse 
		                                </select> 
		                            </div>
		                        </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.carCategory') }}<span style="color: red">*</span></label>
	                                  	<select class="form-control" name="prop_category" required="" id="filterCategorys" >
		                                    <option value="">{{ trans('labels.selectCategoryType') }}</option>
			                                @foreach($carModels as $carModel) 
												
													<option value="{{ $carModel->id }}"  @if($carModel->id == $myCar->prop_category)  {{'selected'}}  @endif >
												@if(isset($session['language']) AND $session['language']=='en') {{ $carModel->name }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $carModel->ku }} @else {{ $carModel->ar }} @endif</option>
		                                    @endforeach


	                                    </select> 
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.yearOfCar') }}<span style="color: red">*</span></label>
	                                  	<select class="form-control" name="year_of_car"  id="year_of_car">
		                                    <option value="">{{ trans('labels.selectCategoryType') }}</option>
												
											@foreach($years as $year)
												<option value="{{ $year->year }}" @if($year->year == $myCar->year_of_car) selected @endif>{{ $year->year }}</option>
											@endforeach
				                                  
	                                    </select> 
	                                </div>
	                            </div>

	                            <div class="col-md-6">
		                            <div class="form-group">
	                                  	<label>{{ trans('labels.name') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="car_name" value="{{ @$myCar->car_name }}" required="">
	                                </div>
		                        </div>
		                        
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.kilometerUsed') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" required="" name="kilometer" value="{{ @$myCar->kilometer }}">
	                                </div>
	                            </div>
	                         
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.fuelType') }}<span style="color: red">*</span></label>
	                                    <select class="form-control" name="fueltype" required="">
	                                     <option value="">{{ trans('labels.selectfuelType') }}</option>
                                      

                                        @forelse($fueltype as $ft) 
                                        <option value="{{ $ft->id }}" @if($ft->id == $myCar->fueltype)  {{ "selected='selected'"}} @endif>
                                        @if(isset($session['language']) AND $session['language']=='en') {{ $ft->name }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $ft->ku }} @else {{ $ft->ar }} @endif</option>
	                                    @empty    
	                                    @endforelse           
	                                    </select>                                                          
	                                </div>
	                            </div>
	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.gear_type') }}<span style="color: red">*</span></label>
	                                    <select class="form-control" name="gear_type" required="">
	                                      <option value="Automatic" @if($myCar->gear_type == "Automatic")  {{ "selected='selected'"}} @endif>{{ trans('labels.Automatic') }}</option>
	                                      <option value="Manual" @if($myCar->gear_type == "Manual")  {{ "selected='selected'"}} @endif>{{ trans('labels.Manual') }}</option>
	                                     
	                                    </select>                                                          
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label for="pwd">{{ trans('labels.description') }}<span style="color: red">*</span></label>
	                                  <textarea class="form-control" name="description" required="">{{ @$myCar->description }}</textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.city') }}<span style="color: red">*</span></label>
	                                    <select class="form-control" name="city" required="">
	                                     <option value="">{{ trans('labels.selectCity') }}</option>
	                                      @forelse($citys as $city) 
	                                            <option value="{{ $city->id }}" @if($city->id==$myCar->city)  {{ "selected='selected'"}} @endif> @if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
	                                      @empty    
	                                      @endforelse
	                                    </select>                                                          
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.location') }}<span style="color: red">*</span></label>
	                                  	<input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="{{ trans('labels.chooseLocation') }}" data-parsley-required="true" required="" value="{{ @$myCar->googleLocation }}" />
	                                  	<input type="hidden" name="lat"  id="lat" value="{{ @$myCar->lat }}">
	          							<input type="hidden" name="lng"  id="lng" value="{{ @$myCar->lng }}">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.email') }}<span style="color: red">*</span></label>
	                                  	<input type="email" class="form-control" name="email" value="{{ @$myCar->email }}" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.Phone') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="phone" value="{{ @$myCar->phone }}" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.price') }}</label>
	                                  	<input type="text" class="form-control" name="price" value="@if(@$myCar->sale_price != '') {{ $myCar->sale_price }} @elseif(@$myCar->month_rentprice != '') {{ $myCar->month_rentprice }} @endif">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.video') }}</label>
	                                  	<input type="url" class="form-control" name="video" value="{{ @$myCar->video }}">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                            		<label>{{ trans('labels.published') }}<span style="color: red">*</span></label>
	                            		<div class="rdo-grp">
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" checked="" value="1" @if($myCar->published == 1) checked="checked" @endif>
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label>{{ trans('labels.publish') }}</label>
	                            			</div>
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" value="2" @if($myCar->published == 2	) checked="checked" @endif>
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label>{{ trans('labels.unpublish') }}</label>
	                            			</div>
	                            		</div>
	                            	</div>
	                            </div>

	                            </div>
	                            <div class="modal-footer">
	                              <button type="submit" class="btn btn-default">{{ trans('labels.save') }}</button>
	                              <a class="btn btn-defualt" href="{{ url('/myCar') }}">{{ trans('labels.cancel') }}</a>
	                            </div>
	                          </form>
	                      </div>
                    	</div>
                  </div>
             </div>
        </div>
       
	</div>

</section>

<script type="text/javascript">
  $(document).ready(function(){

    // $(".upload_id").empty();
  });

    function uploadId(input){
      loadFile2('.upload_id',input)
    }
 
  function loadFile2(id,input) {
	  var myCar = "myCar";
      if (input.files && input.files[0]) {
          var files = input.files.length;
          for (i = 0; i < files; i++) {
              var reader = new FileReader();
			  var j=0;
              reader.onload = function (e) {
                  $('<div class="upload_image id_image" ><div class="mycar_image" style="float:left"><img style="height:100px; width:100px;" id="output2" src=' + e.target.result +'>'+
                  '<button onclick="removeImageClass(this,'+j+',\''+myCar+'\')" >x</button></div></div>').appendTo(id);
					j++;
                }
              reader.readAsDataURL(input.files[i]);
          }
      }
  }          
  function removeImageClass(obj,number,name){          
    $(obj).closest("div").remove();
	jQuery.ajax({
		type: "GET",
		url: '{{route("contactAgentImage.delete")}}',
		data: {'number':number,'name':name},
		success: function(res){
		}
	});
  }

  function delete_img(del_id)
	{
		
	    //alert(del_id); return false;
	    $.ajax({
	        type: "POST",
	        url: "{{ url('myCar_edit/delete_img') }}",
	        data: {del_id:del_id},
	        
	        success: function(data){
	        if(data == "1"){

	        $('#removeimage_'+del_id).css('display','none');;
	        }


	        }
	    });

	}
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
					
</script>
@endsection