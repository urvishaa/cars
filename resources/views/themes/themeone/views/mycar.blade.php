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
		<div class="section-title mycar-head">

           	<div class="show-ret"> 
              	<h2>@if(!empty($name)) {{ $name['name'] }} {{ $name['lname'] }} @endif</h2>
           	</div>
           	<div class="mycar-head-rght">
           		<button class="addcarbtn" data-toggle="modal" data-target="#addCar">{{ trans('labels.addCar') }}</button>
           	</div>
			<div id="addCar" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 style="color: #0d83a9;">{{ trans('labels.addCar') }}</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="{{ URL::to('/useraddCar') }}" enctype="multipart/form-data">
                          	<input type="hidden" name="userId" value="{{ @$session['userId'] }}">
                          	<input type="hidden" name="userType" value="1">
                            <div class="row">
                            	<div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.images') }}</label>
	                                  <div class="choose-id">
	                                    <input type="file" class="" name="upload_id[]" multiple="" required="" onchange="uploadId(this)"> 
	                                    <label>{{ trans('labels.uploadImage') }}</label>
	                                  </div>
	                                
	                                  <div class="upload_image upload_id">
	                                   
	                                    
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
		                                            <option value="{{ $brands->id }}">
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

	                                    </select> 
	                                </div>
	                            </div>

	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.yearOfCar') }}<span style="color: red">*</span></label>
	                                  	<select class="form-control" name="year_of_car" id="year_of_car">
		                                    <option value="">{{ trans('labels.selectCategoryType') }}</option>
											@foreach($years as $year)
												<option value="{{ $year->year }}" >{{ $year->year }}</option>
											@endforeach
	                                    </select> 
	                                </div>
	                            </div>


	                            <div class="col-md-6">
		                            <div class="form-group">
	                                  	<label>{{ trans('labels.name') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="car_name" required="">
	                                </div>
		                        </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.kilometerUsed') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="kilometer" required="">
	                                </div>
	                            </div>
	                      
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.fuelType') }}<span style="color: red">*</span></label>
	                                    <select class="form-control" name="fueltype" required="">
	                                     <option value="">{{ trans('labels.selectfuelType') }}</option>
                                      

                                        @forelse($fueltype as $ft) 
                                        <option value="{{ $ft->id }}" >
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
	                                      <option value="Automatic">{{ trans('labels.Automatic') }}</option>
	                                      <option value="Manual">{{ trans('labels.Manual') }}</option>
	                                     
	                                    </select>                                                          
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label for="pwd">{{ trans('labels.description') }}<span style="color: red">*</span></label>
	                                  <textarea class="form-control" name="description" required=""></textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label>{{ trans('labels.city') }}<span style="color: red">*</span></label>
	                                    <select class="form-control" name="city" required="">
	                                     <option value="">{{ trans('labels.selectCity') }}</option>
	                                      @forelse($citys as $city) 
	                                            <option value="{{ $city->id }}"> @if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
	                                      @empty    
	                                      @endforelse
	                                    </select>                                                          
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.location') }}</label>
	                                  	<input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="{{ trans('labels.chooseLocation') }}" data-parsley-required="true" required="" value="" />
	                                  	<input type="hidden" name="lat" value="" id="lat">
	          							<input type="hidden" name="lng" value="" id="lng">
	                                </div>
	                            </div>
	                           
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.email') }}<span style="color: red">*</span></label>
	                                  	<input type="email" class="form-control" name="email" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.Phone') }}<span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="phone" required="">
	                                </div>
	                            </div>
	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.price') }}</label>
	                                  	<input type="text" class="form-control" name="price">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label>{{ trans('labels.video') }}</label>
	                                  	<input type="url" class="form-control" name="video">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                            		<label>{{ trans('labels.published') }}<span style="color: red">*</span></label>
	                            		<div class="rdo-grp">
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" checked="" value="1">
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label>{{ trans('labels.publish') }}</label>
	                            			</div>
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" value="2">
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
	                            </div>
	                          </form>
	                      </div>
                    	</div>
                  </div>
             </div>
        </div>
        <div class="row">

        	@forelse($myCar as $myCars)
        	<?php @$modelName = DB::table('car_model')->where('id',$myCars->prop_category)->first(); ?>
            <div class="col-md-4">
            	<div class="single-popular-car">
                    <div class="p-car-thumbnails">
                    	<?php @$image = DB::table('car_img')->where('car_id',$myCars->id)->first(); ?>
                    	@if(file_exists(public_path().'/carImage/'.@$image->img_name) AND @$image->img_name != '')
                             <img src="{{ URL::to('/public/carImage/'.@$image->img_name) }}">                              
                      	@else 
                              <img src="{{ URL::to('/public/default-image.jpeg') }}" >                                 
                      	@endif
                    	<a class="edit-my" href="{{ URL::to('/myCar_edit/'.base64_encode($myCars->id)) }}">Edit</a>

                    	 @if($myCars->pro_type != '')     
                            <div class="list-rest">
                                <a href="javascript:void(0)">
		                    	@if($myCars->pro_type == '1') 
	                              {{ trans('labels.forsale') }}
	                          	@elseif($myCars->pro_type == '2')
	                              {{ trans('labels.forrent') }}
		                        @endif
	                    		</a>
	                    	</div>
	                    @endif
                    </div>

                    <div class="p-car-content">
                        <h3>
                            <a href="{{ URL::to('/car_Detail/'.$myCars->id) }}">{{ @$myCars->car_name }}</a>
                           	@if($myCars->pro_type == '1') 
                              @if($myCars->sale_price !='')<span class="price">${{ @$myCars->sale_price }}</span>@endif
                          	@elseif($myCars->pro_type == '2')
                              @if($myCars->month_rentprice !='')<span class="price">${{ @$myCars->month_rentprice }}</span>@endif
                          	@endif
                        </h3>

                        <h5><i class="fas fa-map-marker-alt"></i> {{ $myCars->googleLocation }}</h5>

                        <div class="p-car-feature">
                            @if($myCars->year_of_car !='')<a href="javascript:void(0)">{{ $myCars->year_of_car }}</a>@endif
                            @if($myCars->gear_type == 'Automatic')<a href="javascript:void(0)">{{ trans('labels.Automatic') }}</a>@elseif($myCars->gear_type == 'Manual')<a href="javascript:void(0)">{{ trans('labels.Manual') }}</a>@endif
                            @if(!isset($session['language']) && $session['language'] == 'en')
                              <a href="javascript:void(0)">{{ $modelName->name }}</a>
                            @elseif(!isset($session['language']) && $session['language'] == 'ku')
                              <a href="javascript:void(0)">{{ $modelName->ku }}</a>
                            @elseif(!isset($session['language']) && $session['language'] == 'ar')
                              <a href="javascript:void(0)">{{ $modelName->ar }}</a>
                            @elseif(!($session['language']))
                             <a href="javascript:void(0)">{{ $modelName->ar }}</a>
                            @endif

                           

                        </div>
                    </div>
                    @if($myCars->published == 1)
		                <div class="publish grren_p">
				        	<a href="javascript:void(0)">{{ trans('labels.published') }}</a>
				        </div>
			        @else
				        <div class="publish grren_p" style="background: #ca0000">
				        	<a href="javascript:void(0)">{{ trans('labels.unpublished') }}</a>
				        </div>
				    @endif
                </div> 
            </div>

            @empty
            <label style="margin: auto;">{{ trans('labels.noResultFound') }}</label>
            @endforelse

            @if(count($myCar))
            {{ $myCar->links('vendor.pagination.default') }}
            @endif
          
            

        </div>
	</div>
</section>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".upload_id").empty();
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
    
    </script>
@endsection