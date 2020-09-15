@extends('layout')
@section('content')
<?php
$urlnew = url('');
$new = str_replace('index.php', '', $urlnew);
$session = Session::all();
?>

<section id="detail-part" class="section-padding detail-part">
    <div class="container">
        <div class="section-title  text-center sthowroom-detail">
            <div class="show-ret">
                <h2>showrooms</h2>
            </div>
            <div class="show-select">
                
                <select>
                    <option value="volvo">City</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
                
            </div>
        </div>
        <div class="row">
            <!-- Car List Content Start -->
            <div class="col-lg-5">
                <div class="detail-car car-deta-res">
                    <div class="img_real_home Car-rent">
                        <div class="img_real">
                            <img src="assets/img/simple_agent.png">
                        </div>
                        <div class="real_content">
                            
                            <div class="estate_real">
                                <ul class="esta_ul">
                                    
                                    <li class="esta_li">
                                        <a href="#">sanvi patel</a>
                                        
                                    </li>
                                    
                                    <li class="esta_li telp">
                                        <a href="tel:8795463210">
                                            <i class="fa fa-phone-alt"></i><span>465565565</span>
                                        </a>
                                        
                                    </li>
                                    
                                    <li class="esta_li telp">
                                        <i class="fa fa-envelope"></i><span>sanvi@gmail.com</span></a>
                                    </li>
                                    
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tag_price listing_price detail_rent agent">
                        <a href="#"><i class="fas fa-comment-dots"></i>Contact Agent</a>
                    </div>
                </div>
                
            </div>
            <!-- Car List Content End -->
            <!-- Sidebar Area Start -->
            <div class="col-lg-7">
                <div class="derti-app">
                    <div class="details-content">
                        <h2>About Iraq cars</h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        
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
                    <div class="section_title_container text-center deals">
                        <div class="section_subtitle">The Best deals</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-3.jpg">
                                        <img src="assets/img/car/car-3.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price"><i class="fa fa-tag"></i>$55/day</span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-2.jpg">
                                        <img src="assets/img/car/car-2.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price"><i class="fa fa-tag"></i>$55/day</span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-1.jpg">
                                        <img src="assets/img/car/car-1.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price">
                                        <i class="fa fa-tag"></i>$55/day
                                    </span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-3.jpg">
                                        <img src="assets/img/car/car-3.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price"><i class="fa fa-tag"></i>$55/day</span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-2.jpg">
                                        <img src="assets/img/car/car-2.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price"><i class="fa fa-tag"></i>$55/day</span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-popular-car">
                                <div class="p-car-thumbnails">
                                    <a class="car-hover" href="assets/img/car/car-1.jpg">
                                        <img src="assets/img/car/car-1.jpg" alt="JSOFT">
                                    </a>
                                </div>
                                <div class="p-car-content">
                                    <h3>
                                    <a href="#">Dodge Ram 1500</a>
                                    <span class="price">
                                        <i class="fa fa-tag"></i>$55/day
                                    </span>
                                    </h3>
                                    <h5><i class="fas fa-map-marker-alt"></i> HATCHBACK</h5>
                                    <div class="p-car-feature">
                                        <a href="#">2017</a>
                                        <a href="#">manual</a>
                                        <a href="#">AIR CONDITION</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
</section>

@endsection