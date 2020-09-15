<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.editAds')); ?> </h3>  

        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/ads/update_ads/'.$ads->id)); ?>" method="POST" enctype="multipart/form-data" >
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
                              <label for="name"><?php echo e(trans('labels.adsType')); ?><span class="clsred">*</span></label>
                              <select class="form-control" name="type">
                                <option value="1"  <?php if(isset($ads->type)): ?> <?php echo e(old('type',$ads->type)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.fixAds')); ?></option>
                                <option value="2" <?php if(isset($ads->type)): ?> <?php echo e(old('type',$ads->type)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.randomAds')); ?></option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="fename"><?php echo e(trans('labels.title')); ?> <span class="clsred">*</span></label>
                              <input type="text" name="name" value="<?php echo e($ads->name); ?>" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description"><?php echo e(trans('labels.description')); ?><span class="clsred">*</span></label>
                              <textarea name="description" id="description" class="form-control" required autofocus><?php echo e($ads->description); ?></textarea>
                          </div>

                          <div class="form-group">
                                <label for="dob"><?php echo e(trans('labels.banner')); ?></label>                      
                                <input class="col-md-3" name="image"  value="" type="file">  

                                <?php if($ads->image != ""): ?>
                                    <div class="col-md-2"><img src="<?php if(isset($ads->image)): ?><?php echo e(url('/public/dsaImage/'.$ads->image )); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/></div>
                                <?php else: ?>
                                    <div class="col-md-2"><img src="<?php echo e(url('/public/default-image.jpeg' )); ?>" class="btn popup_image" height="100px" width="100px"/></div>
                                <?php endif; ?>
                                <input type="hidden" name="oldimage" value="<?php echo e($ads->image); ?>">
                            </div>

                            <?php //echo "<prE>"; print_r($ads); die; ?>

                          <div class="form-group">
                              <label for="image"><?php echo e(trans('labels.fromDate')); ?></label>                      
                              <input class="form-control" name="fromdate"  value="<?php echo e($ads->fromdate); ?>" type="date">  
                          </div>
                          
                          <div class="form-group">
                              <label for="image"><?php echo e(trans('labels.toDate')); ?></label>                      
                              <input class="form-control" name="todate"  value="<?php echo e($ads->todate); ?>" type="date">  
                          </div>
                          
                          <div class="form-group">
                              <label for="name"><?php echo e(trans('labels.published')); ?> <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" <?php if(isset($ads->published)): ?> <?php echo e(old('published',$ads->published)=="1"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.published')); ?></option>
                                <option value="2" <?php if(isset($ads->published)): ?> <?php echo e(old('published',$ads->published)=="2"? 'selected':''); ?> <?php endif; ?>><?php echo e(trans('labels.unpublished')); ?></option>
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