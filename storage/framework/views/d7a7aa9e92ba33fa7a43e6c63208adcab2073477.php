<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.contact')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(route('contact.save')); ?>" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?php echo e($contact->id ? $contact->id : ''); ?>">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <a href="<?php echo e(route('contact.create')); ?>" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a>
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
                                <input type="text" name="title" value="<?php echo e($contact->title ? $contact->title : ''); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>

                           <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.description')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor"><?php echo e($contact->description ? $contact->description : ''); ?></textarea>
                              </div>
                          </div>


                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="address"><?php echo e(trans('labels.address')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="address" value="<?php echo e($contact->address ? $contact->address : ''); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>

                         <div class="form-group row">
                              <div class="col-md-2">
                                <label for="phone"><?php echo e(trans('labels.phone')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="phone" value="<?php echo e($contact->phone ? $contact->phone : ''); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>

                          

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="email"><?php echo e(trans('labels.email')); ?> <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="email" name="email" value="<?php echo e($contact->email ? $contact->email : ''); ?>" class="form-control prop-admin" required autofocus></div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                                  <a href="<?php echo e(url('contact.create')); ?>" id="cancel" name="cancel" class="btn btn-default" required><?php echo e(trans('labels.cancel')); ?></a>
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

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>