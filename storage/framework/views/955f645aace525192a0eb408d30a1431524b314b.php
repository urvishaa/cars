<?php $__env->startSection('content'); ?>

  <!-- Content Header (Page header) -->
 

  <section class="content-header">
    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.StoreAdmin')); ?> </h3></div>
  </section>
 
<?php 
$urlnew = url(''); 
$new = str_replace('index.php', '', $urlnew); 
?>

  <!-- Main content -->
  <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/resources/views/admin/images/admin_profile/default-image.jpeg'; ?>"   alt="profile picture">

              <h3 class="profile-username text-center"></h3>

              <p class="text-muted text-center"><?php echo e(trans('labels.Administrator')); ?></p>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab"><?php echo e(trans('labels.Profile')); ?></a></li>
              
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">
                  
                  <!-- The timeline -->
                   <?php echo Form::open(array('url' =>'admin/StoreAdmin', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','validate')); ?>

                            
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.AdminFirstName')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="first_name" id="first_name" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminFirstNameText')); ?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php echo e(trans('labels.LastName')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="last_name" id="last_name" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminLastNameText')); ?></span>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php echo e(trans('labels.Email')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminEmailText')); ?></span>
                        </div>
                      </div>

                      
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Picture')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="file" name="newImage" id="newImage" value="" class="">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.PictureText')); ?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.Address')); ?> <span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control" required autofocus></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AddressText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label"><?php echo e(trans('labels.description')); ?> <span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control" required autofocus></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.DescriptionText')); ?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.City')); ?><span style="color: red">*</span></label>
                        <div class="col-sm-10">                       
                            <select class="field select2 form-control" name="city[]" autofocus required id="mainProId" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCity')); ?>">
                                     <?php $__empty_1 = true; $__currentLoopData = $result['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                        <?php if(isset($setProperty) !=''): ?>
                                          <option value="<?php echo e($city->id); ?>"  <?php if(in_array($city->id, $setProperty)): ?> <?php echo e('selected'); ?> <?php endif; ?> ><?php echo e($city->name); ?></option>
                                        <?php else: ?>
                                          <option value="<?php echo e($city->id); ?>"><?php echo e($city->name); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                    <?php endif; ?>  
                              </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.selectCity')); ?></span>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Country')); ?><span style="color: red">*</span></label>
                        <div class="col-sm-10">                       
                            <select class="form-control" name="country" id="entry_country_id" onchange="zones(this)" required autofocus>
                                <option value=""><?php echo e(trans('labels.SelectCountry')); ?></option>
                                <?php $__currentLoopData = $result['countries']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($countries->countries_id); ?>"><?php echo e($countries->countries_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.CountryText')); ?></span>
                        </div>
                      </div>

                     
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.ZipCode')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="zip" id="zip" value="" class="form-control" required autofocus>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.Phone')); ?><span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="phone" id="phone" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.PhoneText')); ?></span>
                        </div>
                      </div>

                  
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="category"><?php echo e(trans('labels.proCategory')); ?> <span class="clsred">*</span></label>
                            <div class="col-sm-10">
                            <select class="field select2 form-control" name="category[]" autofocus required id="category" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>">
                                <?php $__empty_1 = true; $__currentLoopData = $result['procategory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($pro->id); ?>"><?php echo e($pro->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>  
                            </select>
                        </div>   
                      </div>                     

                      <div class='form-horizontal'>
                        <div class="form-group">
                          <label for="password" class="col-sm-2 control-label"><?php echo e(trans('labels.NewPassword')); ?><span style="color: red">*</span></label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo e(trans('labels.newPassword')); ?>" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                            <span style="display: none" class="help-block"></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label for="re-password" class="col-sm-2 control-label"><?php echo e(trans('labels.Re-EnterPassword')); ?><span style="color: red">*</span></label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="re_password" name="re_password" placeholder="<?php echo e(trans('labels.reEnterPassword')); ?>" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                            <span style="display: none" class="help-block"></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger"><?php echo e(trans('labels.save')); ?></button>
                          </div>
                        </div>
                      </div>


                      
                      
                    
              </div>
              <!-- /.tab-pane -->

              
                  <?php echo Form::close(); ?>

                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  </section>
  <!-- /.content --> 


<script type="text/javascript">
  function zones(zone_val)
  {
    var zone = zone_val.value;
     
    $.ajax({
        url: "<?php echo e(url('/admin/StoreAdmin/zones')); ?>",
        data: { zone_val: zone },
        type: "post",
        success: function(data){
          //alert(data); 
          $('#zoneId').html(data);
        }
    });

  }
</script>


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>