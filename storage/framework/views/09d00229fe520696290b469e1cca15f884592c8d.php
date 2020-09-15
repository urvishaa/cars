<?php $__env->startSection('content'); ?>


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
<h3 class="page-title"><?php echo e(trans('labels.createProperty')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/car')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                       <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/car')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter">      
                    <?php  $admin = auth()->guard('admin')->user();
                        if ($admin['issubadmin'] == 0) { ?>
                          
                          <div class="form-group">
                              <label for="usertype"><?php echo e(trans('labels.userType')); ?> <span class="clsred">*</span></label>
                                  <select name="userType" id="usertype" class="field"  autofocus required>
                                      <option value=""><?php echo e(trans('labels.selectUserType')); ?></option>
                                      <option value="1"><?php echo e(trans('labels.users')); ?></option>                          
                                      <option value="2"><?php echo e(trans('labels.showRoomAdmin')); ?></option> 
                                      <option value="3"><?php echo e(trans('labels.company')); ?></option>                            
                                  </select>
                          </div>

                          <div class="form-group" id="usershide" style="display: none">
                              <label for="userId"><?php echo e(trans('labels.users')); ?> <span class="clsred">*</span></label>
                                <select name="userId" id="userId" class="field" >
                                    <option value=""><?php echo e(trans('labels.selectUser')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                        <?php endif; ?>                                  
                                </select>
                          </div>

                         

                          <div class="form-group" id="ShowRoomAdminhide" style="display: none">
                              <label for="showRoomId"><?php echo e(trans('labels.showRoomAdmin')); ?> <span class="clsred">*</span></label>
                                  <select name="showRoomId" id="showRoomId" class="field">
                                       <option value=""><?php echo e(trans('labels.selectShowRoomAdmin')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $ShowRoomAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ShowRoom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option value="<?php echo e($ShowRoom->myid); ?>"><?php echo e($ShowRoom->first_name); ?> <?php echo e($ShowRoom->last_name); ?></option>   
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>                                  
                                  </select>
                          </div>


                          

                            <div class="form-group" id="CompanyAdminhide" style="display: none">
                              <label for="CompanyId"><?php echo e(trans('labels.company')); ?> <span class="clsred">*</span></label>
                                  <select name="companyId" id="companyId" class="field">
                                       <option value=""><?php echo e(trans('labels.company')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $Company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option value="<?php echo e($Com->myid); ?>"><?php echo e($Com->first_name); ?> <?php echo e($Com->last_name); ?></option>   
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>                                  
                                  </select>
                          </div>

                            <?php } elseif($admin['issubadmin'] == 4 ){ ?>
                            <input name="userType" value="3" hidden="">
                            <input name="companyId" value="<?php echo e($admin['myid']); ?>" hidden="">
                        
                            <?php } elseif($admin['issubadmin'] == 2 ) { ?>
                            <input name="userType" value="2" hidden="">
                            <input name="showRoomId" value="<?php echo e($admin['myid']); ?>" hidden="">
                            <?php } ?>

                           <div class="form-group" id="twostep" style="display:none;">
                              <label for="pro_type"><?php echo e(trans('labels.propertyType')); ?> <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                                 
                                      <option value="<?php echo e($property_type[0]->id); ?>"><?php echo e($property_type[0]->name); ?></option>                                     
                                </select>
                          </div>

                          <div class="form-group" id="threestep" style="display:none;">
                              <label for="pro_type"><?php echo e(trans('labels.propertyType')); ?> <span class="clsred">*</span></label>
                                <select name="pro_type" id="pro_type" class="field" >                                 
                                      <option value="<?php echo e($property_type[1]->id); ?>"><?php echo e($property_type[1]->name); ?></option>                                     
                                </select>
                          </div>

                        
                            <div class="form-group" id="onestep">
                              <label for="pro_type"><?php echo e(trans('labels.propertyType')); ?> </label>
                                <select name="pro_type" id="pro_type" class="field" onchange="inputPrice(this)">
                                     <option value=""><?php echo e(trans('labels.selectPropertyType')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $property_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                              <option value="<?php echo e($pro_type->id); ?>"><?php echo e($pro_type->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                        <?php endif; ?>                                
                                </select>
                          </div>
                        
                       

                        <div style="display:none" class="salePrice">
                          <div class="form-group" >
                              <label for="sale_price"><?php echo e(trans('labels.salePrice')); ?></label>        
                              <input type="text" name="sale_price" value="" class="form-control"  >    
                          </div>
                        </div>
                        <div style="display:none" class="rentPrice">
                          <div class="form-group" >
                              <label for="daily_rentprice"><?php echo e(trans('labels.dailyRentPrice')); ?> </label>        
                              <input type="text" name="daily_rentprice" value="" class="form-control"  >    
                          </div> 
                          <div class="form-group" >
                              <label for="weekly_rentprice"><?php echo e(trans('labels.weeklyRentPrice')); ?> </label>        
                              <input type="text" name="weekly_rentprice" value="" class="form-control"  >    
                          </div> 
                          <div class="form-group" >
                              <label for="month_rentprice"><?php echo e(trans('labels.monthRentPrice')); ?> </label>        
                              <input type="text" name="month_rentprice" value="" class="form-control"  >    
                          </div> 
                        </div>

                      

                          <div class="form-group">
                            <label for="car_brand"><?php echo e(trans('labels.carBrand')); ?> </label>
                            <select class="field select2" name="car_brand" autofocus id="car_brand" data-placeholder="<?php echo e(trans('labels.selectCarBrand')); ?>" onchange="filterCategory(this.value)">
                                      <option value=""><?php echo e(trans('labels.selectCarBrand')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $carBrand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                          </div>

                          

                         <!--   <div class="form-group">
                              <label for="year_of_car"><?php echo e(trans('labels.yearOfCar')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="" value="" class="form-control" required autofocus>
                          </div> -->
                          
                          


                          <div class="form-group">
                            <label for="prop_category"><?php echo e(trans('labels.propertyCategory')); ?> </label>
                            <select class="field select2" name="prop_category" autofocus  data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>" id="filterCategorys" >
                                      <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="car_brand"><?php echo e(trans('labels.yearOfCar')); ?> </label>
                            <select class="field select2" name="year_of_car" autofocus id="year_of_car" data-placeholder="<?php echo e(trans('labels.yearOfCar')); ?>" >
                            <option value="">Select Year</option>                            
                            <?php for($i = 1948; $i <= date('Y',strtotime('now')); $i++): ?>
                              <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>                            

                            <?php endfor; ?>
                          </select>
                          </div>

                          <div class="form-group">
                              <label for="property_name"><?php echo e(trans('labels.propertyName')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="property_name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="kilometer"><?php echo e(trans('labels.kilometer')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="kilometer" value="" class="form-control" required autofocus>
                          </div>

                         


                          <div class="form-group">
                              <label for="fueltype"><?php echo e(trans('labels.fuelType')); ?> <span class="clsred">*</span></label>
                              <select name="fueltype" class="field"  autofocus required>
                                     <option value=""><?php echo e(trans('labels.selectfuelType')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $fueltype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                              <option value="<?php echo e(@$ft->id); ?>"><?php echo e(@$ft->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                        <?php endif; ?>                                
                              </select>
                              <!-- <textarea name="specification" id="specification" value="" class="form-control" required autofocus></textarea> -->
                          </div>
                       
                          <div class="form-group">
                              <label for="address"><?php echo e(trans('labels.address')); ?> <span class="clsred">*</span></label>        
                              <textarea name="address" id="address" value="" class="form-control" required autofocus></textarea>
                          </div>

                          <div class="form-group" >
                              <label for="pro_type"><?php echo e(trans('labels.city')); ?> <span class="clsred">*</span></label>
                                <select name="city" class="field"  autofocus required>
                                     <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $city; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                              <option value="<?php echo e(@$ct->id); ?>"><?php echo e(@$ct->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                        <?php endif; ?>                                
                                </select>
                          </div>

                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>        
                              <textarea name="description" id="description" value="" class="form-control" required autofocus></textarea>
                          </div>
                
                              

                          <div class="form-group">
                              <label for="email"><?php echo e(trans('labels.email')); ?></label>
                              <input type="email" name="email" value="" class="form-control" autofocus>
                          </div>    

                          <div class="form-group">
                              <label for="phone"><?php echo e(trans('labels.phone')); ?></label>
                              <input type="text" name="phone" value="" class="form-control" autofocus>
                          </div>   


                          <div class="form-group" >
                              <label for="video"><?php echo e(trans('labels.video')); ?></label>        
                              <input type="text" name="video" value="" class="form-control"  >    
                          </div>             

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.gear_type')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="gear_type" id="gear_type">
                                <option value="Automatic" ><?php echo e(trans('labels.Automatic')); ?></option>
                                <option value="Manual" ><?php echo e(trans('labels.Manual')); ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                            <label for="area"> <?php echo e(trans('labels.location')); ?><span class="clsred">*</span></label>                    
                              <input class="form-control" type="text" id="pac-input"  name="googleLocation" placeholder="<?php echo e(trans('labels.chooseLocation')); ?>" data-parsley-required="true" required="" value="" />
                          </div>

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" ><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" ><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>

                        <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$user->lat;?>" />
                        <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$user->lng;?>" />


                          <div class="form-group">
                              <label><?php echo e(trans('labels.image')); ?></label>
                              <?php if (isset($result['edittemplate']->image)) { ?>
                              <input type="file" name="image" id="image" value="">
                                <input type="hidden" class="form-control" name="oldimage" id="oldimage" value="<?php if(isset($result['edittemplate']->image)): ?><?php echo e($result['edittemplate']->image); ?> <?php endif; ?>">
                                  <img src="<?php if(isset($result['edittemplate']->image)): ?><?php echo e(url('/public/templateImage/'.$result['edittemplate']->image)); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>  
                              <?php } else { ?>
                                <input type="file" name="image[]" id="image" required="" value="" accept="image/x-png,image/jpeg">
                              <?php } ?>
                              <input type="button" onclick="add_new_img()" value="<?php echo e(trans('labels.addNewImage')); ?>">
                              
                              <div id="add_img"></div>
                          </div>


                      <script type="text/javascript">
                          function add_new_img()
                          {
                              jQuery('#add_img').append('<div class="form-group"><input type="file" name="image[]" id="image" accept="image/x-png,image/jpeg"></div>');
                          }
                      </script>



                          
        
                      

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <a href="<?php echo e(url('admin/car')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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
            
        } else if (usertype == 2) {
           $('#twostep').css('display','block');
            $('#threestep').css('display','none');
           $('#onestep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','none');
        }
        else if (usertype == 3) {
           $('#onestep').css('display','none');
           $('#threestep').css('display','block');
           $('#twostep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','none');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','block');
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
				url: '<?php echo e(route("category.filter")); ?>',
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
    //     url: '<?php echo e(route("category.filter1")); ?>',
    //     data: {'id':name},
    //     success: function(res){
    //       jQuery("#year_of_car").html(res);
    //     }
    //   });
    // }

</script> 



<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>