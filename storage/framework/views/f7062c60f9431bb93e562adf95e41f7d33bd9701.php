<?php $__env->startSection('content'); ?>
<?php $session = Session::all(); ?>
<section id="car-list-area" class="section-padding">
        <div class="container">
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
            <div class="car-mode car-deta-res">
                            <div class="car-mdel">
                                <h4><?php echo $car_Detail->car_name; ?></h4>
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
                          <?php if($car_Detail->city_ar !="" || $car_Detail->city_ku !="" || $car_Detail->cityname !="") { ?>
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
                           <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.dailyRentPrice')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo e($car_Detail->daily_rentprice ? $car_Detail->daily_rentprice : 0); ?></h4>
                             </div>
                          </div>
                          <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.weeklyRentPrice')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo e($car_Detail->weekly_rentprice ? $car_Detail->weekly_rentprice : 0); ?></h4>
                             </div>
                          </div>
                          <div class="car-det-inr">
                             <div class="car-det-inr left">
                                <h4><?php echo e(trans('labels.monthRentPrice')); ?></h4> 
                             </div>
                             <div class="car-det-inr right">
                                 <h4><?php echo e($car_Detail->month_rentprice ? $car_Detail->month_rentprice : 0); ?></h4>
                             </div>
                          </div>
                          <?php if(Session::has('userName')): ?>
                          <div class="tag_price listing_price detail_rent agent">
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#contactagent" style="width: 350px; margin-top: 20px;"><?php echo e(trans('labels.bookNow')); ?></a>
                          </div>
                          <?php else: ?>
                          <div class="tag_price listing_price detail_rent agent">
				
                              <?php  Session::put('rentalRoute',URL::to('/rentalcar_detail/'.$car_Detail->id)); ?>
                              <a href="<?php echo e(route('login')); ?>" class="btn btn-info" style="width: 350px; margin-top: 20px;"><?php echo e(trans('labels.bookNow')); ?></a>
                            </div>
                          <?php endif; ?>
                                <div id="contactagent" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 style="color: #0d83a9;"><?php echo e(trans('labels.contact_agent')); ?></h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                      <div class="modal-body">
                                          <form method="post" action="<?php echo e(route('contectagent.save')); ?>" enctype="multipart/form-data">
                                            <input type="hidden" name="carId" value="<?php echo e($car_Detail->id); ?>">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.FirstName')); ?><span style="color: red">*</span></label>
                                                  <input type="text" class="form-control" id="" placeholder="<?php echo e(trans('labels.FirstName')); ?>" name="firstName" required>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.LastName')); ?><span style="color: red">*</span></label>
                                                  <input type="text" class="form-control" id="" placeholder="<?php echo e(trans('labels.LastName')); ?>" name="lastName" required>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.Email')); ?><span style="color: red">*</span></label>
                                                  <input type="email" class="form-control" id="email" placeholder="<?php echo e(trans('labels.Email')); ?>" name="email" required>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.nationality')); ?><span style="color: red">*</span></label>
                                                    <select class="form-control" name="nationality" required>
                                                      <option selected value=""><?php echo e(trans('labels.nationality')); ?></option>
                                                      <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                      <option value="<?php echo e($val->countries_id); ?>"><?php echo e($val->countries_name); ?></option>                                           
                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>                                                          
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="pwd"><?php echo e(trans('labels.Phone')); ?><span style="color: red">*</span></label>
                                                  <input type="text" class="form-control" id="pwd" placeholder="<?php echo e(trans('labels.Phone')); ?>" name="phone" required>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.uploadId')); ?>.<span style="color: red">*</span></label>
                                                  <div class="choose-id">
                                                    <input type="file" class="" name="upload_id[]" multiple="" onchange="uploadId(this)" required> 
                                                    <label><?php echo e(trans('labels.uploadId')); ?></label>
                                                  </div>
                                                  <div id="addCar">
                                                    <div class="upload_image upload_id">                                                    
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <label><?php echo e(trans('labels.uploadDrivingLicense')); ?><span style="color: red">*</span></label>
                                                  <div class="choose-id">
                                                    <input type="file" class="" name="driving_license[]" multiple="" onchange="uploadDrivingLicense(this)" required> 
                                                    <label><?php echo e(trans('labels.uploadDrivingLicense')); ?></label>
                                                  </div>
                                                  <div id="addCar">
                                                    <div class="uploadDrivingLicense">
                                                      
                                                    </div>
                                                   </div>
                                                </div>
                                              </div>

                                             

                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <div class="date-fr">
                                                    <label><?php echo e(trans('labels.dateFrom')); ?><span style="color: red">*</span></label>
                                                    <input id="date" class="form-control" type="date" name="dateFrom" required>  
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                  <div class="date-fr">
                                                    <label><?php echo e(trans('labels.dateTo')); ?><span style="color: red">*</span></label>
                                                    <input id="date" class="form-control" type="date" name="dateTo" required> 
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" class="btn btn-default" ><?php echo e(trans('labels.book')); ?></button>
                                            </div>
                                          </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                        </div>
                        <!-- Single Sidebar End -->

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
                  var j=0;
                  reader.onload = function (e) {
                      $('<div class="upload_image id_image"><div class="mycar_image" style="float:left"><img style="height:100px; width:100px;" id="output2" src=' + e.target.result +'>'+
                      '<button onclick="removeImageClass(this,'+j+',\''+id+'\')" >x</button></div></div>').appendTo(id);
                      j ++;
                    }
                  reader.readAsDataURL(input.files[i]);
              }
          }
      }   
             
      function removeImageClass(obj,number,name){          
        
        $(obj).closest("div").remove();
      
        jQuery.ajax({
            type: "GET",
            url: '<?php echo e(route("contactAgentImage.delete")); ?>',
            data: {'number':number,'name':name},
            success: function(res){
            }
        });
      }
    
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>