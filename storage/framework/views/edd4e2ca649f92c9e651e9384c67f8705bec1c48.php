<?php $__env->startSection('content'); ?>

<h3 class="page-title">New Property</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/property')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Create Property</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>


                     
                  
                     
                    <div class="form-group">
                        <label for="property_name">Property Name <span class="clsred">*</span></label>
                        <input type="text" name="property_name" value="" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="address">Address <span class="clsred">*</span></label>        
                        <textarea name="address" id="address" value="" class="form-control" required autofocus></textarea>
                    </div>


                    <div class="form-group">
                        <label for="subrub">subrub <span class="clsred">*</span></label>
                        <input type="text" name="subrub" value="" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="state">State <span class="clsred">*</span></label>
                        <input type="text" name="state" value="" class="form-control" required autofocus>
                    </div>
                    

                    <div class="form-group">
                        <label for="postcode">Postcode <span class="clsred">*</span></label>        
                        <input type="text" name="postcode" value="" class="form-control" required autofocus>    
                    </div>  

                    <div class="form-group">
                        <label for="sale_price">Sale Price <span class="clsred">*</span></label>        
                        <input type="text" name="sale_price" value="" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="week_rentprice">Week Rentprice <span class="clsred">*</span></label>        
                        <input type="text" name="week_rentprice" value="" class="form-control" required autofocus>    
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="clsred">*</span></label>        
                        <textarea name="description" id="description" value="" class="form-control" required autofocus></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pro_type">Property Type <span class="clsred">*</span></label>
                            <select name="pro_type" id="pro_type" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $property_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($pro_type->id); ?>"><?php echo e($pro_type->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>

                    

                    <div class="form-group">
                    <label for="prop_feature">Property Features <span class="clsred">*</span></label>
                    <select class="field select2" name="prop_feature[]" autofocus required id="prop_feature" multiple="multiple" data-placeholder="Select Property Features">
                      <option value="">--Select Property Features--</option>
                        <?php $__empty_1 = true; $__currentLoopData = $property_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_features): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                              <option value="<?php echo e($pro_features->id); ?>"><?php echo e($pro_features->fename); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                        <?php endif; ?>  
                    </select>
                  </div>



                    <div class="form-group">
                        <label for="bedrooms">Bedrooms<span class="clsred">*</span></label>        
                        <input type="text" name="bedrooms" id="bedrooms" value="" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="bathrooms">Bathrooms<span class="clsred">*</span></label>        
                        <input type="text" name="bathrooms" id="bathrooms" value="" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="parking">Parking<span class="clsred">*</span></label>        
                        <input type="text" name="parking" id="parking" value="" class="form-control" required autofocus>    
                    </div>

                    <div class="form-group">
                        <label for="ownerid">Owner <span class="clsred">*</span></label>
                            <select name="ownerid" id="ownerid" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $owner_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="agentid">Agent <span class="clsred">*</span></label>
                            <select name="agentid" id="agentid" class="field"  autofocus required>
                                 <option value="">--Select Property Type--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $agent_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($agent->id); ?>"><?php echo e($agent->name); ?></option>                          
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                
                            </select>
                    </div>

                    <div class="form-group">
                      <label for="area">Google Location<span class="clsred">*</span></label>
                    
                        <input class="form-control" type="text" id="area" onchange="getLocation(this.value)"  autocomplete="on" name="googleLocation" placeholder="Google Location" data-parsley-required="true" required="" value="<?php echo @$user->googleLocation;?>" />

                    </div>

                  <input class="form-control" type="hidden" id="lat" name="lat"  value="<?php echo @$user->lat;?>" />
                  <input class="form-control" type="hidden" id="lng" name="lng"  value="<?php echo @$user->lng;?>" />
              <!-- <div class="col-md-6 col-sm-6"> 
                <input class="form-control" type="text" id="area" name="area" placeholder="Area" data-parsley-required="true" value="<?php echo @$user->area;?>" />
              </div> -->
            





                    <div class="form-group">
                        <label><?php echo e(trans('labels.image')); ?></label>
                        <?php if (isset($result['edittemplate']->image)) { ?>
                        <input type="file" name="image" id="image" value="">
                          <input type="hidden" class="form-control" name="oldimage" id="oldimage" value="<?php if(isset($result['edittemplate']->image)): ?><?php echo e($result['edittemplate']->image); ?> <?php endif; ?>">
                            <img src="<?php if(isset($result['edittemplate']->image)): ?><?php echo e(url('/public/templateImage/'.$result['edittemplate']->image)); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>  
                        <?php } else { ?>
                          <input type="file" name="image[]" id="image" required="" value="" accept="image/x-png,image/jpeg">
                        <?php } ?>
                        <input type="button" onclick="add_new_img()" value="Add New Image">
                        
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