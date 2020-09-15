<?php $__env->startSection('content'); ?>

<h3 class="page-title">New Property Features</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/property_features/save')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Create Property Features</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property_features')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>


                     
                  
                     
                    <div class="form-group">
                        <label for="name">Name <span class="clsred">*</span></label>
                        <input type="text" name="fename" value="" class="form-control" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="published">Published <span class="clsred">*</span></label>
                        <select class="form-control" name="published" id="published">
                          <option value="1" <?php if(isset($result['edittemplate']->published)): ?> <?php echo e(old('published',$result['edittemplate']->published)=="1"? 'selected':''); ?> <?php endif; ?>>Published</option>
                          <option value="2" <?php if(isset($result['edittemplate']->published)): ?> <?php echo e(old('published',$result['edittemplate']->published)=="2"? 'selected':''); ?> <?php endif; ?>>Unpublished</option>
                        </select>
                    </div>
                

                    <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="<?php echo e(url('admin/property_features')); ?>" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
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