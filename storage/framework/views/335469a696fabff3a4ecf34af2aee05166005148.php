<?php $__env->startSection('content'); ?>


<h3 class="page-title"><?php echo e(trans('labels.edithomeslide')); ?></h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/homeslide/update_homeslide/'.$homeslide->id)); ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="oldimage" value="<?php echo e(@$homeslide->image); ?>">
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(url('admin/homeslide')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                          </div>
                        </div>
                    </div>
                        
                    <?php echo csrf_field(); ?>


                   
                    <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name"><?php echo e(trans('labels.title')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="title" class="form-control prop-admin" value="<?php echo e($homeslide->title); ?>" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.description')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor"><?php echo e(@$homeslide->description); ?></textarea>
                              </div>
                          </div>

                           <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name"><?php echo e(trans('labels.titlearabic')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="titlearabic" value="<?php echo e($homeslide->titlearabic); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.descriptionarabic')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="descriptionarabic" class="form-control " id="editor1"><?php echo e(@$homeslide->descriptionarabic); ?></textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name"><?php echo e(trans('labels.titlekurdish')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="titlekurdish" value="<?php echo e($homeslide->titlekurdish); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.descriptionkurdish')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="descriptionkurdish" class="form-control " id="editor2"><?php echo e(@$homeslide->descriptionkurdish); ?></textarea>
                              </div>
                          </div>
                          
                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name"><?php echo e(trans('labels.image')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                 
                                  <input type="file" name="image">
                                    <?php if(file_exists(base_path().'/public/homeslide/'.@$homeslide->image)  && @$homeslide->image != ''): ?>
                                    <img height="50px" width="50px" src="<?php echo e(URL::to('public/homeslide/'.@$homeslide->image)); ?>">
                                    <?php endif; ?>

                              
                                </div>
                          </div>
                                          
                          <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                    <a href="<?php echo e(url('admin/homeslide')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
                                  </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    
    
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>

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
<script>
  ClassicEditor
          .create( document.querySelector( '#editor1' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>
<script>
  ClassicEditor
          .create( document.querySelector( '#editor2' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>