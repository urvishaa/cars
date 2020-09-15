@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);

 ?>
    <section id="slideslow-bg1">
        
        <div class="main-slider owl-carousel owl-theme">
            <div class="item">
               <img src="{{ $new.'/resources/assetsite/img/slider-img/slider-img-1.jpg'}}">
            </div>
            <div class="item">
               <img src="{{ $new.'/resources/assetsite/img/slider-img/slider-img-2.jpg'}}">
            </div>
            <div class="item">
               <img src="{{ $new.'/resources/assetsite/img/slider-img/slider-img-3.jpg'}}">
            </div>
            <div class="item">
               <img src="{{ $new.'/resources/assetsite/img/slider-img/slider-img-4.jpg'}}">
            </div>
        </div>
        <div class="slideshowcontent">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <h1>BOOK A CAR TODAY!</h1>
                                <p>FOR AS LOW AS $10 A DAY PLUS 15% DISCOUNT <br> FOR OUR RETURNING CUSTOMERS</p>

                                <div class="search-ur-car">
                                    <form action="index2.html">
                                        <div class="s-brand search-item">
                                            <select class="custom-select">
                                              <option selected>Brand</option>
                                              <option value="1">Brand</option>
                                              <option value="2">Brand</option>
                                              <option value="3">Brand</option>
                                              <option value="3">Brand</option>
                                            </select>
                                        </div>

                                        <div class="s-model search-item">
                                            <select class="custom-select">
                                              <option selected>Model</option>
                                              <option value="1">Model</option>
                                              <option value="2">Model</option>
                                              <option value="3">Model</option>
                                              <option value="3">Model</option>
                                            </select>
                                        </div>

                                        <div class="s-year search-item">
                                            <select class="custom-select">
                                              <option selected>Year</option>
                                              <option value="1">Year</option>
                                              <option value="2">Year</option>
                                              <option value="3">Year</option>
                                              <option value="3">Year</option>
                                            </select>
                                        </div>

                                        <div class="s-city search-item">
                                            <select class="custom-select">
                                              <option selected>City</option>
                                              <option value="1">City</option>
                                              <option value="2">City</option>
                                              <option value="3">City</option>
                                            </select>
                                        </div>

                                        <div class="main-srch-btn search-item">
                                            <button type="submit">Book Car</button>
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
                        <h2>Our Services</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>

            <!-- Service Content Start -->
            <div class="row text-center">
                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="service-item">
                        <i class="fab fa-opencart"></i>
                        <h3>Sell / Buy Car</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="service-item">
                        <i class="far fa-building"></i>
                        <h3>Rental Companies</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="service-item">
                        <i class="fas fa-building"></i>
                        <h3>Showroom</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <div class="service-item">
                        <i class="fas fa-shopping-basket"></i>
                        <h3>Store</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
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
                        <h2>Sell / Buy Car</h2>
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
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div> 
                                </div>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                   </div>
                                </div>
                                <div class="item">
                                    <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}">
                                                   <img src="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div> 
                                </div>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                   </div>
                                </div>
                                <div class="item">
                                    <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}">
                                                   <img src="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div> 
                                </div>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}">
                                                    <img src="{{ $new.'/resources/assetsite/img/car/car-2.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                   </div>
                                </div>
                                <div class="item">
                                    <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}">
                                                   <img src="{{ $new.'/resources/assetsite/img/car/car-3.jpg'}}" alt="JSOFT">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="#">Dodge Ram 1500</a>
                                                    <span class="price"><i class="fa fa-tag"></i> $55/day</span>
                                                </h3>

                                                <h5>HATCHBACK</h5>

                                                <div class="p-car-feature">
                                                    <a href="#">2017</a>
                                                    <a href="#">manual</a>
                                                    <a href="#">AIR CONDITION</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            </div>
                                <!-- Choose Cars Content-wrap -->
                               
                    </div>
                </div>
                <!-- Choose Area Content End -->
            </div>
        </div>
    </section>
    <!--== Choose Car Area End ==-->
    <section class=" section-padding car-tre">
        <div class="container">
            <div class="bant-tre">
                  <img src="{{ $new.'/resources/assetsite/img/banner-part.png'}}">
            </div>
        </div>
    </section>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2>Rental Companies</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part">
                <div class="owl-carousel owl-theme car-rent">
                    <div class="item">
                        <div class="img_real_home">
                            <div class="img_real">
                                <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                            </div>
                            <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>                           
                                                </ul>

                                            </div>
                                        </div>
                                 </div>
                        </div>
                    <div class="item">
                        <div class="img_real_home">
                        <div class="img_real">
                            <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                        </div>
                        <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>                           
                                                </ul>

                                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="item">
                        <div class="img_real_home">
                        <div class="img_real">
                            <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                        </div>
                        <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>                       
                                                </ul>

                                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div></div>
                   </div>
                <div class="col-md-6">

                    <div class="section-title  text-center">
                        <h2>Showrooms</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>

                    <div class="showroom-part">
                
                <div class="owl-carousel owl-theme show-part">
                    <div class="item">
                        <div class="img_real_home">
                        <div class="img_real">
                            <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                        </div>
                        <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>  
                                                </ul>

                                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="item">
                        <div class="img_real_home">
                        <div class="img_real">
                            <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                        </div>
                        <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>  
                                                </ul>

                                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="item">
                        <div class="img_real_home">
                        <div class="img_real">
                            <img src="{{ $new.'/resources/assetsite/img/simple_agent.png'}}">
                        </div>
                        <div class="real_content">
                            
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                    <li class="esta_li">
                                                        <a href="#">Real estate offices Name</a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="tel:012345-01234">
                                                            <i class="fas fa-phone-alt"></i><span>012345-01234</span>
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="esta_li telp">
                                                        <a href="mailto:abc@gmail.com">
                                                            <i class="fas fa-envelope"></i><span>abc@gmail</span>
                                                        </a>
                                                    </li>  
                                                </ul>

                                            </div>
                        </div>
                    </div>
                    </div>
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
                        <h2>About us</h2>
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
                               <img src="{{ $new.'/resources/assetsite/img/home-2-about.png'}}" alt="JSOFT">
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- About Content End -->

                <!-- About Video Start -->
                <div class="col-lg-6">
                     <div class="about-content">
                                <p>Lorem simply dummy is a texted of the printing costed and typesetting
                           industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since the 1500s, when an unknown printer took a galley of type.
                        Lorem simply dummy is a texted of the printing costed and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since the 1500s, when an unknown printer took a galley of type.</p>
                    </div>
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
                        <h2>Download Iraq Car Application</h2>
                        <p>Nulla aliquet bibendum sem, non placerat risus venenatis at. Prae sent vulputate bibendum dictum. Cras at vehiculaurna. Suspendisse fringilla lobortis justo,</p>
                        <div class="app-btns">
                            <a href="#"><i class="fab fa-android"></i> Android Store</a>
                            <a href="#"><i class="fab fa-apple"></i> Apple Store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
// setTimeout(function(){  $(".fixmycls").addClass("bodycls"); }, 1000);
   
          $(".fixmycls").addClass("bodycls");
          
    </script>

  

@endsection