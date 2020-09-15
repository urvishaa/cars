<?php $__env->startSection('content'); ?>
<?php 
    $firstName = $carBooking->firstName ? $carBooking->firstName : '';
    $lastName = $carBooking->lastName ? $carBooking->lastName : '';
    $email = $carBooking->email ? $carBooking->email : '';
    $phone = $carBooking->phone ? $carBooking->phone : '';
    $dateFrom = $carBooking->dateFrom ? $carBooking->dateFrom : '';
    $dateTo = $carBooking->dateTo ? $carBooking->dateTo : '';
    
    $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
    $carName = $carObj ? $carObj->car_name : ''; 
    $countryObj = $carBooking->hasOneCountry ? $carBooking->hasOneCountry : '';
    $countryName = $countryObj ? $countryObj->countries_name : '';
?>



<div class="panel panel-default carbookcls">
    <div class="panel-body">
        <div id="car-list-area" class="section-padding">
        
            <?php if(session()->has('message')): ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo e(session()->get('message')); ?>

            </div>
            <?php endif; ?>
            
            <?php if(session()->has('errorMessage')): ?>
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(session()->get('errorMessage')); ?>

                </div>
            <?php endif; ?>
            <div class="box-header-main" style="box-shadow: none;"><h3 class="page-title"><?php echo e(trans('labels.orderDetails')); ?></h3>    
                <p><a href="<?php echo e(route('carBooking.list')); ?>" class="btn btn-success"><?php echo e(trans('labels.cancel')); ?></a>
                </div>
            
            
            <div class="bookcarcls">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Car List Content Start -->
                        <div class="col-md-6 car-detl-cls">
                            <div class="form-group">
                                <label><?php echo e(trans('labels.name')); ?> :</label><span><?php echo e($firstName); ?></span>                                        
                            </div>
                            <div class="form-group">                    
                                <label><?php echo e(trans('labels.email')); ?> :</label><span><?php echo e($email); ?></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(trans('labels.phone')); ?> :</label><span><?php echo e($phone); ?></span>
                            </div>
                            <div class="form-group">                        
                                <label><?php echo e(trans('labels.dateFrom')); ?> :</label><span><?php echo e($dateFrom); ?></span>
                            </div>
                            <div class="form-group">
                                
                                <label><?php echo e(trans('labels.dateTo')); ?> :</label><span><?php echo e($dateTo); ?></span>
                            </div>
                                
                            <div class="form-group">
                                <label><?php echo e(trans('labels.car')); ?> :</label><span><?php echo e($carName); ?></span>
                            </div>
                                
                            <div class="form-group">
                                <label><?php echo e(trans('labels.Country')); ?> :</label><span><?php echo e($countryName); ?></span>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(trans('labels.status')); ?> :</label>
                                <select name="status" id="" class="select2 form-control" onchange="changeStatus('<?php echo e(route("rentalCar.status",['id'=>$carBooking->id])); ?>',this.value)">
                                    <option value="">--<?php echo e(trans('labels.orderStatus')); ?>--</option>
                                    <option value="Pending" <?php if($carBooking->status == 'Pending'): ?>selected <?php endif; ?>><?php echo e(trans('labels.Pending')); ?></option>
                                    <option value="Accepted" <?php if($carBooking->status == 'Accepted'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Accepted')); ?></option>
                                    <option value="Deliver It" <?php if($carBooking->status == 'Deliver It'): ?> selected <?php endif; ?>><?php echo e(trans('labels.Deliver It')); ?></option>
                                    <option value="Rejected" <?php if($carBooking->status =='Rejected'): ?> selected='selected'<?php endif; ?>><?php echo e(trans('labels.rejected')); ?></option>                                                                                                              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="car-details-content">
                                <!--Thumbnail slider container--> 
                                <div class="thumbnail-slider-container"> 
                                   <div class="lcnc-imgs">
                                    <h3>License</h3>    
                                    <?php 
                                        $licenseObj = $carBooking->hasManyLicense ? $carBooking->hasManyLicense : '';                 
                                        if(count($licenseObj)){
                                            foreach($licenseObj as $license){
                                               $licenseImage = $license->license ? $license->license : '';
                                        ?>
                                                <div class="lcnc-imgs-img"> 
                                                    <img src="<?php echo e(url('/public/driverLicense/'.$licenseImage)); ?>" width="100px" height="100px" alt='JSOFT'> 
                                                </div> 
                                      <?php } 
                                       }
                                    ?> 
                                   </div> 
                                </div>
                                <div class="thumbnail-slider-container"> 
                                   <div class="lcnc-imgs">
                                    <h3>Upload Id</h3>    
                                      
                                   <?php 
                                        $uploadObj = $carBooking->hasManyUploadId ? $carBooking->hasManyUploadId : '';

                                        if(count($uploadObj)){
                                            foreach($uploadObj as $uploadImage){ 
                                            $uploadImg = $uploadImage->image ? $uploadImage->image : '';
                                                ?>
                                            <div class="lcnc-imgs-img"> 
                                            <img src="<?php echo e(url('/public/uploadId/'.$uploadImg)); ?>" width="100px" height="100px" alt='JSOFT'> 
                                            </div> 
                                        <?php } 
                                        }?> 
                                   </div> 
                                </div>
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
                      <?php 
                        $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
                        $carName = $carObj ? $carObj->car_name : '';
                        $yearOfCar = $carObj ? $carObj->year_of_car : '';
                        $monthRentPrice = $carObj ? $carObj->month_rentprice : 0;
                        $dailyRentPrice = $carObj ? $carObj->daily_rentprice : 0;
                        $weeklyRentPrice = $carObj ? $carObj->weekly_rentprice : 0;
                        $salePrice = $carObj ? $carObj->sale_price : 0;
                        $brandName = $modelName = $cityName = '';
                        if($carObj != ''){
                            // echo count($carObj);exit;
                            $brandObj = $carObj->hasOneCarBrand ? $carObj->hasOneCarBrand : '';
                            $brnadName = $brandObj ? $brandObj->name : '';
                            $modelObj = $carObj->hasOneCarModel ? $carObj->hasOneCarModel : '';
                            $modelName = $modelObj ? $modelObj->name : '';
                            $cityObj = $carObj->hasOneCarCity ? $carObj->hasOneCarCity : '';
                            $cityName = $cityObj ? $cityObj->name : '';
                        }
                        $imageObj = $carObj->hasManyCarImage ? $carObj->hasManyCarImage : '';
                      ?>
                      <div class="col-md-6 car-detl-cls">
                          <div class="form-group">
                              <label><?php echo e(trans('labels.carName')); ?></label><span><?php echo e($carName); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.year')); ?></label><span><?php echo e($yearOfCar); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.carBrand')); ?></label><span><?php echo e($brnadName); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.model')); ?></label><span><?php echo e($modelName); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.city')); ?></label><span><?php echo e($cityName); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.dailyRentPrice')); ?></label><span><?php echo e($dailyRentPrice); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.weeklyRentPrice')); ?></label><span><?php echo e($weeklyRentPrice); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.monthRentPrice')); ?></label><span><?php echo e($monthRentPrice); ?></span>                                        
                          </div>
                          <div class="form-group">
                              <label><?php echo e(trans('labels.salePrice')); ?></label><span><?php echo e($salePrice); ?></span>                                        
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="car-main-imgcls">
                              <div class="car-det-cls"> 
                              <?php if(count($imageObj)): ?>
                                <?php if(file_exists(public_path().'/carImage/')): ?>
                                    <img src="<?php echo e(url('/public/carImage/'.$imageObj[0]->img_name)); ?>" alt="JSOFT"> 
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
    </div>    
</div>



    <script type="text/javascript">    
    function changeStatus(urls,status){
     
        jQuery.ajax({
            type: "GET",
            url: urls,
            data: {'status' : status},
            success: function(res){
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>