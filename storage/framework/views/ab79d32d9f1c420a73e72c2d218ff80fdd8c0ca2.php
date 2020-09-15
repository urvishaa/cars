<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.about')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/about/save')); ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="old_image" value="<?php echo e(@$about->image); ?>">
                  <input type="hidden" name="id" value="<?php echo e(@$about->id); ?>">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <!-- <a href="<?php echo e(url('admin/dashboard/this_month')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a> -->
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                    <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name"><?php echo e(trans('labels.image')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                  <?php if(@$about->id != ''): ?>
                                  <input type="file" name="image">
                                    <?php if(file_exists(base_path().'/public/aboutImage/'.@$about->image)  && @$about->image != ''): ?>
                                    <img height="50px" width="50px" src="<?php echo e(URL::to('public/aboutImage/'.@$about->image)); ?>">
                                    <?php endif; ?>

                                <?php else: ?>
                                <input type="file" name="image" required autofocus>
                                <?php endif; ?>
                                </div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.description')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor"><?php echo e(@$about->description); ?></textarea>
                              </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <!-- <a href="<?php echo e(url('admin/dashboard/this_month')); ?>" id="cancel" name="cancel" class="btn btn-default" required><?php echo e(trans('labels.cancel')); ?></a> -->
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
</script> 

<script>
  ClassicEditor
          .create( document.querySelector( '#editor' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>