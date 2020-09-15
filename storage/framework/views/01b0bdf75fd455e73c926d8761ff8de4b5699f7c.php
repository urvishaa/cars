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
		<div class="section-title mycar-head" style="border-bottom: none;padding: none;margin: none">

          
			<div id="addCar" style="margin: auto;">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 style="color: #0d83a9;"><?php echo e(trans('labels.editCar')); ?></h4>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="<?php echo e(URL::to('/useraddCar')); ?>" enctype="multipart/form-data">
                          	<input type="hidden" name="userId" value="<?php echo e(@$session['userId']); ?>">
                          	<input type="hidden" name="userType" value="1">
                          	<input type="hidden" name="id" value="<?php echo e(@$myCar->id); ?>">
                            <div class="row">
                            	<div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.images')); ?></label>
	                                  <div class="choose-id">
	                                    <input type="file" class="" name="upload_id[]" multiple="" onchange="uploadId(this)"> 
	                                    <label><?php echo e(trans('labels.uploadImage')); ?></label>
	                                  </div>
	                                
	                                  <div class="upload_image upload_id">
	                                  	<?php //echo '<pre>'; print_r($images); die; ?>
	                                  	<?php if(!empty($images)): ?>
		                                  	<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                                  	<?php if(file_exists(public_path('/carImage/'.$img->img_name))): ?>
			                                  	<div class="upload_image id_image" id="removeimage_<?php echo e($img->id); ?>">
				                                  	<div class="mycar_image" style="float:left">
				                                      <img style="height:100px; width:100px;" src="<?php echo e(URL::to('/public/carImage/'.$img->img_name)); ?>">
				                                      <button type="button" onclick="delete_img('<?php echo e($img->id); ?>')">x</button>
				                                    </div>
				                                </div>
			                                    <?php endif; ?>
		                                  	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                <?php endif; ?>
	                                  	
	                                    
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
		                                            <option value="<?php echo e($brands->id); ?>" <?php if($brands->id == $myCar->car_brand): ?>  <?php echo e("selected='selected'"); ?> <?php endif; ?>>
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
			                                <?php $__currentLoopData = $carModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
												
													<option value="<?php echo e($carModel->id); ?>"  <?php if($carModel->id == $myCar->prop_category): ?>  <?php echo e('selected'); ?>  <?php endif; ?> >
												<?php if(isset($session['language']) AND $session['language']=='en'): ?> <?php echo e($carModel->name); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($carModel->ku); ?> <?php else: ?> <?php echo e($carModel->ar); ?> <?php endif; ?></option>
		                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


	                                    </select> 
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.yearOfCar')); ?><span style="color: red">*</span></label>
	                                  	<select class="form-control" name="year_of_car"  id="year_of_car">
		                                    <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
												
											<?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($year->year); ?>" <?php if($year->year == $myCar->year_of_car): ?> selected <?php endif; ?>><?php echo e($year->year); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				                                  
	                                    </select> 
	                                </div>
	                            </div>

	                            <div class="col-md-6">
		                            <div class="form-group">
	                                  	<label><?php echo e(trans('labels.name')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="car_name" value="<?php echo e(@$myCar->car_name); ?>" required="">
	                                </div>
		                        </div>
		                        
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.kilometerUsed')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" required="" name="kilometer" value="<?php echo e(@$myCar->kilometer); ?>">
	                                </div>
	                            </div>
	                         
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.fuelType')); ?><span style="color: red">*</span></label>
	                                    <select class="form-control" name="fueltype" required="">
	                                     <option value=""><?php echo e(trans('labels.selectfuelType')); ?></option>
                                      

                                        <?php $__empty_1 = true; $__currentLoopData = $fueltype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                        <option value="<?php echo e($ft->id); ?>" <?php if($ft->id == $myCar->fueltype): ?>  <?php echo e("selected='selected'"); ?> <?php endif; ?>>
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
	                                      <option value="Automatic" <?php if($myCar->gear_type == "Automatic"): ?>  <?php echo e("selected='selected'"); ?> <?php endif; ?>><?php echo e(trans('labels.Automatic')); ?></option>
	                                      <option value="Manual" <?php if($myCar->gear_type == "Manual"): ?>  <?php echo e("selected='selected'"); ?> <?php endif; ?>><?php echo e(trans('labels.Manual')); ?></option>
	                                     
	                                    </select>                                                          
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label for="pwd"><?php echo e(trans('labels.description')); ?><span style="color: red">*</span></label>
	                                  <textarea class="form-control" name="description" required=""><?php echo e(@$myCar->description); ?></textarea>
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  <label><?php echo e(trans('labels.city')); ?><span style="color: red">*</span></label>
	                                    <select class="form-control" name="city" required="">
	                                     <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
	                                      <?php $__empty_1 = true; $__currentLoopData = $citys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
	                                            <option value="<?php echo e($city->id); ?>" <?php if($city->id==$myCar->city): ?>  <?php echo e("selected='selected'"); ?> <?php endif; ?>> <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
	                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
	                                      <?php endif; ?>
	                                    </select>                                                          
	                                </div>
	                            </div>

	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.location')); ?><span style="color: red">*</span></label>
	                                  	<input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="<?php echo e(trans('labels.chooseLocation')); ?>" data-parsley-required="true" required="" value="<?php echo e(@$myCar->googleLocation); ?>" />
	                                  	<input type="hidden" name="lat"  id="lat" value="<?php echo e(@$myCar->lat); ?>">
	          							<input type="hidden" name="lng"  id="lng" value="<?php echo e(@$myCar->lng); ?>">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.email')); ?><span style="color: red">*</span></label>
	                                  	<input type="email" class="form-control" name="email" value="<?php echo e(@$myCar->email); ?>" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.Phone')); ?><span style="color: red">*</span></label>
	                                  	<input type="text" class="form-control" name="phone" value="<?php echo e(@$myCar->phone); ?>" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.price')); ?></label>
	                                  	<input type="text" class="form-control" name="price" value="<?php if(@$myCar->sale_price != ''): ?> <?php echo e($myCar->sale_price); ?> <?php elseif(@$myCar->month_rentprice != ''): ?> <?php echo e($myCar->month_rentprice); ?> <?php endif; ?>">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                  	<label><?php echo e(trans('labels.video')); ?></label>
	                                  	<input type="url" class="form-control" name="video" value="<?php echo e(@$myCar->video); ?>">
	                                </div>
	                            </div>
	                            
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                            		<label><?php echo e(trans('labels.published')); ?><span style="color: red">*</span></label>
	                            		<div class="rdo-grp">
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" checked="" value="1" <?php if($myCar->published == 1): ?> checked="checked" <?php endif; ?>>
	                            					<label><i class="fas fa-circle"></i></label>
	                            				</div>
	                            				<label><?php echo e(trans('labels.publish')); ?></label>
	                            			</div>
	                            			<div class="rdobtnmain">
	                            				<div class="rdobtn">
	                            					<input type="radio" name="published" value="2" <?php if($myCar->published == 2	): ?> checked="checked" <?php endif; ?>>
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
	                              <a class="btn btn-defualt" href="<?php echo e(url('/myCar')); ?>"><?php echo e(trans('labels.cancel')); ?></a>
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
		url: '<?php echo e(route("contactAgentImage.delete")); ?>',
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
	        url: "<?php echo e(url('myCar_edit/delete_img')); ?>",
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
				url: '<?php echo e(route("category.filter")); ?>',
				data: {'id':name},
				success: function(res){
					jQuery("#filterCategorys").html(res);
				}
			});
	}
					
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>