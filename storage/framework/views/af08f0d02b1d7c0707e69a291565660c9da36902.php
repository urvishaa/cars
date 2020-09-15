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
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat:<?php echo e($property->lat); ?>, lng: <?php echo e($property->lng); ?>},
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
    position: {lat: <?php echo e($property->lat); ?>, lng: <?php echo e($property->lng); ?>},
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



<h3 class="page-title"><?php echo e(trans('labels.editProperty')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/property/'.$property->id)); ?>" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>


    
                <?php //echo "<pre>"; print_r($property); die; ?>
                  <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="usertype"><?php echo e(trans('labels.userType')); ?> <span class="clsred">*</span></label>
                                  <select name="userType" id="usertype" class="field"  autofocus required>
                                      <option value=""><?php echo e(trans('labels.selectUserType')); ?></option>
                                      <option value="1" <?php if($property->userType == 1) { echo 'selected'; } ?>><?php echo e(trans('labels.users')); ?></option>                          
                                      <option value="2" <?php if($property->userType == 2) { echo 'selected'; } ?>><?php echo e(trans('labels.showRoomAdmin')); ?></option>                          
                                  </select>
                          </div>

                          <div class="form-group" id="usershide" style="display: none">
                              <label for="userId"><?php echo e(trans('labels.users')); ?> <span class="clsred">*</span></label>
                                  <select name="userId" id="userId" class="field" >
                                       <option value=""><?php echo e(trans('labels.selectUser')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option <?php if($property->userId == $user->id): ?> selected="" <?php endif; ?> value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>

                          <div class="form-group" id="ShowRoomAdminhide" style="display: none">
                              <label for="showRoomId"><?php echo e(trans('labels.showRoomAdmin')); ?> <span class="clsred">*</span></label>
                                  <select name="showRoomId" id="showRoomId" class="field">
                                       <option value=""><?php echo e(trans('labels.selectShowRoomAdmin')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $ShowRoomAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ShowRoom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option <?php if($property->showRoomId == $ShowRoom->myid): ?> selected="" <?php endif; ?> value="<?php echo e($ShowRoom->myid); ?>"><?php echo e($ShowRoom->first_name); ?> <?php echo e($ShowRoom->last_name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>

                          <div class="form-group">
                              <label for="pro_type"><?php echo e(trans('labels.propertyType')); ?> <span class="clsred">*</span></label>
                                  <select name="pro_type" id="pro_type" class="field"  autofocus required>
                                       <option value=""><?php echo e(trans('labels.selectPropertyType')); ?></option>
                                          <?php $__empty_1 = true; $__currentLoopData = $property_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                <option value="<?php echo e($pro_type->id); ?>" <?php echo e($property->pro_type ==  $pro_type->id ? 'selected="selected"' : ''); ?> ><?php echo e($pro_type->name); ?></option>                          
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                          <?php endif; ?>  
                                      
                                  </select>
                          </div>    
                          <?php $var = explode(',', $property->prop_category); ?>
                          <div class="form-group">
                            <label for="prop_category"><?php echo e(trans('labels.propertyCategory')); ?> <span class="clsred">*</span></label>
                            <select class="field select2" name="prop_category[]" autofocus required id="prop_category" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>">
                                <?php $__empty_1 = true; $__currentLoopData = $property_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                    <option value="<?php echo e($pro_cat->id); ?>" <?php if(in_array($pro_cat->id, $var)): ?> <?php echo e('selected="selected"'); ?> <?php endif; ?> ><?php echo e($pro_cat->name); ?></option>
                                  
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                          </div>


                          <div class="form-group">
                              <label for="property_name"><?php echo e(trans('labels.propertyName')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="property_name" value="<?php echo e($property->property_name); ?>" class="form-control" required autofocus>
                          </div>
                          <div class="form-group">
                              <label for="address"><?php echo e(trans('labels.address')); ?> <span class="clsred">*</span></label>        
                              <textarea name="address" id="address" value="" class="form-control" required autofocus><?php echo e($property->address); ?></textarea>
                          </div>

                           <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>        
                              <textarea name="description" id="description" value="" class="form-control" required autofocus><?php echo e($property->description); ?></textarea>
                          </div>



                          <div class="form-group">
                              <label for="sale_price"><?php echo e(trans('labels.salePrice')); ?> <span class="clsred">*</span></label>        
                              <input type="text" name="sale_price" value="<?php echo e($property->sale_price); ?>" class="form-control" required autofocus>    
                          </div>
                          <div class="form-group">
                              <label for="month_rentprice"><?php echo e(trans('labels.monthRentPrice')); ?> <span class="clsred">*</span></label>        
                              <input type="text" name="month_rentprice" value="<?php echo e($property->month_rentprice); ?>" class="form-control" required autofocus>    
                          </div>   

                          <div class="form-group">
                              <label for="email"><?php echo e(trans('labels.email')); ?> <span class="clsred">*</span></label>
                              <input type="email" name="email" value="<?php echo e($property->email); ?>"class="form-control" required autofocus>
                          </div>    

                          <div class="form-group">
                              <label for="phone"><?php echo e(trans('labels.phone')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="phone" value="<?php echo e($property->phone); ?>" class="form-control" required autofocus>
                          </div>       

                          <div class="form-group">
                            <label for="area"><?php echo e(trans('labels.location')); ?><span class="clsred">*</span></label>
                          
                              <input class="form-control" type="text"  id="pac-input"  name="googleLocation" placeholder="<?php echo e(trans('labels.chooseLocation')); ?>" data-parsley-required="true" required="" value="<?php echo @$property->googleLocation;?>" />
                          </div>

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" <?php if(isset($property->published)): ?> <?php echo e(old('published',$property->published)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($property->published)): ?> <?php echo e(old('published',$property->published)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>

                        <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$property->lat;?>" />
                        <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$property->lng;?>" />
             

                          <div class="form-group">
                              <label><?php echo e(trans('labels.images')); ?></label>
                              <div class="form-group">
                                <?php 
                                if (isset($property_name)) {
                                    foreach ($property_name as $key => $proImg) {
                                       ///$show_img = date('Ymd') . "." . $proImg->img_name;
                                 ?>
                                  <input type="hidden" class="form-control" name="image[]" id="image" value="<?php if(isset($proImg->img_name)): ?><?php echo e($proImg->img_name); ?> <?php endif; ?>">
                                  <input type="hidden" class="form-control" name="image_id[]" id="image_id" value="<?php if(isset($proImg->id)): ?><?php echo e($proImg->id); ?> <?php endif; ?>">
                                    <div class="col-md-3"><img src="<?php if(isset($proImg->img_name)): ?><?php echo e(url('/public/propertyImage/'.$proImg->img_name )); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>
                                        <?php $proid = $proImg->id; ?>
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
                                  <a href="<?php echo e(url('admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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
            url: "<?php echo e(url('admin/property/delete_img')); ?>",
            data: {del_id:del_id},
            
            success: function(result){
                location.reload();
            }
        });

    }
</script>




<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>