  <?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
?>

    <!--== Preloader Area Start ==-->
    <div class="preloader">
        <div class="preloader-spinner">
            <div class="loader-content">
                <img src="{{ $new.'/resources/assetsite/img/preloader.gif'}}" alt="JSOFT">
            </div>
        </div>
    </div>
    <!--== Preloader Area End ==-->

    <!--== Header Area Start ==-->
    <header id="header-area" class="fixed-top">
        <!--== Header Top Start ==-->
        <div id="header-top" class="d-none d-xl-block">
            <div class="container">
                <div class="top-head">
                    <!--== Single HeaderTop Start ==-->
                    <div class="top-head-txt">
                        <i class="fas fa-map-marker-alt"></i> 802/2, Mirpur, Dhaka
                    </div>
                    <!--== Single HeaderTop End ==-->

                    <!--== Single HeaderTop Start ==-->
                    <div class="top-head-txt">
                        <i class="fas fa-mobile-alt"></i> +1 800 345 678
                    </div>
                    <!--== Single HeaderTop End ==-->


                    <!--== Social Icons End ==-->
                </div>
            </div>
        </div>
        <!--== Header Top End ==-->

        <!--== Header Bottom Start ==-->
        <div id="header-bottom">
            <div class="container">
                <div class="row">
                    <!--== Logo Start ==-->
                    <div class="col-lg-1">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{ $new.'/resources/assetsite/img/logo.png'}}" alt="JSOFT">
                        </a>
                    </div>
                    <!--== Logo End ==-->

                    <!--== Main Menu Start ==-->
                    <div class="col-lg-11 d-none d-xl-block">
                        <div class="cart">
                            <a href="javascript:void(0)">
                                <i class="fab fa-opencart"></i>
                                <div class="cart-counter">
                                    <span>3</span>
                                </div>
                            </a>
                        </div>
                        <nav class="mainmenu alignright">
                            <ul>
                                <li class="active"><a href="{{url('/')}}">Home</a></li>
                                <li><a href="{{url('/showroomlist')}}">Sell / Buy Car</a></li>
                                <li><a href="{{url('/showroomlist')}}">Rental Companies</a></li>
                                <li><a href="{{url('/showroomlist')}}">Car Showrooms</a></li>
                                <li><a href="{{url('/storeadminlist')}}">Store</a></li>
                                <li><a href="#">Contact</a></li>
                                <li class="lang-headcls">

                                  @if(isset($session['language']) AND $session['language'] == 'en')
                                  
                                  <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/british.png') }}">{{ trans('labels.En') }}</a>
                                    
                                  @elseif(isset($session['language']) AND $session['language'] == 'ku')

                                  <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/kurdish.jpg') }}">{{ trans('labels.Ku') }}</a>

                                  @else
                                  
                                     <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/arabic.png') }}">{{ trans('labels.Ar') }}</a>
                                  @endif
                                  
                                  <ul class="dropdown-menu">
                                    <li><a href="{{ URL::to('/changelang/en') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/british.png') }}">{{ trans('labels.En') }}</li></a>
                                    <li><a href="{{ URL::to('/changelang/ar') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/arabic.png') }}">{{ trans('labels.Ar') }}</li></a>
                                    <li><a href="{{ URL::to('/changelang/ku') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/kurdish.jpg') }}">{{ trans('labels.Ku') }}</li></a>
                                  </ul>
                                </li>
                                <li><a href="#">My Acount <i class="fas fa-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="{{url('/login')}}">Login</a></li>
                                        <li><a href="{{url('/register')}}">Registration</a></li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </nav>                        
                    </div>
                    <!--== Main Menu End ==-->
                </div>
            </div>
        </div>
        <!--== Header Bottom End ==-->
    </header>
    <!--== Header Area End ==-->

    <!--== SlideshowBg Area Start ==-->