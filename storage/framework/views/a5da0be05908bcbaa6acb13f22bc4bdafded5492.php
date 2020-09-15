<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.newProduct')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/car_accessories')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/car_accessories')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter"> 

                          <?php $admin = auth()->guard('admin')->user(); ?>
                          
                          <div class="form-group" >
                              <label for="store"><?php echo e(trans('labels.store')); ?> </label>
                                <select name="store_id" id="store" class="field" onchange="getval(this);" autofocus>
                                  <option value=""><?php echo e(trans('labels.SelectStore')); ?></option>
                                    <?php $__empty_1 = true; $__currentLoopData = $result['storeAdmin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                          <option value="<?php echo e($store->myid); ?>"><?php echo e($store->first_name ? $store->first_name : ''); ?> <?php echo e($store->last_name ? $store->last_name : ''); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                                </select>
                          </div>

                          <div class="form-group" >
                              <label for="category"><?php echo e(trans('labels.category')); ?> </label>
                                <select name="category_id" id="category" class="field" autofocus>
                                  <option value=""><?php echo e(trans('labels.SelectCategory')); ?></option>
                                </select>
                          </div>

                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.name')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="price"><?php echo e(trans('labels.price')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="price" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="specification"><?php echo e(trans('labels.specification')); ?> <span class="clsred">*</span></label>
                              <textarea name="specification" class="form-control" required autofocus></textarea>
                          </div>
                          <div class="form-group">
                              <label for="quantity"><?php echo e(trans('labels.quantity')); ?> <span class="clsred">*</span></label>
                              <input type="number" name="quantity" value="" class="form-control" required autofocus>
                          </div>
                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus></textarea>
                          </div>

                          <h4><strong><?php echo e(trans('labels.attribute')); ?></strong></h4>

                          <div class="form-group">
                              <label for="size"><?php echo e(trans('labels.size')); ?><span class="clsred">*</span></label>
                              <input type="text" name="size" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="model"><?php echo e(trans('labels.model')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="model" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="color"><?php echo e(trans('labels.color')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="color" value="" class="form-control" required autofocus>
                          </div>
                            
                          
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" <?php if(isset($result['edittemplate']->status)): ?> <?php echo e(old('status',$result['edittemplate']->status)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($result['edittemplate']->status)): ?> <?php echo e(old('status',$result['edittemplate']->status)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>


                          <div class="form-group">
                              <label><?php echo e(trans('labels.image')); ?></label>
                              <?php if (isset($result['edittemplate']->image)) { ?>
                              
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
                                  <a href="<?php echo e(url('admin/car_accessories')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    

<script type="text/javascript">
  
  function getval(store_val)
  { 
    var store_id = store_val.value;
    
    $.ajax({
        type: "POST",
        url: "<?php echo e(url('admin/car_accessories/getCategory')); ?>",
        data: {store_id:store_id},
        
        success: function(result){
          //alert(result); return false;
          $('#category').html(result);
            //location.reload();
        }
    });
  }

</script>
<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
</script> 

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>