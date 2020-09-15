<?php $__env->startSection('content'); ?>


<h3 class="page-title">Edit User</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/property/'.$property->id)); ?>" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    <h3 style="text-align: center;">Edit User</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                        <?php echo e(method_field('PUT')); ?>

                    <?php echo csrf_field(); ?>


                    
                 
                    <div class="form-group">
                        <label for="property_name">Property Name <span class="clsred">*</span></label>
                        <input type="text" name="property_name" value="<?php echo e($property->property_name); ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span class="clsred">*</span></label>        
                        <textarea name="address" id="address" value="" class="form-control" required autofocus><?php echo e($property->address); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="subrub">subrub <span class="clsred">*</span></label>
                        <input type="text" name="subrub" value="<?php echo e($property->subrub); ?>" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="state">State <span class="clsred">*</span></label>
                        <input type="text" name="state" value="<?php echo e($property->state); ?>" class="form-control" required autofocus>
                    </div>
                    

                    <div class="form-group">
                        <label for="postcode">Postcode <span class="clsred">*</span></label>        
                        <input type="text" name="postcode" value="<?php echo e($property->postcode); ?>" class="form-control" required autofocus>    
                    </div>  

                    <div class="form-group">
                        <label for="sale_price">Sale Price <span class="clsred">*</span></label>        
                        <input type="text" name="sale_price" value="<?php echo e($property->sale_price); ?>" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="week_rentprice">Week Rentprice <span class="clsred">*</span></label>        
                        <input type="text" name="week_rentprice" value="<?php echo e($property->week_rentprice); ?>" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="clsred">*</span></label>        
                        <textarea name="description" id="description" value="" class="form-control" required autofocus><?php echo e($property->description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pro_type">Property Type <span class="clsred">*</span></label>
                            <select name="pro_type" id="pro_type" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $property_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro_type->id); ?>" <?php echo e($property->pro_type ==  $pro_type->id ? 'selected="selected"' : ''); ?> ><?php echo e($pro_type->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>
                    <?php //echo "<pre>"; print_r($Pro_feature); die; ?>
                    <div class="form-group">
                        <label for="prop_feature">Property Features <span class="clsred">*</span></label>

                            <select class="field select2" name="prop_feature[]" autofocus required id="prop_feature" multiple="multiple" data-placeholder="Select Property Features">
                              <option value="">--Select Property Features--</option>
                                <?php $__empty_1 = true; $__currentLoopData = $property_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_features): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                    <option value="<?php echo e($pro_features->id); ?>" 
                                        <?php if(isset($Pro_feature)): ?>
                                        <?php foreach ($Pro_feature as $value) { ?>
                                            <?php echo e($value->feature_id ==  $pro_features->id ? 'selected="selected"' : ''); ?>

                                        <?php } ?> 
                                        <?php endif; ?>
                                        > <?php echo e($pro_features->fename); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>


                            
                    </div>

                    <div class="form-group">
                        <label for="bedrooms">Bedrooms<span class="clsred">*</span></label>        
                        <input type="text" name="bedrooms" id="bedrooms" value="<?php echo e($property->bedrooms); ?>" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="bathrooms">Bathrooms<span class="clsred">*</span></label>        
                        <input type="text" name="bathrooms" id="bathrooms" value="<?php echo e($property->bathrooms); ?>" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="parking">Parking<span class="clsred">*</span></label>        
                        <input type="text" name="parking" id="parking" value="<?php echo e($property->parking); ?>" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="ownerid">Owner <span class="clsred">*</span></label>
                            <select name="ownerid" id="ownerid" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $owner_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($owner->id); ?>" <?php echo e($property->ownerid ==  $owner->id ? 'selected="selected"' : ''); ?>><?php echo e($owner->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="agentid">Agent <span class="clsred">*</span></label>
                            <select name="agentid" id="agentid" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $agent_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($agent->id); ?>" <?php echo e($property->agentid ==  $agent->id ? 'selected="selected"' : ''); ?>><?php echo e($agent->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>


                    <div class="form-group">
                      <label for="area">Google Location<span class="clsred">*</span></label>
                    
                        <input class="form-control" type="text" id="area" onchange="getLocation(this.value)"  autocomplete="on" name="googleLocation" placeholder="Google Location" data-parsley-required="true" required="" value="<?php echo @$property->googleLocation;?>" />

                    </div>

                  <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$property->lat;?>" />
                  <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$property->lng;?>" />
                  <!-- <div class="col-md-6 col-sm-6"> 
                    <input class="form-control" type="text" id="area" name="area" placeholder="Area" data-parsley-required="true" value="<?php echo @$user->area;?>" />
                  </div> -->



                    <div class="form-group">
                        <label>Images</label>
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
                            <div class="form-group"><input type="button" class="btn btn-danger" name="" onclick="delete_img(<?php echo $proid ?>)" value="Delete"></div></div>
                        <?php } 
                        }   ?>
                            <div id="add_img"></div>
                            <div class="form-group"><input type="button" onclick="add_new_img()" value="Add New Image"></div>
                        
                    </div>
                </div>


                <iframe width="900"  height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $property->lat?>,<?php echo $property->lng; ?>&hl=es;z=14&amp;output=embed"
 >
 </iframe>
                    

    






<script type="text/javascript">
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


                                    
                    
                   <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                </form>
                            
            </div> 
        </div>
    
    

<script type="text/javascript">

    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    });  

</script> 



<script>

function getLocation(address) 
        {  
          var geocoder = new google.maps.Geocoder();
          geocoder.geocode( { 'address': address,'region':'IN'}, function(results, status) {


          if (status == google.maps.GeocoderStatus.OK) {
              var latitude = results[0].geometry.location.lat();
              var longitude = results[0].geometry.location.lng();

                document.getElementById("lng").value = longitude; 
                document.getElementById("lat").value = latitude; 

              } 
          }); 
        }

function initAutocomplete() {
        var input = document.getElementById('area');
        //var options = {
    //componentRestrictions: {country: ['fr', 'de']}
 // };
        autocomplete = new google.maps.places.Autocomplete(input,{types: ['address'], componentRestrictions: { country: ['in'] } });  
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var address_components=autocomplete.getPlace().address_components;        
            var country='';
            for(var j =0 ;j<address_components.length;j++)
            {
             if(address_components[j].types[0]=='country')
            {
                country=address_components[j].long_name;
            }
            }

            //document.getElementById('country_name').value=country;
            });      
      }  



</script>





 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2lQD8lHMPICHXfoXEmnT63q3zJRtJNQI&libraries=places&callback=initAutocomplete"
        async defer></script> 


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>