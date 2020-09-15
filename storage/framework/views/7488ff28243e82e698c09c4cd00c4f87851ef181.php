<?php $__env->startSection('content'); ?>

<h3 class="page-title"><?php echo e(trans('labels.newNotification')); ?></h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="<?php echo e(url('admin/notification/save')); ?>" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                            <!-- <a href="#" id="cancel" name="cancel" class="btn btn-default"><?php echo e(trans('labels.cancel')); ?></a> -->
                          </div>
                        </div>
                    </div>
                    <?php echo csrf_field(); ?>

                      <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          <div class="form-group row">
                              <label for="published" class="col-md-2"><?php echo e(trans('labels.type')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <select id="type" class="form-control " name="type" required="">
                                  <option disabled="" selected="" value=""><?php echo e(trans('labels.selectType')); ?></option>
                                  <option value="1"><?php echo e(trans('labels.user')); ?></option>
                                  <option value="2"><?php echo e(trans('labels.showRoomAdmin')); ?></option>
                                  <option value="3"><?php echo e(trans('labels.StoreAdmin')); ?></option>
                                  <option value="4"><?php echo e(trans('labels.rentalCompanies')); ?></option>
                                </select>
                              </div>
                          </div>
                         
                          <div class="form-group row" id="user" >
                            <label for="published" class="col-md-2"><?php echo e(trans('labels.user')); ?><span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select  class="field select2"  name="user[]"  id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectUser')); ?>">
                                <option value="alluser" ><?php echo e(trans('labels.allUsers')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e(@$users->id); ?>" ><?php echo e(@$users->username); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                          </div>
                          </div>
                          <div class="form-group row" id="ShowRoomAdmin" >
                            <label for="published" class="col-md-2"><?php echo e(trans('labels.showRoomAdmin')); ?><span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="ShowRoomAdmin[]"  id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectShowRoomAdmin')); ?>">
                                <option value="allshowRoomAdmin" ><?php echo e(trans('labels.allshowRoomAdmin')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $ShowRoomAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ShowRoomAdmins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e(@$ShowRoomAdmins->myid); ?>" ><?php echo e(@$ShowRoomAdmins->first_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                          </div>
                          </div>

                          <div class="form-group row" id="StoreAdmin" >
                            <label for="published" class="col-md-2"><?php echo e(trans('labels.store')); ?><span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="StoreAdmin[]"  id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.SelectStore')); ?>">
                                <option value="allStoreAdmin" ><?php echo e(trans('labels.allStoreAdmin')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $StoreAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $StoreAdmins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e(@$StoreAdmins->myid); ?>" ><?php echo e(@$StoreAdmins->first_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                          </div>
                          </div>

                          <div class="form-group row" id="company" >
                            <label for="published" class="col-md-2"><?php echo e(trans('labels.rentalCompanies')); ?><span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="company[]"  id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCompany')); ?>">
                                <option value="allcompany" ><?php echo e(trans('labels.allcompany')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e(@$companys->myid); ?>" ><?php echo e(@$companys->first_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                          </div>
                          </div>


                          <div class="form-group row">
                              <label for="name" class="col-md-2"><?php echo e(trans('labels.notification')); ?><span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="notification" class="form-control " required></textarea>
                              </div>
                          </div>

                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-10">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1"><?php echo e(trans('labels.save')); ?></button>
                               
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

$(document).ready(function() {
    $("#user").hide();
    $("#ShowRoomAdmin").hide();
    $("#StoreAdmin").hide();
    $("#company").hide();

    $('#type').change(function(){
        if($(this).val() == '1'){
          $("#user").show();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").hide();
          $("#company").hide();

        }else if($(this).val() == '2'){
          $("#user").hide();
          $("#ShowRoomAdmin").show();
          $("#StoreAdmin").hide();
          $("#company").hide();
        }else if($(this).val() == '3'){
          $("#user").hide();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").show();
          $("#company").hide();
        }else if($(this).val() == '4'){
          $("#user").hide();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").hide();
          $("#company").show();
        }
               
    });
  
});    
</script> 

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>