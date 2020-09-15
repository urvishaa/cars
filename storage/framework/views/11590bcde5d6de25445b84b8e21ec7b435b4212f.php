<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
  
  <!-- Main content -->
     <h3 class="page-title"><?php if(empty($result['edittemplate']->id)) { ?>
               <?php echo e(trans('labels.add_Template')); ?>  
     <?php } else { ?>
              <?php echo e(trans('labels.edit_Template')); ?>

     <?php } ?> </h3>    
     <div class="panel panel-default">
        <div class="panel-heading">
           <?php if(empty($result['edittemplate']->id)) { ?>
               <?php echo e(trans('labels.add_Template')); ?>  
           <?php } else { ?>
               <?php echo e(trans('labels.edit_Template')); ?>

           <?php } ?>
        </div>
      <!-- SELECT2 EXAMPLE -->
        <div class="panel-body table-responsive progrmslistcls">  
          <div class="prolisttabcls">
            <form action="<?php echo e(url('admin/template/savetemplateform')); ?>" method="POST" enctype="multipart/form-data" id="form">
              <?php echo e(csrf_field()); ?>

                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($result['edittemplate']->id)): ?> <?php echo e($result['edittemplate']->id); ?> <?php endif; ?>">
            
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><?php echo e(trans('labels.name')); ?></label>
                        <input type="text" required="" class="form-control" name="templateName" id="templateName" value="<?php if(isset($result['edittemplate']->templateName)): ?><?php echo e($result['edittemplate']->templateName); ?> <?php endif; ?>">
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.image')); ?></label>
                        <?php if (isset($result['edittemplate']->image)) { ?>
                        <input type="file" name="image" id="image" value="">
                          <input type="hidden" class="form-control" name="oldimage" id="oldimage" value="<?php if(isset($result['edittemplate']->image)): ?><?php echo e($result['edittemplate']->image); ?> <?php endif; ?>">
                            <img src="<?php if(isset($result['edittemplate']->image)): ?><?php echo e(url('/public/templateImage/'.$result['edittemplate']->image)); ?> <?php endif; ?>" class="btn popup_image" height="100px" width="100px"/>  
                        <?php } else { ?>
                          <input type="file" name="image" id="image" required="" value="">
                        <?php } ?>
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.sampleVideo')); ?></label>
                        <?php if (isset($result['edittemplate']->sampleVideo)) { ?>
                          <input type="file" name="sampleVideo" id="sampleVideo" value="">
                          <input type="hidden" class="form-control" name="oldsampleVideo" id="oldsampleVideo" value="<?php if(isset($result['edittemplate']->sampleVideo)): ?><?php echo e($result['edittemplate']->sampleVideo); ?> <?php endif; ?>">
                          <video width="320" height="240" controls>  
                            <source src="<?php echo e(url('public/templateVideo/'.$result['edittemplate']->sampleVideo)); ?>" type="video/mp4">  
                          </video>
                          <a download="download" href="<?php echo e(url('public/templateVideo/'.$result['edittemplate']->sampleVideo)); ?>" class="btn btn-info">Download Video</a>  
                        <?php } else { ?>
                          <input type="file" required="" name="sampleVideo" id="sampleVideo" value="">
                        <?php } ?>
                        
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.videoTime')); ?></label>
                        <input type="text" class="form-control" required="" name="videoTime" id="videoTime" value="<?php if(isset($result['edittemplate']->videoTime)): ?><?php echo e($result['edittemplate']->videoTime); ?> <?php endif; ?>"><span>Minute</span>
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.totalImage')); ?></label>
                        <input type="text" class="form-control" name="totalImage" required="" id="totalImage" value="<?php if(isset($result['edittemplate']->totalImage)): ?><?php echo e($result['edittemplate']->totalImage); ?> <?php endif; ?>">
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.description')); ?></label>
                        <textarea name="description" class="form-control" id="description" required="" ><?php if(isset($result['edittemplate']->description)): ?><?php echo e($result['edittemplate']->description); ?> <?php endif; ?></textarea>
                      </div>

                      <div class="form-group">
                        <label><?php echo e(trans('labels.published_unpublished')); ?></label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" <?php if(isset($result['edittemplate']->status)): ?> <?php echo e(old('status',$result['edittemplate']->status)=="1"? 'selected':''); ?> <?php endif; ?>>Published</option>
                          <option value="2" <?php if(isset($result['edittemplate']->status)): ?> <?php echo e(old('status',$result['edittemplate']->status)=="2"? 'selected':''); ?> <?php endif; ?>>Unpublished</option>
                        </select>
                      </div>

                    <input type="submit" class="btn btn-primary" name="submit" id="submit_button" value="<?php echo e(trans('labels.SUBMIT')); ?>">
                    <a href="<?php echo e(url('admin/template')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>

                    </div>
                  </div>
                </div>        
            </form>
          </div>
        </div>
    </div>
  <!-- /.content --> 
<?php $__env->stopSection(); ?> 


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>