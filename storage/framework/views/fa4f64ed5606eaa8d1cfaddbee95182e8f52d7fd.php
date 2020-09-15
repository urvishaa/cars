<?php //echo '<pre>'; print_r($car_img); die; ?>

<?php $__env->startSection('iamge'); ?>
  <?php if(count($car_img) > 0): ?> 
    <?php if(file_exists(public_path().'/carImage/'.$car_img[0]->img_name)  && $car_img[0]->img_name != ''): ?>
      <?php echo asset('').'public/carImage/'.@$car_img[0]->img_name ;?>
    <?php else: ?> 
      <?php echo URL::to('/public/default-image.jpeg'); ?>
    <?php endif; ?> 
  <?php else: ?>
  <?php echo URL::to('/public/default-image.jpeg'); ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
  <?php if($car_Detail->car_name != ''): ?>
    <?php echo @$car_Detail->car_name; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

 <?php $__env->startSection('description'); ?>
  <?php if($car_Detail->description != ''): ?>
    <?php echo @$car_Detail->description; ?>
  <?php else: ?>
   <?php echo "Iraq car"; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('content'); ?>
<?php $session = Session::all(); ?>


<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d73ab59ab6f1000123c8260&product=inline-share-buttons' async='async'></script>
<section id="car-list-area" class="section-padding">
        <div class="container">
            <div class="car-mode car-deta-res">
                            <div class="car-mdel">
                                <h4><?php echo $car_Detail->car_name; ?></h4>
                            </div>
                             <div class="regis">
                                <h4><?php
                                if ($car_Detail->sale_price != "") {
                                	echo "$ ".$car_Detail->sale_price;	
                                } else {
                                	echo "";
                                } 
                                ?></h4>
                                
                            </div>
                        </div>
            <div class="row">
                <!-- Car List Content Start -->
                <div class="col-lg-8">
                    <div class="car-details-content">
                        
                        <!--Main Slider Container--> 
                        <div class="detail-slider-container"> 
                           <!--Main Slider Start--> 
                           <div id="detail-slider" class="slider owl-carousel"> 
                           	<?php 
                            
                            if (count($car_img) > 0) { 
                                    foreach ($car_img as $key => $value) { ?>
                               		<div class="item"> 
                                     	<img src="<?php echo e(url('/public/carImage/'.$value->img_name )); ?>" alt="JSOFT">
                                  	</div> 
                           		<?php } 
                                } else { ?>
                                    <img src="<?php echo e(url('/public/default-image.jpeg' )); ?>" alt="JSOFT">
                                <?php } ?>
                           </div> 
                           <!--Main Slider End-->
                        </div> 


                        <!--Thumbnail slider container--> 
                        <div class="thumbnail-slider-container"> 
                           <div id="thumbnailSlider" class="thumbnail-slider owl-carousel">
                              
                              <?php 
                            
                            if (count($car_img) > 0) { 
                                    foreach ($car_img as $key => $value) { ?>
                                    <div class="item"> 
                                        <img src="<?php echo e(url('/public/carImage/'.$value->img_name )); ?>" alt="JSOFT">
                                    </div> 
                                <?php } 
                                } else { ?>
                                    <img src="<?php echo e(url('/public/default-image.jpeg' )); ?>" alt="JSOFT">
                                <?php } ?>
                           </div> 
                        </div>

                        <div class="car-details-info blog-content tert-ert">
                            <h3><?php echo e(trans('labels.description')); ?></h3>
                            <p><?php echo $car_Detail->description; ?></p>
						</div>
                    </div>
                </div>
                <!-- Car List Content End -->

                <!-- Sidebar Area Start -->
                <div class="col-lg-4">
                    <div class="sidebar-content-wrap m-t-50">
                        <!-- Single Sidebar Start -->
                        	
                        <div class="sidebar-left">
                             <div class="estate_real">
                                <ul class="esta_ul">
                                    <li class="esta_li telp">
                                       <a href="#">

                                            <label><i class="fa fa-map-marker-alt"></i></label><span><?php echo $car_Detail->googleLocation; ?>
                                            </span>
                                        </a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="tel:012345-01234">
                                            <label><i class="fas fa-mobile-alt"></i></label><span><?php echo $car_Detail->phone; ?>
                                            </span>
                                        </a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="mailto:abc@gmail.com"><label><i class="far fa-envelope"></i></label><span><?php echo $car_Detail->email; ?></span></a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <!-- Single Sidebar End -->

                        <!-- Single Sidebar Start -->
                        
                        <div class="car-details-inr">
                          <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.year')); ?></h4> 
                             </div>
                             
                             <div class="car-det-inr right">
                                 <h4><?php 
                                    if ($car_Detail->year_of_car) {
                                        echo $car_Detail->year_of_car; 
                                    } else {
                                        echo "---";
                                    }
                                 ?></h4>
                             </div>
                          </div>
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.carBrand')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo $car_Detail->carbrandName; ?></h4>
                             </div>
                          </div>
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.model')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo $car_Detail->modelName; ?></h4>
                             </div>
                          </div> 
                          <!-- <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.image')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4>50000</h4>
                             </div>
                          </div>  -->
                          
                          <?php if($car_Detail->city !="" || $car_Detail->city_ku !="" || $car_Detail->cityname !="") { ?>
                          <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.city')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($car_Detail->city_ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($car_Detail->city_ku); ?> <?php else: ?> <?php echo e($car_Detail->cityname); ?> 
                                    <?php endif; ?></h4>
                             </div>
                          </div>
                      <?php } ?>
                      <?php if($car_Detail->pro_type == '1'): ?>
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.salePrice')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php 
                                 if ($car_Detail->sale_price != "") {
                                 	echo $car_Detail->sale_price;
                                 } else {
                                 	echo "";
                                 } ?></h4>
                             </div>
                          </div> 
                       <?php elseif($car_Detail->pro_type == '2'): ?> 

                       		<?php if($car_Detail->daily_rentprice != '' AND $car_Detail->daily_rentprice > 0): ?> 
	                        <div class="car-det-inr">
	                            <div class="car-det-inr left">
	                                <h4><?php echo e(trans('labels.dailyRentPrice')); ?></h4> 
	                            </div>
	                            <div class="car-det-inr right">
	                                 <h4><?php echo e($car_Detail->daily_rentprice); ?></h4>
	                            </div>
	                        </div> 
	                        <?php endif; ?>   

	                        <?php if($car_Detail->weekly_rentprice != '' AND $car_Detail->weekly_rentprice > 0): ?>
	                        <div class="car-det-inr">
	                            <div class="car-det-inr left">
	                                <h4><?php echo e(trans('labels.weeklyRentPrice')); ?></h4> 
	                            </div>
	                            <div class="car-det-inr right">
	                                 <h4><?php echo e($car_Detail->weekly_rentprice); ?></h4>
	                            </div>
	                        </div>  
	                        <?php endif; ?>  

	                        <?php if($car_Detail->month_rentprice != '' AND $car_Detail->month_rentprice > 0): ?>
	                        <div class="car-det-inr">
	                            <div class="car-det-inr left">
	                                <h4><?php echo e(trans('labels.monthRentPrice')); ?></h4> 
	                            </div>
	                            <div class="car-det-inr right">
	                                 <h4><?php echo e($car_Detail->month_rentprice); ?></h4>
	                            </div>
	                        </div>    
	                        <?php endif; ?>

                       <?php endif; ?>                
                                
                        </div>
                        <!-- Single Sidebar End -->
                        <div class="sharethis-inline-share-buttons" id="myDIV"></div>
                        <!-- Single Sidebar Start -->
                        <div class="var-launch">
                            <?php 
                            	if ($car_Detail->video != '') {
	                            	$url = $car_Detail->video ;
                            		if (substr($url, 0, 7) == "http://" || substr($url, 0, 8) == "https://")
                    								{	
                										$url = explode("/", $url);
                										$urlchange = explode("=", $url['3']);

                										if ($urlchange['0'] == 'watch?v') {
                											$embed = 'http://youtube.com/embed/'.$urlchange['1'];
                										} 	
                									}
                            	}
                            	
                            ?>

                            <div class="sidebar-body">
                            	<?php 
                            		if (!empty($embed)) { ?>
                            			<iframe  height="250" src="<?php echo $embed; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>		
                            		<?php }
                            	 ?>
                               
                            </div>
                        </div>
                        <!-- Single Sidebar End -->
                    </div>
                </div>
                <!-- Sidebar Area End -->
            </div>
        </div>
    </section>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".upload_id").empty();
        $(".uploadDrivingLicense").empty();
      });

        function uploadId(input){
          loadFile2('.upload_id',input)
        }
        function uploadDrivingLicense(input){
          loadFile2('.uploadDrivingLicense',input)
        }
      function loadFile2(id,input) {
          if (input.files && input.files[0]) {
              var files = input.files.length;
              for (i = 0; i < files; i++) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $('<div class="id_image"><img style="height:100px; width:100px;" id="output2" src=' + e.target.result +'>'+
                      '<button onclick="removeImageClass(this)" >x</button></div>').appendTo(id);
                    }
                  reader.readAsDataURL(input.files[i]);
              }

          }
      }          
      function removeImageClass(obj){          
        $(obj).closest("div").remove();
      }
    
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>