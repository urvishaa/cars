<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  $data = $result['companydetail'];

?>
  <?php //echo '<pre>'; print_r($data); die;?>

<?php //echo '<pre>'; print_r($data->image); die; ?>
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
                    <?php if(count($result['companyProperty'])): ?>
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.thebestdeals')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <?php endif; ?>
                        <div class="row">
                          <?php   //echo '<pre>'; print_r($result['companyProperty']); die; ?>
                            <?php $__currentLoopData = $result['companyProperty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyPropertys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php  // echo '<pre>'; print_r($companyPropertys); die; ?>
                            <?php @$modelName = DB::table('property_category')->where('id',$companyPropertys['prop_category'])->first(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-popular-car">
                                    <div class="p-car-thumbnails">
                                        <a  href="<?php echo e(URL::to('/car_Detail/'.$companyPropertys['id'])); ?>">  
                                          <?php @$image = DB::table('property_img')->where('property_id',$companyPropertys['id'])->first(); ?>
                            
                              
                                              <?php if(file_exists(public_path().'/propertyImage/'.@$image->img_name) AND @$image->img_name != ''): ?>
                                                     <img src="<?php echo e(URL::to('/public/propertyImage/'.@$image->img_name)); ?>">                              
                                              <?php else: ?> 
                                                      <img src="<?php echo e(URL::to('/public/default-image.jpeg')); ?>" >                                 
                                              <?php endif; ?>
                                          </a> 
                                       
                                    </div>

                                    <div class="p-car-content">
                                        <h3>
                                            <a href="<?php echo e(URL::to('/rentalcar_detail/'.$companyPropertys['id'])); ?>"><?php echo e(@$companyPropertys['property_name']); ?></a>
                                         
                                          <?php if($companyPropertys['pro_type'] == '1'): ?> 
                                              <?php if($companyPropertys['sale_price'] !=''): ?><span class="price">$<?php echo e(@$companyPropertys['sale_price']); ?></span><?php endif; ?>
                                          <?php elseif($companyPropertys['pro_type'] == '2'): ?>
                                              <?php if($companyPropertys['month_rentprice'] !=''): ?><span class="price">$<?php echo e(@$companyPropertys['month_rentprice']); ?></span><?php endif; ?>
                                          <?php endif; ?>
                                        </h3>

                                        <h5><i class="fas fa-map-marker-alt"></i> <?php echo e($companyPropertys['googleLocation']); ?></h5>


                                        <div class="p-car-feature">
                                        <?php if($companyPropertys['year_of_car'] != ''): ?><a href="javascript:void(0)"><?php echo e(@$companyPropertys['year_of_car']); ?></a><?php endif; ?>

                                        <?php if($companyPropertys['gear_type'] == 'Automatic'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Automatic')); ?></a><?php elseif($companyPropertys['gear_type'] == 'Manual'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Manual')); ?></a><?php endif; ?>

                                        <?php if($companyPropertys['pro_type'] == '1'): ?> 
                                           <a href="javascript:void(0)"><?php echo e(trans('labels.sale')); ?></a>
                                        <?php elseif($companyPropertys['pro_type'] == '2'): ?>
                                           <a href="javascript:void(0)"><?php echo e(trans('labels.rent')); ?></a>
                                        <?php endif; ?>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            


                           
                        </div>
                        <div style="margin-bottom: 25px;"> <?php echo e(@$result['companyProperty']->links('vendor.pagination.default')); ?></div>
                </div>             
            </div>
          </div>          
        </div>
          
    </section>

   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>