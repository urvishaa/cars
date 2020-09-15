<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  $data = $result['showroomdetail'];
   //echo '<pre>'; print_r($data); die;
?>


<?php $__env->startSection('iamge'); ?>
  <?php if(@$data->image != ''): ?> 
    <?php if(file_exists(@$data->image)  AND @$data->image != ''): ?>
     <?php echo URL::to('/'.$data->image); ?>
    <?php else: ?> 
      <?php echo URL::to('/public/default-image.jpeg'); ?>
    <?php endif; ?> 
  <?php else: ?>
  <?php echo URL::to('/public/default-image.jpeg'); ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
  <?php if(@$data->first_name != ''): ?>
    <?php echo @$data->first_name.' '.@$data->last_name ; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
 
<?php $__env->stopSection(); ?>

 <?php $__env->startSection('description'); ?>
  <?php if(@$data->phone != ''): ?>
    <?php echo @$data->phone; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
  <?php if(@$data->email != ''): ?>
    <?php echo @$data->email; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>

<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d73ab59ab6f1000123c8260&product=inline-share-buttons' async='async'></script>

 
    <section id="detail-part" class="section-padding detail-part">
        <div class="container">
            <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2><?php echo e(@$data->first_name); ?> <?php echo e(@$data->last_name); ?></h2>
                       </div>
                       <!-- <div class="show-select">
                             
                              <select>
                              <option value="volvo">City</option>
                              <option value="saab">Saab</option>
                              <option value="mercedes">Mercedes</option>
                              <option value="audi">Audi</option>
                            </select>
                          
                        </div> -->
                    </div>
            <div class="row">
                <!-- Car List Content Start -->
                <div class="col-lg-5">
                    <div class="detail-car car-deta-res">
                        <div class="img_real_home Car-rent">
                                <div class="img_real">
                                    <?php if(file_exists(@$data->image)  AND @$data->image != ''): ?>
                                    <img src="<?php echo e(URL::to('/'.$data->image)); ?>" id="chimg">
                                    <?php else: ?>
                                        <img src="<?php echo e($new.'/public/default-image.jpeg'); ?>">
                                    <?php endif; ?>
                                </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                                                                             
                                                <li class="esta_li">
                                                    <a href="javascript:void(0)"><?php echo e(@$data->first_name); ?> <?php echo e(@$data->last_name); ?> </a>
                                                    
                                                </li>
                                                                                             
                                                <?php if($data->phone != ''): ?>
                                                <li class="esta_li telp">
                                                    <a href="tel:<?php echo e(@$data->phone); ?>">
                                                       <label><i class="fa fa-mobile-alt"></i></label><span><?php echo e(@$data->phone); ?></span>
                                                    </a>
                                                    
                                                </li>
                                                <?php endif; ?>
                                                                                         
                                                <?php if($data->email != ''): ?>
                                                <li class="esta_li telp">
                                                     <a href="mailto:<?php echo e(@$data->email); ?>"><label><i class="far fa-envelope"></i></label><span><?php echo e(@$data->email); ?></span></a>
                                                </li> 
                                                <?php endif; ?>
                                                                      
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    <div class="sharethis-inline-share-buttons" id="myDIV"></div>
                                </div>               
                               <!--  <div class="tag_price listing_price detail_rent agent">
                                  <a href="#"><i class="fas fa-comment-dots"></i><?php echo e(trans('labels.contact_agent')); ?></a>
                                </div> -->
                                
                      </div>
                      
                </div>
                <!-- Car List Content End -->

                <!-- Sidebar Area Start -->
                <div class="col-lg-7">
                    <div class="derti-app">
                      <div class="details-content">
                       <h2><?php echo e(trans('labels.about')); ?></h2>
                        <?php if($data->description != ''): ?><p><?php echo e(@$data->description); ?></p><?php else: ?> <p><?php echo e(trans('labels.notAvailable')); ?></p> <?php endif; ?>
                        
                    </div>
                       
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--== Car List Area End ==-->
    <section class="detail-term">
        <div class="container">
          <div class="details gerti tert-ert">
                           
            <div class="row">
                <div class="col-md-12">
                    <?php if(count($result['showroomCars'])): ?>
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.thebestdeals')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <?php endif; ?>
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $result['showroomCars']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $showroomCar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php @$modelName = DB::table('car_model')->where('id',$showroomCar->prop_category)->first(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-popular-car">
                                    <div class="p-car-thumbnails">
                                         <a  href="<?php echo e(URL::to('/car_Detail/'.$showroomCar->id)); ?>">  
                                          <?php $image = DB::table('car_img')->where('car_id',$showroomCar->id)->first(); 
                            
                                            if(!empty($image))
                                            {
                              
                                              if((file_exists(public_path().'/carImage/'.$image->img_name)))
                                                  {     
                                                      ?>                              
                                                   <img src="<?php echo e(URL::to('/public/carImage/'.$image->img_name)); ?>">                          
                                                 <?php } 
                                                  else 
                                                  {   ?>                                 
                                                      <img src="<?php echo e(URL::to('/public/default-image.jpeg')); ?>" >                                
                                                <?php  }
                                              }  
                                              else
                                              { ?>
                                                  
                                                <img src="<?php echo e(URL::to('/public/default-image.jpeg')); ?>" >
                                             <?php }  ?>
                                       </a> 
                                        <?php if($showroomCar->pro_type != ''): ?>     
                                        <div class="list-rest">
                                            <a href="javascript:void(0)">
                                              <?php if($showroomCar->pro_type == '1'): ?> 
                                                 <?php echo e(trans('labels.forsale')); ?>

                                              <?php elseif($showroomCar->pro_type == '2'): ?> 
                                                 <?php echo e(trans('labels.forrent')); ?>

                                              <?php endif; ?>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    

                                    <div class="p-car-content">
                                        <h3>
                                            <a href="<?php echo e(URL::to('/car_Detail/'.$showroomCar->id)); ?>"><?php echo e(@$showroomCar->car_name); ?></a>
                                            <?php if($showroomCar->pro_type == '1'): ?> 
                                                <?php if($showroomCar->sale_price !=''): ?><span class="price">$<?php echo e(@$showroomCar->sale_price); ?></span><?php endif; ?>
                                            <?php elseif($showroomCar->pro_type == '2'): ?>
                                                <?php if($showroomCar->month_rentprice !=''): ?><span class="price">$<?php echo e(@$showroomCar->month_rentprice); ?></span><?php endif; ?>
                                            <?php endif; ?>
                                           
                                        </h3>

                                        <h5><i class="fas fa-map-marker-alt"></i> <?php echo e($showroomCar->googleLocation); ?></h5>

                                        <div class="p-car-feature">
                                            <?php if($showroomCar->year_of_car !=''): ?><a href="javascript:void(0)"><?php echo e($showroomCar->year_of_car); ?></a><?php endif; ?>
                                            <?php if($showroomCar->gear_type == 'Automatic'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Automatic')); ?></a><?php elseif($showroomCar->gear_type == 'Manual'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Manual')); ?></a><?php endif; ?>
                                              
                                            <?php if(isset($session['language']) AND $session['language'] == 'en'): ?>
                                              <a href="javascript:void(0)"><?php echo e($modelName->name); ?></a>
                                            <?php elseif(isset($session['language']) AND $session['language'] == 'ku'): ?>
                                              <a href="javascript:void(0)"><?php echo e($modelName->ku); ?></a>
                                            <?php else: ?>
                                              <a href="javascript:void(0)"><?php echo e($modelName->ar); ?></a>
                                            <?php endif; ?>     

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                           
                            <?php endif; ?>
                           
                        </div>
                         <div style="margin-bottom: 25px;"> <?php echo e(@$result['showroomCars']->links('vendor.pagination.default')); ?></div>
                </div>             
            </div>
          </div>          
        </div>
          
    </section>

  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>