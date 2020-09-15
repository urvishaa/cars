<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

<div class="myordr-list section-padding">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2><?php echo e(trans('labels.bookingDetail')); ?></h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                </div>
            </div>
            <!-- Section Title End -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if(Session::has('message')): ?>
                    <div class="alert alert-info">
                        <p><?php echo e(Session::get('message')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div> 
        <!-- <div class="row">       
            <div class="col-lg-12 bg-white rounded shadow-sm">  
               
                <div class="col-lg-6 col-md-6">
                        
                    <div class="rent-part">
                            
                        <div class="real_content">
                            
                            <div class="estate_real detail">
                               <div class="user-deatils">
                                  <h4 style="color: #363636;">Contact Agent</h4>
                                  <div class="user-deti">
                                    <div class="user-info">
                                        <p><label>First Name:</label>
                                            <span>Alexa</span></p>
                                     </div>
                                     <div class="user-info">
                                        <p><label>Last Name:</label>
                                            <span>Liza</span></p>
                                     </div>
                                     <div class="user-info">
                                        <p><label>Email:</label>
                                            <span>Alex@gmail.com</span></p>
                                     </div>  
                                    <div class="user-info">
                                        <p><label>Nationality:</label>
                                            <span>Alex@gmail.com</span></p>
                                     </div>
                                    <div class="user-info">
                                        <p><label>Phone:</label>
                                            <span>0123456789</span></p>
                                     </div>
                                      <div class="user-info">
                                        <p><label>Phone:</label>
                                            <span>0123456789</span></p>
                                     </div>

                                  </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
           
            </div>
        </div> -->

        <div class="bookcarcls">
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="panel-heading">
                          <div class="form-group">
                              <label><?php echo e(trans('labels.myDetails')); ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label><?php echo e(trans('labels.name')); ?> :</label><span><?php echo e($detail->firstName); ?> <?php echo e($detail->lastName); ?></span>                                        
                          </div>
                          <div class="form-group">                    
                              <label><?php echo e(trans('labels.email')); ?> :</label><span><?php echo e($detail->email); ?></span>
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.phone')); ?> :</label><span><?php echo e($detail->phone); ?></span>
                          </div>
                          <div class="form-group">                        
                              <label><?php echo e(trans('labels.dateFrom')); ?> :</label><span><?php echo e($detail->dateFrom); ?></span>
                          </div>
                          <div class="form-group">
                              
                              <label><?php echo e(trans('labels.dateTo')); ?> :</label><span><?php echo e($detail->dateTo); ?></span>
                          </div>
                          <?php if($detail->nationality != '' AND $detail->nationality > 0): ?>
                            <?php @$nationalitys = DB::table('countries')->where('countries_id',@$detail->nationality)->first(); ?>
                          <?php endif; ?>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.Country')); ?> :</label><span><?php echo e($nationalitys->countries_name); ?></span>
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.status')); ?> :</label><span><?php echo e($detail->status); ?></span>
                          </div>
                         <!--  <div class="form-group">
                              <label>Status :</label>
                              <span>Pendig</span>
                          </div> -->
                      </div>
                      <div class="col-md-6">
                          <div class="car-details-content">
                              <!--Thumbnail slider container--> 
                              <div class="thumbnail-slider-container"> 
                                 <div class="lcnc-imgs">
                                  <h3>License</h3> 
                                    <?php $__empty_1 = true; $__currentLoopData = $licence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ln): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                        <?php if(file_exists(public_path().'/driverLicense/'.$ln->license)): ?>
                                        <div class="lcnc-imgs-img"> 
                                          <img src="<?php echo e(url('/public/driverLicense/'.$ln->license)); ?>" alt="JSOFT"> 
                                         
                                        </div> 
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                     
                                 </div> 
                              </div>
                              <div class="thumbnail-slider-container"> 
                                 <div class="lcnc-imgs">
                                  <h3>Upload Id</h3>    
                                    
                                                                             
                                    <?php $__empty_1 = true; $__currentLoopData = $uploadid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                        <?php if(file_exists(public_path().'/uploadId/'.$uid->image)): ?>
                                        <div class="lcnc-imgs-img"> 
                                          <img src="<?php echo e(url('/public/uploadId/'.$uid->image)); ?>" alt="JSOFT"> 
                                        </div> 
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                       
                                 </div> 
                              </div>
                              <!-- <div class="car-details-info blog-content tert-ert">
                                  <h3>Car</h3>
                                  <p>new add car</p>
                              </div> -->
                          </div>
                      </div>
                    </div>
                    <div class="row">                      
                      <div class="col-md-12">
                        <div class="panel-heading">
                          <div class="form-group">
                              <label><?php echo e(trans('labels.carDetails')); ?></label>
                          </div>
                        </div>
                      </div>

                      <?php if($detail->prop_category != '' AND $detail->prop_category > 0): ?>
                          <?php @$carmodel = DB::table('car_model')->where('id',@$detail->prop_category)->first(); ?>
                      <?php endif; ?>

                      <?php if($detail->car_brand != '' AND $detail->car_brand > 0): ?>
                          <?php @$carbrand = DB::table('car_brand')->where('id',@$detail->car_brand)->first(); ?>
                      <?php endif; ?>

                       <?php if($detail->city != '' AND $detail->city > 0): ?>
                         <?php @$city = DB::table('city')->where('id',$detail->city)->first(); ?>         
                      <?php endif; ?>

                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label><?php echo e(trans('labels.carName')); ?></label><span><?php echo e($detail->car_name); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.year')); ?></label><span><?php echo e($detail->year_of_car); ?></span>                                        
                          </div>
                          <div class="form-group">                    
                              <label><?php echo e(trans('labels.carBrand')); ?></label><span><?php echo e(@$carbrand->name); ?></span>
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.carModel')); ?></label><span><?php echo e(@$carmodel->name); ?></span>
                          </div>
                          <div class="form-group">        

                                     
                          <label><?php echo e(trans('labels.city')); ?></label><span><?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></span>
                          </div>
                          <div class="form-group">
                              
                              <label><?php echo e(trans('labels.dailyRentPrice')); ?></label><span><?php echo e($detail->daily_rentprice ? $detail->daily_rentprice : '0'); ?></span>
                          </div>
                              
                          <div class="form-group">
                              <label><?php echo e(trans('labels.weeklyRentPrice')); ?></label><span><?php echo e($detail->weekly_rentprice ? $detail->weekly_rentprice : '0'); ?></span>
                          </div>
                              
                          <div class="form-group">
                              <label><?php echo e(trans('labels.monthRentPrice')); ?></label><span><?php echo e($detail->month_rentprice ? $detail->month_rentprice : '0'); ?></span>
                          </div>
                      </div>
                      <div class="col-md-6 ">
                          <div class="car-main-imgcls ">
                          
                                
                                  <?php if($image != ''): ?>
                                    <?php if(file_exists(public_path().'/carImage/'.$image->img_name)): ?>
                                      <img src="<?php echo e(url('/public/carImage/'.$image->img_name)); ?>" alt="JSOFT"> 
                                    <?php else: ?>
                                      <img src="<?php echo e(url('/public/default-image.jpeg')); ?>" alt="JSOFT"> 
                                    <?php endif; ?>
                                  <?php endif; ?>
                                  
                          </div>
                      </div>
                    </div>
                </div>
            </div>
    </div>
</div>


<?php $__env->stopSection(); ?>




<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>