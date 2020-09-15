<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $contact = DB::table('get_touch')->first();
?>     
     
    <!--== Footer Area Start ==-->
    <section id="footer-area">
        <!-- Footer Widget Start -->
        <div class="footer-widget-area">
            <div class="container">
                <div class="row">
                    <!-- Single Footer Widget Start -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-widget">
                            <h2>{{ trans('labels.iraqcar') }}</h2>
                            <div class="widget-body">
                                <p><?php echo preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", @$contact->description); ?></p>
                                <div class="footer-icons">
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Footer Widget End -->

                    <!-- Single Footer Widget Start -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-widget">
                            <h2>{{ trans('labels.carsType') }}</h2>
                            <div class="widget-body">
                                <ul class="recent-post">
                                    <li>
                                        <a href="{{ url('/storeadminlist') }}">
                                           {{ trans('labels.store') }}
                                           <i class="fas fa-long-arrow-alt-right"></i>
                                       </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('companyadminlist') }}">
                                          {{ trans('labels.rentalCompanies') }}
                                           <i class="fas fa-long-arrow-alt-right"></i>
                                       </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/sell-list') }}">
                                           {{ trans('labels.sellBuyCar') }}
                                           <i class="fas fa-long-arrow-alt-right"></i>
                                       </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Single Footer Widget End -->

                    <!-- Single Footer Widget Start -->
                    <div class="col-lg-4 col-md-6">
                        <div class="single-footer-widget">
                            <h2>{{ trans('labels.getTouch') }}</h2>
                            <div class="widget-body">
                                <ul class="get-touch">
                                    <li><span><i class="fa fa-mobile-alt"></i></span><label>{{$contact->phone ? $contact->phone : ''}}</label></li>
                                    <li><span><i class="far fa-envelope"></i></span><label>{{$contact->email ? $contact->email : ''}}</label></li>
                                    <li><span><i class="fa fa-map-marker-alt"></i></span><label>{{$contact->address ? $contact->address : ''}}</label></li>
                                    
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Single Footer Widget End -->
                </div>
            </div>
        </div>
        <!-- Footer Widget End -->

        <!-- Footer Bottom Start -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-hg">
                    <div class="foot-left">
                        <p>&copy;<script>document.write(new Date().getFullYear());</script> {{ trans('labels.Iraq Car | All rights reserved') }}</p>
                    </div>
                    <div class="foot-right">
                        <ul>
                          <li><a href="{{ url('terms') }}">{{ trans('labels.Terms of User') }}</a></li>
                          <li><a href="{{ url('privacy_policy') }}">{{ trans('labels.Privacy Statement') }}</a></li>
                          <li><a href="{{ url('user_agreement') }}">{{ trans('labels.User Agreement') }}</a></li>
                        </ul>
                      
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom End -->
    </section>
    <!--== Footer Area End ==-->

    <!--== Scroll Top Area Start ==-->
    <div class="scroll-top">
        <img src="{{ $new.'/resources/assetsite/img/scroll-top.png'}}" alt="JSOFT">
    </div>
    <!--== Scroll Top Area End ==-->

    <!--=======================Javascript============================-->
    <!--=== Jquery Min Js ===-->

    <!--=== FontAwesome Js ===-->
    <script src="{{ $new.'/resources/assetsite/fonts/fontawesome/js/all.min.js'}}"></script>
    <!--=== Jquery Migrate Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/jquery-migrate.min.js'}}"></script>
    <!--=== Popper Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/popper.min.js'}}"></script>
    <!--=== Bootstrap Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/bootstrap.min.js'}}"></script>
    <!--=== Gijgo Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/gijgo.js'}}"></script>
    <!--=== Vegas Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/vegas.min.js'}}"></script>
    <!--=== Isotope Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/isotope.min.js'}}"></script>
    <!--=== Owl Caousel Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/owl.carousel.min.js'}}"></script>
    <!--=== Waypoint Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/waypoints.min.js'}}"></script>
    <!--=== CounTotop Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/counterup.min.js'}}"></script>
    <!--=== YtPlayer Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/mb.YTPlayer.js'}}"></script>
    <!--=== Magnific Popup Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/magnific-popup.min.js'}}"></script>
    <!--=== Slicknav Min Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/plugins/slicknav.min.js'}}"></script>
    
    <!--=== Mian Js ===-->
    <script src="{{ $new.'/resources/assetsite/js/main.js'}}"></script>
   <script type="text/javascript">
       $('.car-rent').owlCarousel({
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            dots:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
   </script>
   <script type="text/javascript">
        $('.show-part').owlCarousel({
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            dots:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
   </script>
   <script type="text/javascript">
        $('.choose-car-info').owlCarousel({
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            dots:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        })
   </script>
   <script type="text/javascript">
        $('.main-slider').owlCarousel({
            loop:true,
            margin:0,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:false,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            dots:false,
            nav:false,
            navSpeed: 500,

            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })






   </script>
