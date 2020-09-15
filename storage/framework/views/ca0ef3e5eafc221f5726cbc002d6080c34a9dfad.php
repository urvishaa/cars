<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.newAds')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/ads')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/ads')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                      <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.title')); ?><span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?><span class="clsred">*</span></label>
                              <textarea name="description" id="description" class="form-control" required autofocus></textarea>
                          </div>

                          <div class="form-group">
                                <label for="image"><?php echo e(trans('labels.banner')); ?></label>                      
                                <input class="" name="image"  value="" type="file">  
                            </div>
                          
                          <div class="form-group">
                              <label for="published"><?php echo e(trans('labels.published')); ?><span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" <?php if(isset($result['edittemplate']->published)): ?> <?php echo e(old('published',$result['edittemplate']->published)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($result['edittemplate']->published)): ?> <?php echo e(old('published',$result['edittemplate']->published)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
                              </select>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <a href="<?php echo e(url('admin/ads')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                </div>
                          </div>
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>