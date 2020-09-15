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

<h3 class="page-title"><?php echo e(trans('labels.createTopProperty')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/topCar')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                       <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                    
                    <div class="centerdiv">
                        <div class="subcenter">      
                          <div class="form-group">
                            <label for="mainProId"><?php echo e(trans('labels.property')); ?> <span class="clsred">*</span></label>
                            <select class="field select2" name="mainProId[]" autofocus required id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>">
                                <?php $__empty_1 = true; $__currentLoopData = $property; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                    <?php if(isset($setProperty) !=''): ?>
                                      <option value="<?php echo e($pro_cat->id); ?>"  <?php if(in_array($pro_cat->id, $setProperty)): ?> <?php echo e('selected'); ?> <?php endif; ?> ><?php echo e($pro_cat->property_name); ?></option>
                                    <?php else: ?>
                                      <option value="<?php echo e($pro_cat->id); ?>"><?php echo e($pro_cat->property_name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                          </div>

                          <div class="form-group">
                            <label></label>
                            <input type="button" onclick="add_new_img(jQuery('#mainProId').val())" value="<?php echo e(trans('labels.add')); ?>">
                          </div>
                          <div id="add_textBox" ></div>


                          <script type="text/javascript">

                              function add_new_img(proppertyId)
                              {  
                                  $.ajax({
                                      type: "POST",
                                      url: "<?php echo e(url('admin/topCar/getPropertyId')); ?>",
                                      data: {proppertyId:proppertyId},
                                      
                                      success: function(result){
                                          
                                          $('#add_textBox').html(result)
                                      }
                                  });
                              }
                          </script>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  
                                </div>
                          </div>
                        </div>
                      </div>
                </form>
                            
            </div> 
        </div>


<script type="text/javascript">
    $('#usertype').on('click',function() {
      var usertype = $('#usertype').val();
        if (usertype == 1) {
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
        } else if (usertype == 2) {
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
        }
    });


</script>

<script type="text/javascript">
    
    $( document ).ready(function() {

      <?php if(isset($setProperty) != ""): ?> 
        add_new_img(jQuery('#mainProId').val());  
      <?php endif; ?>

      

      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
    

</script> 



<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>