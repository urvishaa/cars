<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
 ?>
    <section id="slideslow-bg1">
        
        <div class="main-slider owl-carousel owl-theme">
           
            <?php $__empty_1 = true; $__currentLoopData = $result['homeslide']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if(file_exists(public_path().'/homeslide/'.@$hm->image)  AND @$hm->image != ''): ?>
                <div class="item">
                   <img src="<?php echo e(URL::to('/public/homeslide/'.@$hm->image)); ?>">
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="item">
               <img src="<?php echo e($new.'/resources/assetsite/img/slider-img/slider-img-4.jpg'); ?>">
            </div>
            <?php endif; ?>
           
            
        </div>
        <div class="slideshowcontent">
            <div class="container">
            
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <?php if(!empty($result['homeslide'])): ?>
                                <?php $sl = $result['homeslide'][0]; ?>
                                <h1> <?php if($session['language']=='en'): ?> <?php echo e($sl->title); ?> <?php elseif($session['language']=='ku'): ?> <?php echo e($sl->titlekurdish); ?> <?php else: ?> <?php echo e($sl->titlearabic); ?> <?php endif; ?></h1>
                                <p><?php if($session['language']=='en'): ?> <?php echo e(strip_tags($sl->description)); ?> <?php elseif($session['language']=='ku'): ?> <?php echo e(strip_tags($sl->descriptionkurdish)); ?> <?php else: ?> <?php echo e(strip_tags($sl->descriptionarabic)); ?> <?php endif; ?></p>
                                <?php endif; ?>

                                <div class="search-ur-car">
                                    <form action="<?php echo e(url('/sell-list/sell-list')); ?>" method="GET" >
                                        <div class="s-brand search-item">
                                            <select class="custom-select" name="brand" onchange="filterCategory(this.value)">
                                                <option value=""><?php echo e(trans('labels.carBrand')); ?></option>
                                                <?php $__empty_1 = true; $__currentLoopData = $result['brand']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                      <option value="<?php echo e($brands->id); ?>"> <?php echo e($brands->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="s-model search-item">
                                            <select class="custom-select" name="category" id="filterCategorys">
                                              <option value=""><?php echo e(trans('labels.selectCategoryType')); ?></option>
                                                
                                            </select>
                                        </div>

                                        <div class="s-year search-item">
                                            <select class="custom-select" name="year">
                                              <option value=""><?php echo e(trans('labels.yearOfCar')); ?></option>
                                              <?php $__empty_1 = true; $__currentLoopData = $result['year']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $years): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                    <option value="<?php echo e($years); ?>"> <?php echo e($years); ?> </option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                              <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="s-city search-item">
                                            <select class="custom-select" name="city">
                                                <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                                <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                      <option value="<?php echo e($city->id); ?>"> <?php if($session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif($session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="main-srch-btn search-item">
                                            <button type="submit"><i class="fas fa-search"></i><?php echo e(trans('labels.search')); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== SlideshowBg Area End ==-->

    <!--== Services Area Start ==-->
    <section id="service-area" class="section-padding">
        <div class="container">
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-lg-12">
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.ourServices')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>

            <!-- Service Content Start -->
            <div class="row text-center">
                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="<?php echo e(URL::to('sell-list')); ?>">
                    <div class="service-item">
                        <i class="fab fa-opencart"></i>
                        <h3><?php echo e(trans('labels.sellBuyCar')); ?></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                    </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="<?php echo e(URL::to('companyadminlist')); ?>">
                    <div class="service-item">
                        <i class="far fa-building"></i>
                        <h3><?php echo e(trans('labels.rentalCompanies')); ?></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                    </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="<?php echo e(URL::to('showroomlist')); ?>">
                    <div class="service-item">
                        <i class="fas fa-building"></i>
                        <h3><?php echo e(trans('labels.showRooms')); ?></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="<?php echo e(URL::to('storeadminlist')); ?>">
                    <div class="service-item">
                        <i class="fas fa-shopping-basket"></i>
                        <h3><?php echo e(trans('labels.store')); ?></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </a>
                </div>
                <!-- Single Service End -->
            </div>
            <!-- Service Content End -->
        </div>
    </section>
    <!--== Services Area End ==-->

    <!--== Choose Car Area Start ==-->
    <section id="choose-car" class="section-padding choose-ur-cars">
        <div class="container">
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-lg-12">
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.sellBuyCar')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>

            <div class="row">
                <!-- Choose Area Content Start -->
                <div class="col-lg-12">
                    <div class="choose-ur-cars">
                       
                            <div class="choose-car-info owl-carousel owl-theme">
                               <?php $__empty_1 = true; $__currentLoopData = $result['sellcar']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sellcars): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                               <?php @$modelName = DB::table('car_model')->where('id',$sellcars->prop_category)->first(); ?>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                    <a href="<?php echo e(URL::to('/car_Detail/'.$sellcars->id)); ?>">
                                                    <?php $image = DB::table('car_img')->where('car_id',@$sellcars->id)->first(); ?>

                                                    <?php if(file_exists(public_path().'/carImage/'.@$image->img_name)  AND @$image->img_name != ''): ?>

                                                        <img src="<?php echo e(URL::to('/public/carImage/'.$image->img_name)); ?>" >
                                                    <?php else: ?>
                                                        
                                                        <img src="<?php echo e($new.'/resources/assetsite/img/car/car-1.jpg'); ?>" alt="JSOFT">
                                                    <?php endif; ?>
                                                </a>
                                                 <?php if($sellcars->pro_type != ''): ?> 
                                                     <div class="list-rest">
                                                    <a href="javascript:void(0)">
                                                        <?php if($sellcars->pro_type == '1'): ?> 
                                                           <?php echo e(trans('labels.forsale')); ?>

                                                        <?php elseif($sellcars->pro_type == '2'): ?>
                                                           <?php echo e(trans('labels.forrent')); ?>

                                                        <?php endif; ?>
                                                    </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                           

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="<?php echo e(URL::to('/car_Detail/'.$sellcars->id)); ?>"><?php echo e(@$sellcars->car_name); ?></a>
                                                    <?php if($sellcars->pro_type == '1'): ?> 
                                                        <?php if($sellcars->sale_price !=''): ?><span class="price">$<?php echo e(@$sellcars->sale_price); ?></span><?php endif; ?>
                                                    <?php elseif($sellcars->pro_type == '2'): ?>
                                                        <?php if($sellcars->month_rentprice !=''): ?><span class="price">$<?php echo e(@$sellcars->month_rentprice); ?></span><?php endif; ?>
                                                    <?php endif; ?>
                                                    
                                                </h3>

                                                <h5><i class="fas fa-map-marker-alt"></i> <?php echo e(@$sellcars->googleLocation); ?> </h5>

                                                <div class="p-car-feature">
                                                    <?php if($sellcars->year_of_car !=''): ?><a href="javascript:void(0)"><?php echo e($sellcars->year_of_car); ?></a><?php endif; ?>
                                                    <?php if($sellcars->gear_type == 'Automatic'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Automatic')); ?></a><?php elseif($sellcars->gear_type == 'Manual'): ?><a href="javascript:void(0)"><?php echo e(trans('labels.Manual')); ?></a><?php endif; ?>

                                                    <?php if($session['language'] == 'en'): ?>
                                                      <a href="javascript:void(0)"><?php echo e(@$modelName->name); ?></a>
                                                    <?php elseif($session['language'] == 'ku'): ?>
                                                      <a href="javascript:void(0)"><?php echo e(@$modelName->ku); ?></a>
                                                    <?php else: ?>
                                                      <a href="javascript:void(0)"><?php echo e(@$modelName->ar); ?></a>
                                                    <?php endif; ?>

                                                    

                                                </div>
                                            </div>
                                        </div> 
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>

                            </div>
                             
                               
                    </div>
                </div>
            
            </div>
        </div>
    </section>
    <!--== Choose Car Area End ==-->
    <section class=" section-padding car-tre">
        <div class="container">
            <div class="bant-tre owl-carousel owl-theme property-slider1">
                <?php $__empty_1 = true; $__currentLoopData = $result['ban']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                    <?php if(file_exists(public_path('/dsaImage/'.@$bann->image)) AND @$bann->image !='' ): ?>
                    <img src="<?php echo e(URL::to('/public/dsaImage/'.@$bann->image)); ?>" alt="">
                    <?php endif; ?>
                     
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
                 
            </div>
        </div>
    </section>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.rentalCompanies')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part">
                <div class="owl-carousel owl-theme car-rent">
                    <?php //echo '<pre>'; print_r($result['company']); die; ?>
                    <?php $__empty_1 = true; $__currentLoopData = $result['company']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="item">
                        <div class="img_real_home">
                            <div class="img_real">
                                 <a href="<?php echo e(URL::to('/companyList/'.$companies->myid)); ?>">
                                <?php if(file_exists(@$companies->image) AND @$companies->image != ''): ?>
                                    <img src="<?php echo e(URL::to('/'.$companies->image)); ?>" >
                                <?php else: ?>
                                    <img src="<?php echo e($new.'/public/default-image.jpeg'); ?>">
                                <?php endif; ?>
                            </a>
                            </div>
                            <div class="real_content">
                            
                                <div class="estate_real">
                                    <ul class="esta_ul">
                                        <li class="esta_li">
                                            <a href="<?php echo e(URL::to('/companyList/'.$companies->myid)); ?>"><?php echo e(@$companies->first_name); ?>  <?php echo e(@$companies->last_name); ?></a>
                                            
                                        </li>
                                        <?php if($companies->phone != ''): ?>
                                        <li class="esta_li telp">
                                            <a href="tel:012345-01234">
                                                <i class="fas fa-phone-alt"></i><span><?php echo e(@$companies->phone); ?></span>
                                            </a>
                                            
                                        </li>
                                        <?php endif; ?>
                                        <?php if($companies->email != ''): ?>

                                        <li class="esta_li telp">
                                            <a href="mailto:abc@gmail.com">
                                                <i class="fas fa-envelope"></i><span><?php echo e(@$companies->email); ?></span>
                                            </a>
                                        </li>    
                                        <?php endif; ?>
                                                               
                                    </ul>

                                </div>
                            </div>
                     </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?> 

                </div>
                </div>
                </div>
                <div class="col-md-6">

                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.showRooms')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>

                    <div class="showroom-part">
                
                <div class="owl-carousel owl-theme show-part">
                    
                    <?php $__empty_1 = true; $__currentLoopData = $result['showroom']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $showrooms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="item">
                        <div class="img_real_home">
                            <div class="img_real">
                            <a href="<?php echo e(URL::to('/showroomList/'.$showrooms->myid)); ?>">
                            <?php if(file_exists(@$showrooms->image)  AND @$showrooms->image != ''): ?>
                                <img src="<?php echo e(URL::to('/'.$showrooms->image)); ?>" id="chimg">
                            <?php else: ?>
                                <img src="<?php echo e($new.'/public/default-image.jpeg'); ?>">
                            <?php endif; ?>
                            </a>  
                            </div>
                        <div class="real_content">
                            
                            <div class="estate_real">
                                <ul class="esta_ul">
                                    <li class="esta_li">
                                        <a href="<?php echo e(URL::to('/showroomList/'.$showrooms->myid)); ?>"><?php echo e(@$showrooms->first_name); ?>  <?php echo e(@$showrooms->last_name); ?></a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="tel:012345-01234">
                                            <i class="fas fa-phone-alt"></i><span><?php echo e(@$showrooms->phone); ?></span>
                                        </a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="mailto:abc@gmail.com">
                                            <i class="fas fa-envelope"></i><span><?php echo e(@$showrooms->email); ?></span>
                                        </a>
                                    </li>  
                                </ul>

                            </div>
                        </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>

                </div></div></div>
           </div>
        </div>
    </section>

  <section id="about-area" class="section-padding abt-gerpri">
        <div class="container">
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-lg-12">
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.about')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>
             <div class="row abt-inr-main">
                <!-- About Content Start -->
                <div class="col-lg-6">
                    <div class="display-table">
                        <div class="display-table-cell">
                            <div class="about-image">

                            <?php if(file_exists(public_path().'/aboutImage/'.$result['about']->image)  && $result['about']->image != ''): ?>
                                <img src="<?php echo e(URL::to('/public/aboutImage/'.$result['about']->image)); ?>" id="chimg">
                            <?php else: ?>
                               <img src="<?php echo e($new.'/resources/assetsite/img/home-2-about.png'); ?>" alt="JSOFT">
                            <?php endif; ?>
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- About Content End -->

                <!-- About Video Start -->
                <div class="col-lg-6">
                     <div class="about-content">
                        <?php //echo '<pre>'; print_r($result['about']); die; ?>
                        <?php echo substr($result['about']->description,0,500); ?>
                            <?php if(strlen($result['about']->description)>500): ?>
                            <?php @$content = $result['about']->description; ?>
                            <p style="display: none" id="testa"><?php echo substr( preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", @$content),500); ?></p>
                           
                            <?php endif; ?>
                            
                    </div>
                    <?php if(strlen($result['about']->description)>500): ?>
                    <div  class="button intro_button"><a href="javascript:void(0)"  id="test"><?php echo e(trans('labels.READ MORE')); ?></a></div>
                    <?php endif; ?>
                </div>
                <!-- About Video End -->
            </div>
        </div>
    </section>

    <!--== Mobile App Area Start ==-->
        <section id="mobile-app-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mobile-app-content">
                        <h2><?php echo e(trans('labels.DownloadIraqCarApplication')); ?></h2>
                        <p><?php echo e(trans('labels.Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy & sell')); ?></p>
                        <div class="app-btns">
                            <a href="javascript:void(0)"><i class="fab fa-android"></i><?php echo e(trans('labels.androidStore')); ?></a>
                            <a href="javascript:void(0)"><i class="fab fa-apple"></i><?php echo e(trans('labels.appleStore')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
// setTimeout(function(){  $(".fixmycls").addClass("bodycls"); }, 1000);
   
          $(".fixmycls").addClass("bodycls");


     $(document).ready(function(){
        $("a#test").click(function(){
          // alert('hii');
          $("#testa").toggle();
        
        });
        
      });
    
    </script>

<script type="text/javascript">
function filterCategory(name){
    jQuery("#filterCategorys").empty();
    jQuery.ajax({
        type: "GET",
        url: '<?php echo e(route("category.filter")); ?>',
        data: {'id':name},
        success: function(res){
            jQuery("#filterCategorys").html(res);
        }
    });
}
  $(document).ready(function()
{
  "use strict";
  initpropertySlider();
  function initpropertySlider()
  {
    if($('.property-slider1').length)
    {
      var propSlider = $('.property-slider1');
      propSlider.owlCarousel(
      {
        autoplay:true,
        autoplayHoverPause:true,
        loop:true,
        nav:false,
        dots:true,
        smartSpeed:1000,
        responsive:{
              0:{
                  items:1,
              },
              // 768:{
              //     items:2,
              // },
              // 1000:{
              //     items:3,
              // }
          }
      });
    }
  }

});
</script>
  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>