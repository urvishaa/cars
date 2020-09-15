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

<?php
// echo "<pre>";
// print_r($property); exit;
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDImcjjRxyJMDrtMz3JWOQa2AhHkyq1xng&libraries=places&callback=initMap"
        async defer></script>

<script>
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat:<?php echo e($car->lat); ?>, lng: <?php echo e($car->lng); ?>},
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
    position: {lat: <?php echo e($car->lat); ?>, lng: <?php echo e($car->lng); ?>},
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



<h3 class="page-title"><?php echo e(trans('labels.editCar')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/car/'.$car->id)); ?>" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/car')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>


    
                  <div class="centerdiv">
                        <div class="subcenter"> 

                      <?php  $admin = auth()->guard('admin')->user();
                        if ($admin['issubadmin'] == 0) { ?>
                          <div class="form-group">
                              <label for="usertype"><?php echo e(trans('labels.userType')); ?> <span class="clsred">*</span></label>
                                  <select name="userType" id="usertype" class="field"  autofocus required>
                                      <option value=""><?php echo e(trans('labels.selectUserType')); ?></option>
                                      <option value="1" <?php if($car->userType == 1) { echo 'selected'; } ?>><?php echo e(trans('labels.users')); ?></option>                          
                                      <option value="2" <?php if($car->userType == 2) { echo 'selected'; } ?>><?php echo e(trans('labels.showRoomAdmin')); ?></option>  
                                      <option value="3" <?php if($car->userType == 3) { echo 'selected'; } ?>><?php echo e(trans('labels.rentalCompanies')); ?></option>                                                                
                                  </select>
                          </div>

                          <div class="form-group" id="usershide" style="display: none">
                              <label for="userId"><?php echo e(trans('labels.users')); ?> <span class="clsred">*</span></label>
                                  <select name="userId" id="userId" class="field" >
                                       <option value="" disabled=""><?php echo e(trans('labels.selectUser')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option <?php if($car->userId == $user->id): ?> selected="" <?php endif; ?> value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>

                          <div class="form-group" id="ShowRoomAdminhide" style="display: none">
                              <label for="showRoomId"><?php echo e(trans('labels.showRoomAdmin')); ?> <span class="clsred">*</span></label>
                                  <select name="showRoomId" id="showRoomId" class="field">
                                       <option value=""><?php echo e(trans('labels.selectShowRoomAdmin')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $ShowRoomAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ShowRoom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option <?php if($car->showRoomId == $ShowRoom->myid): ?> selected="" <?php endif; ?> value="<?php echo e($ShowRoom->myid); ?>"><?php echo e($ShowRoom->first_name); ?> <?php echo e($ShowRoom->last_name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>
                          
                            <div class="form-group" id="CompanyAdminhide" style="display: none">
                              <label for="CompanyId"><?php echo e(trans('labels.rentalCompanies')); ?> <span class="clsred">*</span></label>
                                  <select name="companyId" id="companyId" class="field">
                                       <option value="" disabled=""><?php echo e(trans('labels.rentalCompanies')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $Company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option <?php if($car->companyId == $Com->myid): ?> selected="" <?php endif; ?> value="<?php echo e($Com->myid); ?>"><?php echo e($Com->first_name); ?> <?php echo e($Com->last_name); ?></option>   
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>                                  
                                  </select>
                          </div>

                          <div class="form-group" id="onestep">
                              <label for="pro_type"><?php echo e(trans('labels.carType')); ?></label>
                                  <select name="pro_type" id="pro_type" class="field propertyType"  onchange="inputPrice(this)">
                                       <option value="" disabled=""><?php echo e(trans('labels.selectCarType')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $car_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cars_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option value="<?php echo e($cars_type->id); ?>" <?php echo e($car->pro_type ==  $cars_type->id ? 'selected="selected"' : ''); ?> ><?php echo e($cars_type->name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>   

                            <div class="form-group" id="twostep" style="display:none;">
                                <label for="pro_type"><?php echo e(trans('labels.carType')); ?> <span class="clsred">*</span></label>
                                  <select name="pro_type2" id="pro_type1" class="field"   >                              
                                        <option  <?php echo e($car->pro_type ==  $car_type[0]->id ? 'selected="selected"' : ''); ?> value="<?php echo e($car_type[0]->id); ?>"><?php echo e($car_type[0]->name); ?></option>                                
                                  </select>
                            </div>

                          <div class="form-group" id="threestep" style="display:none;">
                              <label for="pro_type"><?php echo e(trans('labels.carType')); ?> <span class="clsred">*</span></label>
                                <select name="pro_type3" id="pro_type2" class="field"   >                              
                                      <option <?php echo e($car->pro_type ==  $car_type[1]->id ? 'selected="selected"' : ''); ?> value="<?php echo e($car_type[1]->id); ?>"><?php echo e($car_type[1]->name); ?></option>                                
                                </select>
                          </div>


                          <div style="display:none" class="salePrice">
                          <div class="form-group" >
                              <label for="sale_price"><?php echo e(trans('labels.salePrice')); ?></label>        
                              <input type="text" name="sale_price" value="<?php echo e($car->sale_price ? $car->sale_price : 0); ?>" class="form-control"  >    
                          </div>
                        </div>
                        <div style="display:none" class="rentPrice">
                          <div class="form-group" >
                              <label for="daily_rentprice"><?php echo e(trans('labels.dailyRentPrice')); ?> </label>        
                              <input type="text" name="daily_rentprice" value="<?php echo e($car->daily_rentprice ? $car->daily_rentprice : 0); ?>" class="form-control"  >    
                          </div> 
                          <div class="form-group" >
                              <label for="weekly_rentprice"><?php echo e(trans('labels.weeklyRentPrice')); ?> </label>        
                              <input type="text" name="weekly_rentprice" value="<?php echo e($car->weekly_rentprice ? $car->weekly_rentprice : 0); ?>" class="form-control"  >    
                          </div> 
                          <div class="form-group" >
                              <label for="month_rentprice"><?php echo e(trans('labels.monthRentPrice')); ?> </label>        
                              <input type="text" name="month_rentprice" value="<?php echo e($car->month_rentprice ? $car->month_rentprice : 0); ?>" class="form-control"  >    
                          </div> 
                        </div>


                          <div class="form-group">
                            <label for="car_brand"><?php echo e(trans('labels.carBrand')); ?> </label>
                            <select class="field select2" name="car_brand" autofocus id="car_brand" onchange="filterCategory(this.value)" data-placeholder="<?php echo e(trans('labels.selectCarBrand')); ?>">
                                      <option value=""><?php echo e(trans('labels.selectCarBrand')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $carBrand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($brand->id); ?>" <?php echo e($car->car_brand ==  $brand->id ? 'selected="selected"' : ''); ?> ><?php echo e($brand->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                          </div> 


                            <?php } elseif($admin['issubadmin'] == 4 ){ ?>
                            <input name="userType" value="3" hidden="">
                            <input name="companyId" value="<?php echo e($admin['myid']); ?>" hidden="">


                            <div class="form-group" id="threestep">
                              <label for="pro_type"><?php echo e(trans('labels.carType')); ?> <span class="clsred">*</span></label>
                                <select name="pro_type3" id="pro_type2" class="field"   >                              
                                      <option <?php echo e($car->pro_type ==  $car_type[1]->id ? 'selected="selected"' : ''); ?> value="<?php echo e($car_type[1]->id); ?>"><?php echo e($car_type[1]->name); ?></option>                                
                                </select>
                            </div>

                              <div class="form-group" >
                                  <label for="daily_rentprice"><?php echo e(trans('labels.dailyRentPrice')); ?> </label>        
                                  <input type="text" name="daily_rentprice" value="<?php echo e($car->daily_rentprice); ?>" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="weekly_rentprice"><?php echo e(trans('labels.weeklyRentPrice')); ?> </label>        
                                  <input type="text" name="weekly_rentprice" value="<?php echo e($car->weekly_rentprice); ?>" class="form-control"  >    
                              </div> 
                              <div class="form-group" >
                                  <label for="month_rentprice"><?php echo e(trans('labels.monthRentPrice')); ?> </label>        
                                  <input type="text" name="month_rentprice" value="<?php echo e($car->month_rentprice); ?>" class="form-control"  >    
                              </div> 
                        
                            <?php } elseif($admin['issubadmin'] == 2 ) { ?>
                            <input name="userType" value="2" hidden="">
                            <input name="showRoomId" value="<?php echo e($admin['myid']); ?>" hidden="">

                            <div class="form-group" id="twostep">
                              <label for="pro_type"><?php echo e(trans('labels.carType')); ?> <span class="clsred">*</span></label>
                                <select name="pro_type2" id="pro_type1" class="field"   >                              
                                      <option  <?php echo e($car->pro_type ==  $car_type[0]->id ? 'selected="selected"' : ''); ?> value="<?php echo e($car_type[0]->id); ?>"><?php echo e($car_type[0]->name); ?></option>                                
                                </select>
                            </div>

                            <div class="form-group" >
                              <label for="sale_price"><?php echo e(trans('labels.salePrice')); ?></label>        
                              <input type="text" name="sale_price" value="<?php echo e($car->sale_price ? $car->sale_price : 0); ?>" class="form-control"  >    
                            </div>

                            <?php } ?>

                        
                         


                          <?php $var = explode(',', $car->prop_category); ?>
                          <div class="form-group">
                            <label for="prop_category"><?php echo e(trans('labels.model')); ?> </label>
                            <select class="field select2" name="prop_category" autofocus  data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>" id="filterCategorys" >
                              <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
                                
                                <?php $__empty_1 = true; $__currentLoopData = $car_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                  <option value="<?php echo e($car_cat->id); ?>" <?php if($car_cat->id == $car->prop_category): ?>  selected  <?php endif; ?>  ><?php echo e($car_cat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                          </div>

                          
                          <div class="form-group">
                            <label for="car_brand"><?php echo e(trans('labels.yearOfCar')); ?> </label>
                            <select class="field select2" name="year_of_car" autofocus id="year_of_car" data-placeholder="<?php echo e(trans('labels.yearOfCar')); ?>" >
                              <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
                              
                              <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year->year); ?>" <?php if($year->year == $car->year_of_car): ?> selected <?php endif; ?>><?php echo e($year->year); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                  
                            </select>
                          </div>

                          <div class="form-group">
                              <label for="car_name"><?php echo e(trans('labels.carName')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="car_name" value="<?php echo e($car->car_name); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="kilometer"><?php echo e(trans('labels.kilometer')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="kilometer" value="<?php echo e($car->kilometer); ?>" class="form-control" required autofocus>
                          </div>


                          <div class="form-group">
                              <label for="fueltype"><?php echo e(trans('labels.fuelType')); ?> <span class="clsred">*</span></label>
                              <select name="fueltype" class="field"  autofocus required>
                                     <option value=""><?php echo e(trans('labels.selectfuelType')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $fueltype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                              <option value="<?php echo e(@$ft->id); ?>" <?php if(isset($car->fueltype) AND $car->fueltype == $ft->id): ?>  selected="selected" <?php endif; ?>><?php echo e(@$ft->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                        <?php endif; ?>                                
                              </select>
                              <!-- <textarea name="specification" id="specification" value="" class="form-control" required autofocus></textarea> -->
                          </div>

                          <div class="form-group">
                              <label for="address"><?php echo e(trans('labels.address')); ?> <span class="clsred">*</span></label>        
                              <textarea name="address" id="address" value="" class="form-control" required autofocus><?php echo e($car->address); ?></textarea>
                          </div>

                          <div class="form-group">
                              <label for="pro_type"><?php echo e(trans('labels.city')); ?> <span class="clsred">*</span></label>
                                <select name="city" id="city" class="field"  autofocus required>
                                     <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                        <?php $__empty_1 = true; $__currentLoopData = $city; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                              <option value="<?php echo e($ct->id); ?>" <?php if(isset($car->city) AND $car->city == $ct->id): ?>  selected="selected" <?php endif; ?>><?php echo e($ct->name); ?></option>                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>                               
                                </select>
                          </div>

                           <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>        
                              <textarea name="description" id="description" value="" class="form-control" required autofocus><?php echo e($car->description); ?></textarea>
                          </div>



                          

                          <div class="form-group">
                              <label for="email"><?php echo e(trans('labels.email')); ?> </label>
                              <input type="email" name="email" value="<?php echo e($car->email ? $car->email : ''); ?>"class="form-control" autofocus>
                          </div>    

                          <div class="form-group">
                              <label for="phone"><?php echo e(trans('labels.phone')); ?> </label>
                              <input type="text" name="phone" value="<?php echo e($car->phone  ? $car->phone : ''); ?>" class="form-control" autofocus>
                          </div>       

                          <div class="form-group" >
                              <label for="video"><?php echo e(trans('labels.video')); ?> </label>        
                              <input type="url" name="video" value="<?php echo e($car->video ? $car->video : ''); ?>" class="form-control"  >    
                          </div>             

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.gear_type')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="gear_type" id="gear_type">
                                <option value="Automatic" <?php if(isset($car->gear_type)): ?> <?php echo e(old('gear_type',$car->gear_type)=="Automatic"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.Automatic')); ?></option>
                                <option value="Manual" <?php if(isset($car->gear_type)): ?> <?php echo e(old('gear_type',$car->gear_type)=="Manual"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.Manual')); ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                            <label for="area"><?php echo e(trans('labels.location')); ?><span class="clsred">*</span></label>
                          
                              <input class="form-control" type="text"  id="pac-input"  name="googleLocation" placeholder="<?php echo e(trans('labels.chooseLocation')); ?>" data-parsley-required="true" required="" value="<?php echo @$car->googleLocation;?>" />
                          </div>

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" <?php if(isset($car->published)): ?> <?php echo e(old('published',$car->published)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($car->published)): ?> <?php echo e(old('published',$car->published)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>

                        <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$car->lat;?>" />
                        <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$car->lng;?>" />
             

                          <div class="form-group">
                              <label><?php echo e(trans('labels.images')); ?></label>
                              <div class="form-group">
                                <?php 
                                if (isset($car_name)) {
                                    foreach ($car_name as $key => $carImg) {
                                       ///$show_img = date('Ymd') . "." . $carImg->img_name;
                                 ?>
                                  <input type="hidden" class="form-control" name="image[]" id="image" value="<?php if(isset($carImg->img_name)): ?><?php echo e($carImg->img_name); ?> <?php endif; ?>">
                                  <input type="hidden" class="form-control" name="image_id[]" id="image_id" value="<?php if(isset($carImg->id)): ?><?php echo e($carImg->id); ?> <?php endif; ?>">
                                    <div class="col-md-3"><img src="<?php if(isset($carImg->img_name)): ?><?php echo e(url('/public/carImage/'.$carImg->img_name )); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>
                                        <?php $proid = $carImg->id; ?>
                                    <div class="form-group"><input type="button" class="btn btn-danger" name="" onclick="delete_img(<?php echo $proid ?>)" value="<?php echo e(trans('labels.delete')); ?>"></div></div>
                                <?php } 
                                }   ?>
                                    <div id="add_img"></div>
                                    <div class="form-group"><input type="button" onclick="add_new_img()" value="<?php echo e(trans('labels.addNewImage')); ?>"></div>
                              </div>
                          </div>                              
                          
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

    $( document ).ready(function() {

        var usertype = $('#usertype').val();
        if (usertype == 1) {
            $('#onestep').css('display','block');
            $('#twostep').css('display','none');
              $('#threestep').css('display','none');  
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
             $('#CompanyAdminhide').css('display','none');
        }   else if (usertype == 2) {
          $('#twostep').css('display','block');
           $('#onestep').css('display','none');   
            $('#threestep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','none');
        }
         else if (usertype == 3) {
           $('#twostep').css('display','none');
           $('#onestep').css('display','none');  
            $('#threestep').css('display','block');  
            $('#ShowRoomAdminhide').css('display','none');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','block');
        }

        $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });

        var show = jQuery(".propertyType").val();
        if(show == 1){
          jQuery(".rentPrice").hide();
            jQuery(".salePrice").show();
        }
        else if(show == 2){
            jQuery(".rentPrice").show();
            jQuery(".salePrice").hide();
        }
        else if(show == ""){
          jQuery(".rentPrice").hide();
            jQuery(".salePrice").hide();
        }

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


    $('#usertype').on('click',function() {
      var usertype = $('#usertype').val();
      // alert(usertype);
        if (usertype == 1) {
            $('#onestep').css('display','block');
            $('#twostep').css('display','none');
              $('#threestep').css('display','none');  
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
            $('#CompanyAdminhide').css('display','none');
             jQuery(".rentPrice").hide();
            jQuery(".salePrice").hide();
        } else if (usertype == 2) {

          $('#twostep').css('display','block');
          $('#onestep').css('display','none');   
            $('#threestep').css('display','none');  
          $('#ShowRoomAdminhide').css('display','block');
          $('#usershide').css('display','none');
          $('#CompanyAdminhide').css('display','none');
           jQuery(".salePrice").show();
            jQuery(".rentPrice").hide();
        }
          else if (usertype == 3) {
           $('#twostep').css('display','none');
             $('#threestep').css('display','block');  
           $('#onestep').css('display','none');  
            $('#ShowRoomAdminhide').css('display','none');
            $('#usershide').css('display','none');
            $('#CompanyAdminhide').css('display','block');
             jQuery(".rentPrice").show();
              jQuery(".salePrice").hide();
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
            url: "<?php echo e(url('admin/car/delete_img')); ?>",
            data: {del_id:del_id},
            
            success: function(result){
                location.reload();
            }
        });

    }
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
</script>




<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>