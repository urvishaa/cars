<?php $__env->startSection('content'); ?>

  <!-- Content Header (Page header) -->

  <?php 
    if (isset($message)) { ?>
      <div class="alert alert-danger" role="alert">
        <span><?php echo $message ?></span>
      </div>
    <?php }
   ?>

  <section class="content-header">
    <div class="box-header-main"><h3 class="page-title"> <?php echo e(trans('labels.StoreAdmin')); ?> </h3></div>
  </section>
  
  <!-- Main content -->
  <section class="content">

      <div class="row">
        <div class="col-md-3">
<?php 
$urlnew = url(''); 
$new = str_replace('index.php', '', $urlnew); 
?>
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <?php if($ShowRoomAdmin->image != ""): ?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/'.$ShowRoomAdmin->image; ?>" alt="<?php echo $ShowRoomAdmin->first_name; ?> profile picture">
              <?php else: ?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/resources/views/admin/images/admin_profile/default-image.jpeg'; ?>"   alt="profile picture">
              <?php endif; ?>
              <h3 class="profile-username text-center"><?php echo $ShowRoomAdmin->first_name.' '.$ShowRoomAdmin->last_name; ?></h3>

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
              <li><a href="#passwordDiv" data-toggle="tab"><?php echo e(trans('labels.Password')); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">
                 
                <!-- The timeline -->
                    <form action="<?php echo e(url('admin/StoreAdmin/updateShowRoomAdmin/'.$ShowRoomAdmin->myid)); ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                   
                            
                            <?php echo Form::hidden('oldImage', $ShowRoomAdmin->image, array('class'=>'form-control', 'id'=>'oldImage')); ?>


                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.AdminFirstName')); ?></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="first_name" id="first_name" value="<?php echo $ShowRoomAdmin->first_name ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminFirstNameText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php echo e(trans('labels.LastName')); ?></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="last_name" id="last_name" value="<?php echo $ShowRoomAdmin->last_name ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminLastNameText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label"><?php echo e(trans('labels.Email')); ?></label>
    
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" value="<?php echo $ShowRoomAdmin->email ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AdminEmailText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Picture')); ?>

                        </label>
    
                        <div class="col-sm-10">
                            <input type="file" name="newImage" id="newImage">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.PictureText')); ?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label"><?php echo e(trans('labels.Address')); ?> </label>
    
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control"><?php echo $ShowRoomAdmin->address ?></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.AddressText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label"><?php echo e(trans('labels.description')); ?> <span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control"><?php echo $ShowRoomAdmin->description ?></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.DescriptionText')); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.City')); ?></label>
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
                        <label for="inputSkills" class="col-sm-2 control-label"><?php echo e(trans('labels.Country')); ?></label>
                        <div class="col-sm-10">                       
                            <select class="form-control" name="country" id="entry_country_id" onchange="zones(this.value)">
                                <option value=""><?php echo e(trans('labels.SelectCountry')); ?></option>
                                <?php if($ShowRoomAdmin->country != ""): ?>
                                    <?php $__currentLoopData = $result['countries']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($ShowRoomAdmin->country==$countries->countries_id): ?> selected <?php endif; ?> value="<?php echo e($countries->countries_id); ?>"><?php echo e($countries->countries_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.CountryText')); ?></span>
                        </div>
                      </div>

                      
                      

                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.ZipCode')); ?></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="zip" id="zip" value="<?php echo $ShowRoomAdmin->zip ?>" class="form-control">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label"><?php echo e(trans('labels.Phone')); ?></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="phone" id="phone" value="<?php echo $ShowRoomAdmin->phone ?>" class="form-control">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            <?php echo e(trans('labels.PhoneText')); ?></span>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="category" class="col-sm-2 control-label"><?php echo e(trans('labels.proCategory')); ?> <span class="clsred">*</span></label>
                        <div class="col-sm-10">
                        <select class="field select2 form-control" name="category[]" autofocus required id="category" multiple="multiple" data-placeholder="<?php echo e(trans('labels.selectCategoryType')); ?>">
                          <?php $ShowRoomAdmin->category = explode(',', $ShowRoomAdmin->category); ?>
                            <?php $__empty_1 = true; $__currentLoopData = $result['procategory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                <option value="<?php echo e($pro_cat->id); ?>" <?php if(in_array($pro_cat->id, $ShowRoomAdmin->category)): ?> <?php echo e('selected="selected"'); ?> <?php endif; ?> ><?php echo e($pro_cat->name); ?></option>                                  
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                            <?php endif; ?>  
                        </select>
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success"><?php echo e(trans('labels.save')); ?></button>
                        </div>
                      </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="passwordDiv">
                <form action="<?php echo e(url('admin/showRoomAdmin/updateAdminPassword/'.$ShowRoomAdmin->myid)); ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                 
                 <div class='form-horizontal'>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label"><?php echo e(trans('labels.NewPassword')); ?></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo e(trans('labels.NewPassword')); ?>">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="re-password" class="col-sm-2 control-label"><?php echo e(trans('labels.Re-EnterPassword')); ?></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="<?php echo e(trans('labels.Re-EnterPassword')); ?>">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><?php echo e(trans('labels.AdminPasswordRestriction')); ?></span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Save</button>
                    </div>
                  </div>
                </div>
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

    $.ajax({
        url: "<?php echo e(url('/admin/StoreAdmin/zones')); ?>",
        data: { zone_val: zone_val },
        type: "post",
        success: function(data){
          $('#zoneId').html(data);
        }
    });

  }
</script>



<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>