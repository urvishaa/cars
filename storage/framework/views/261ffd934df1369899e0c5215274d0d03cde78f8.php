<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.editProduct')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/car_accessories/update/'.$product['id'])); ?>" method="POST" enctype="multipart/form-data">
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
                          
                          <div class="form-group" >
                              <label for="store"><?php echo e(trans('labels.store')); ?> </label>
                                <select name="store_id" id="store" class="field" onchange="getval(this.value);" autofocus>
                                  <option value=""><?php echo e(trans('labels.SelectStore')); ?></option>
                                    <?php $__currentLoopData = $result['storeAdmin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                                        <option value="<?php echo e($store->myid); ?>" 
                                            <?php if($store->myid == $product['store_id']): ?> 
                                            <?php echo e('selected="selected"'); ?> <?php else: ?> <?php echo e(""); ?> <?php endif; ?>><?php echo e($store->first_name); ?> <?php echo e($store->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                          </div>
        
                          
                          <div class="form-group" >
                              <label for="category"><?php echo e(trans('labels.category')); ?> </label>
                                <select name="category_id" id="category" class="field" autofocus>
                                  <option value=""><?php echo e(trans('labels.SelectCategory')); ?></option>
                                  <?php $__currentLoopData = $result['pro_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                          <option value="<?php echo e($cate['id']); ?>" 
                                          <?php if($cate['id'] == $product['category_id']): ?> 
                                          <?php echo e('selected="selected"'); ?> <?php else: ?> <?php echo e(""); ?> <?php endif; ?>><?php echo e($cate['name']); ?></option>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                          </div>


                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.name')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="name" value="<?php echo e($product['name']); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="price"><?php echo e(trans('labels.price')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="price" value="<?php echo e($product['price']); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="specification"><?php echo e(trans('labels.specification')); ?> <span class="clsred">*</span></label>
                              <textarea name="specification" class="form-control" required autofocus><?php echo e($product['specification']); ?></textarea>
                          </div>

                          <div class="form-group">
                              <label for="quantity"><?php echo e(trans('labels.quantity')); ?> <span class="clsred">*</span></label>
                              <input type="number" name="quantity" value="<?php echo e($product['quantity']); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?> <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus><?php echo e($product['description']); ?></textarea>
                          </div>

                          <h4><strong><?php echo e(trans('labels.attribute')); ?></strong></h4>

                          <div class="form-group">
                              <label for="size"><?php echo e(trans('labels.size')); ?><span class="clsred">*</span></label>
                              <input type="text" name="size" required value="<?php echo e($product['size'] ? $product['size'] : ''); ?>" class="form-control" autofocus>
                          </div>

                          <div class="form-group">
                              <label for="model"><?php echo e(trans('labels.model')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="model" value="<?php echo e($product['model']); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="color"><?php echo e(trans('labels.color')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="color" value="<?php echo e($product['color']); ?>" class="form-control" required autofocus>
                          </div>
                          
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" <?php if(isset($product['status'])): ?> <?php echo e(old('status',$product['status'])=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($product['status'])): ?> <?php echo e(old('status',$product['status'])=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label><?php echo e(trans('labels.images')); ?></label>
                              <div class="form-group">
                                <?php 
                                if (isset($car_img)) {
                                    foreach ($car_img as $key => $proImg) {
                                 ?>
                                  <input type="hidden" class="form-control" name="image[]" id="image" value="<?php if(isset($proImg->img_name)): ?><?php echo e($proImg->img_name); ?> <?php endif; ?>">
                                  <input type="hidden" class="form-control" name="image_id[]" id="image_id" value="<?php if(isset($proImg->id)): ?><?php echo e($proImg->id); ?> <?php endif; ?>">
                                    <div class="col-md-3"><img src="<?php if(isset($proImg->img_name)): ?><?php echo e(url('/public/productImage/'.$proImg->img_name )); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>
                                        <?php $proid = $proImg->id; ?>
                                    <div class="form-group"><input type="button" class="btn btn-danger" name="" onclick="delete_img('<?php echo e($proid); ?>')" value="<?php echo e(trans('labels.delete')); ?>"></div></div>
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
                                    <a href="<?php echo e(url('admin/car_accessories')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                  </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    
    

<script type="text/javascript">

    $( document ).ready(function() {


      //alert('gsdfg');

      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
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
            url: "<?php echo e(url('admin/car_accessories/delete_img')); ?>",
            data: {del_id:del_id},
            
            success: function(result){
                location.reload();
            }
        });

    }

</script> 

<script type="text/javascript">
                            
  function getval(store_id)
  { //alert(store_val); return false;

    //var store_id = store_val.value;
    
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

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>