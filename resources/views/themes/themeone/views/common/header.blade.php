  
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
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
                <div class="top-header">
                    <div class="lang-chng"> 
                        <ul>
                         <li class="menu-head">

                          @if(isset($session['language']) AND $session['language'] == 'en')
                          
                          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/british.png') }}">{{ trans('labels.En') }}</a>
                            
                          @elseif(isset($session['language']) AND $session['language'] == 'ku')

                          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/kurdish.jpg') }}">{{ trans('labels.Ku') }}</a>

                          @else
                          
                             <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/arabic.png') }}">{{ trans('labels.Ar') }}</a>
                          @endif
                          
                          <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('/changelang/en') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/british.png') }}">{{ trans('labels.En') }}</a></li>
                            <li><a href="{{ URL::to('/changelang/ar') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/arabic.png') }}">{{ trans('labels.Ar') }}</a></li>
                            <li><a href="{{ URL::to('/changelang/ku') }}"><img style="margin-right: 10px" height="20px;" width="30px" src="{{ URL::to('/resources/assets/img/kurdish.jpg') }}">{{ trans('labels.Ku') }}</a></li>
                          </ul>
                        </li>
                        </ul>
                    </div>
                    <?php $contact = DB::table('get_touch')->first(); ?>

                    <div class="top-head">
                        <!--== Single HeaderTop Start ==-->
                        <div class="top-head-txt">
                            <i class="fas fa-map-marker-alt"></i> {{$contact->address ? $contact->address : ''}}
                        </div>
                        <!--== Single HeaderTop End ==-->

                        <!--== Single HeaderTop Start ==-->
                        <div class="top-head-txt">
                            <i class="fas fa-mobile-alt"></i> {{$contact->phone ? $contact->phone : ''}}
                        </div>
                        <!--== Single HeaderTop End ==-->


                        <!--== Social Icons End ==-->
                    </div>
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
                    <div class="col-lg-11 d-xl-block rspnsv-mnu">
                                <?php $carts=session()->get('cart'); ?>
                        <div class="cart">
                        	@if(!empty($carts)) 
                            <!-- @if(count($carts) != 0) -->
                                <a href="{{route('showcart')}}">
 							<!-- @endif                                	 -->
                            @else
                                <a href="javascript:void(0)">
                            @endif
                                <i class="fab fa-opencart"></i>
                                <div class="cart-counter">
                                    <span><?php if(!empty($carts)) { echo count($carts); }  ?></span>
                                </div>
                            </a>
                        </div>
                        <nav class="mainmenu alignright">
                            <ul>
                                <li class="{{ Request::segment(1) == '' ? 'active' : null }}" ><a href="{{url('/')}}">{{ trans('labels.home') }}</a></li>
                                <li class="{{ Request::segment(1) === 'sell-list' ? 'active' : null }}" ><a href="{{url('/sell-list')}}">{{ trans('labels.sellBuyCar') }}</a></li>
                                <li class="{{ Request::segment(1) === 'companyadminlist' ? 'active' : null }}" ><a href="{{url('/companyadminlist')}}">{{ trans('labels.rentalCompanies') }}</a></li>
                                <li class="{{ Request::segment(1) === 'showroomlist' ? 'active' : null }}" ><a href="{{url('/showroomlist')}}">{{ trans('labels.carShowrooms') }}</a></li>
                                <li class="{{ Request::segment(1) === 'storeadminlist' ? 'active' : null }}" ><a href="{{url('/storeadminlist')}}">{{ trans('labels.store') }}</a></li>
                                <li class="{{ Request::segment(1) === 'contactus' ? 'active' : null }}"><a href="{{url('/contactus')}}">{{ trans('labels.contact') }}</a></li>
                                <li class="{{ Request::segment(1) === 'login' ? 'active' : null }} {{ Request::segment(1) === 'register' ? 'active' : null }}" ><a href="javascript:void(0)">{{ trans('labels.myAcount') }} <i class="fas fa-chevron-down"></i></a>


                                @if(Session::get('userId'))
                                    <ul>
                                        <li><a href="{{url('/profile')}}">{{ trans('labels.Profile') }}</a></li>
                                        <li><a href="{{url('/myCar')}}">{{ trans('labels.myCar') }}</a></li>
                                        <li><a href="{{url('/order/list')}}">{{ trans('labels.myorderlist') }}</a></li> 
                                        <li><a href="{{url('/book/list')}}">{{ trans('labels.carBookList') }}</a></li> 
                                        <li><a href="{{url('/userlogout')}}">{{ trans('labels.Logout') }}</a></li>
                                    </ul>
                                @else
                                    <ul>
                                        <li><a href="{{url('/login')}}">{{ trans('labels.Login') }}</a></li>
                                        <li><a href="{{url('/register')}}">{{ trans('labels.registration') }}</a></li>
                                    </ul>
                                @endif



                                  
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