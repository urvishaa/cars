<?php $__env->startSection('content'); ?>
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
			 <?php if(session()->has('message')): ?>
			  <div class="alert alert-success" role="alert">
			    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <?php echo e(session()->get('message')); ?>

			  </div>
			  <?php endif; ?>
			   
			  <?php if(session()->has('errorMessage')): ?>
			      <div class="alert alert-danger" role="alert">
			        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			          <?php echo e(session()->get('errorMessage')); ?>

			      </div>
			  <?php endif; ?>
		<div class="section-title mycar-head">

           	<div class="show-ret"> 
              	<h2><?php if(!empty($name)): ?> <?php echo e($name['name']); ?> <?php echo e($name['lname']); ?> <?php endif; ?></h2>
           	</div>
           	<div class="mycar-head-rght">
           		<button class="addcarbtn" data-toggle="modal" data-target="#addCar"><?php echo e(trans('labels.addCar')); ?></button>
           	</div>
			<div id="addCar" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 style="color: #0d83a9;"><?php echo e(trans('labels.addCar')); ?></h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="<?php echo e(URL::to('/useraddCar')); ?>" enctype="multipart/form-data">
                          	<input type="hidden" name="userId" value="<?php echo e(@$session['userId']); ?>">
                          	<input type="hidden" name="userType" value="1">
                            <div class="row">
                            	<div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.images')); ?></label>
	                                  <div class="choose-id">
	                                    <input type="file" class="" name="upload_id[]" multiple="" required="" onchange="uploadId(this)"> 
	                                    <label><?php echo e(trans('labels.uploadImage')); ?></label>
	                                  </div>
	                                
	                                  <div class="upload_image upload_id">
	                                   
	                                    
	                                  </div>
	                                </div>
	                            </div>
	                           
	                              <input type="hidden" name="pro_type" value="1">

		                        <div class="col-md-6">
		                            <div class="form-group">
		                              	<label><?php echo e(trans('labels.carBrand')); ?><span style="color: red">*</span></label>
		                              	<select class="form-control" name="car_brand" required="" onchange="filterCategory(this.value)">
		                                    <option value=""><?php echo e(trans('labels.carBrand')); ?></option>
		                                      <?php $__empty_1 = true; $__currentLoopData = $carBrand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
		                                            <option value="<?php echo e($brands->id); ?>">
		                                            <?php if(isset($session['language']) AND $session['language']=='en'): ?> <?php echo e($brands->name); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($brands->ku); ?> <?php else: ?> <?php echo e($brands->ar); ?> <?php endif; ?></option>
		                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
		                                      <?php endif; ?> 
		                                </select> 
		                            </div>
		                        </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.carCategory')); ?><span style="color: red">*</span></label>
	                                  	<select class="form-control" name="prop_category" required="" id="filterCategorys" >
		                                    <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>

	                                    </select> 
	                                </div>
	                            </div>

	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.yearOfCar')); ?><span style="color: red">*</span></label>
	                                  	<select class="form-control" name="year_of_car" id="year_of_car">
		                                    <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
											<?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($year->year); ?>" ><?php echo e($year->year); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                    </select> 
	                                </div>
	                            </div>


	                            <div class="col-md-6">
		                            <div class="form-group">
	                                  	<label><?php echo e(trans('labels.name')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="car_name" required="">
	                                </div>
		                        </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.kilometerUsed')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="kilometer" required="">
	                                </div>
	                            </div>
	                      
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.fuelType')); ?><span style="color: red">*</span></label>
	                                    <select class="form-control" name="fueltype" required="">
	                                     <option value=""><?php echo e(trans('labels.selectfuelType')); ?></option>
                                      

                                        <?php $__empty_1 = true; $__currentLoopData = $fueltype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                        <option value="<?php echo e($ft->id); ?>" >
                                        <?php if(isset($session['language']) AND $session['language']=='en'): ?> <?php echo e($ft->name); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($ft->ku); ?> <?php else: ?> <?php echo e($ft->ar); ?> <?php endif; ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
	                                    <?php endif; ?>           
	                                    </select>                                                          
	                                </div>
	                            </div>
	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.gear_type')); ?><span style="color: red">*</span></label>
	                                    <select class="form-control" name="gear_type" required="">
	                                      <option value="Automatic"><?php echo e(trans('labels.Automatic')); ?></option>
	                                      <option value="Manual"><?php echo e(trans('labels.Manual')); ?></option>
	                                     
	                                    </select>                                                          
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label for="pwd"><?php echo e(trans('labels.description')); ?><span style="color: red">*</span></label>
	                                  <textarea class="form-control" name="description" required=""></textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.city')); ?><span style="color: red">*</span></label>
	                                    <select class="form-control" name="city" required="">
	                                     <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
	                                      <?php $__empty_1 = true; $__currentLoopData = $citys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
	                                            <option value="<?php echo e($city->id); ?>"> <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
	                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
	                                      <?php endif; ?>
	                                    </select>                                                          
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.location')); ?></label>
	                                  	<input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="<?php echo e(trans('labels.chooseLocation')); ?>" data-parsley-required="true" required="" value="" />
	                                  	<input type="hidden" name="lat" value="" id="lat">
	          							<input type="hidden" name="lng" value="" id="lng">
	                                </div>
	                            </div>
	                           
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.email')); ?><span style="color: red">*</span></label>
	                                  	<input type="email" class="form-control" name="email" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.Phone')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="phone" required="">
	                                </div>
	                            </div>
	                             <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.price')); ?></label>
	                                  	<input type="text" class="form-control" name="price">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.video')); ?></label>
	                                  	<input type="url" class="form-control" name="video">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                            		<label><?php echo e(trans('labels.published')); ?><span style="color: red">*</span></label>
	                            		<div class="rdo-grp">
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" checked="" value="1">
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label><?php echo e(trans('labels.publish')); ?></label>
	                            			</div>
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" value="2">
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label><?php echo e(trans('labels.unpublish')); ?></label>
	                            			</div>
	                            		</div>
	                            	</div>
	                            </div>

	                            </div>
	                            <div class="modal-footer">
	                              <button type="submit" class="btn btn-default"><?php echo e(trans('labels.save')); ?></button>
	                            </div>
	                          </form>
	                      </div>
                    	</div>
                  </div>
             </div>
        </div>
        <div class="row">

        	<?php $__empty_1 = true; $__currentLoopData = $myCar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myCars): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        	<?php @$modelName = DB::table('car_model')->where('id',$myCars->prop_category)->first(); ?>
            <div class="col-md-4">
            	<div class="single-popular-car">
                    <div class="p-car-thumbnails">
                    	<?php @$image = DB::table('car_img')->where('car_id',$myCars->id)->first(); ?>
                    	<?php if(file_exists(public_path().'/carImage/'.@$image->img_name) AND @$image->img_name != ''): ?>
                             <img src="<?php echo e(URL::to('/public/carImage/'.@$image->img_name)); ?>">                              
                      	<?php else: ?> 
                              <img src="<?php echo e(URL::to('/public/default-image.jpeg')); ?>" >                                 
                      	<?php endif; ?>
                    	<a class="edit-my" href="<?php echo e(URL::to('/myCar_edit/'.base64_encode($myCars->id))); ?>">Edit</a>

                    	 <?php if($myCars->pro_type != ''): ?>     
                            <div class="list-rest">
                                <a href="javascript:void(0)">
		                    	<?php if($myCars->pro_type == '1'): ?> 
	                              <?php echo e(trans('labels.forsale')); ?>

	                          	<?php elseif($myCars->pro_type == '2'): ?>
	                              <?php echo e(trans('labels.forrent')); ?>

		                        <?php endif; ?>
	                    		</a>
	                    	</div>
	                    <?php endif; ?>
                    </div>

                    <div class="p-car-content">
                        <h3>
                            <a href="<?php echo e(URL::to('/car_Detail/'.$myCars->id)); ?>"><?php echo e(@$myCars->car_name); ?></a>
                           	<?php if($myCars->pro_type == '1'): ?> 
                              <?php if($myCars->sale_price !=''): ?><span class="price">$<?php echo e(@$myCars->sale_price); ?></span><?php endif; ?>
                          	<?php elseif($myCars->pro_type == '2'): ?>
                              <?php if($myCars->month_rentprice !=''): ?><span class="price">$<?php echo e(@$myCars->month_rentprice); ?></span><?php endif; ?>
                          	<?php endif; ?>
                        </h3>

                        <h5><i class="fas fa-map-marker-alt"></i> <?php echo e($myCars->googleLocation); ?></h5>

                        <div class="p-car-feature">
                            <?php if($myCars->year_of_car !=''): ?><a href="javascript:void(0)"><?php echo e($myCars->year_of_car); ?></a><?php endif; ?>
                            <?php if($myCars->gear_type == 'Automatic'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Automatic')); ?></a><?php elseif($myCars->gear_type == 'Manual'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Manual')); ?></a><?php endif; ?>
                            <?php if(!isset($session['language']) && $session['language'] == 'en'): ?>
                              <a href="javascript:void(0)"><?php echo e($modelName->name); ?></a>
                            <?php elseif(!isset($session['language']) && $session['language'] == 'ku'): ?>
                              <a href="javascript:void(0)"><?php echo e($modelName->ku); ?></a>
                            <?php elseif(!isset($session['language']) && $session['language'] == 'ar'): ?>
                              <a href="javascript:void(0)"><?php echo e($modelName->ar); ?></a>
                            <?php elseif(!($session['language'])): ?>
                             <a href="javascript:void(0)"><?php echo e($modelName->ar); ?></a>
                            <?php endif; ?>

                           

                        </div>
                    </div>
                    <?php if($myCars->published == 1): ?>
		                <div class="publish grren_p">
				        	<a href="javascript:void(0)"><?php echo e(trans('labels.published')); ?></a>
				        </div>
			        <?php else: ?>
				        <div class="publish grren_p" style="background: #ca0000">
				        	<a href="javascript:void(0)"><?php echo e(trans('labels.unpublished')); ?></a>
				        </div>
				    <?php endif; ?>
                </div> 
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <label style="margin: auto;"><?php echo e(trans('labels.noResultFound')); ?></label>
            <?php endif; ?>

            <?php if(count($myCar)): ?>
            <?php echo e($myCar->links('vendor.pagination.default')); ?>

            <?php endif; ?>
          
            

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
				url: '<?php echo e(route("category.filter")); ?>',
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
		url: '<?php echo e(route("contactAgentImage.delete")); ?>',
		data: {'number':number,'name':name},
		success: function(res){
		}
	});
  }
    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>