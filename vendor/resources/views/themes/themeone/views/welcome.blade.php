@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
 ?>
    <section id="slideslow-bg1">
        
        <div class="main-slider owl-carousel owl-theme">
           
            @forelse($result['homeslide'] as $hm)
                @if(file_exists(public_path().'/homeslide/'.@$hm->image)  AND @$hm->image != '')
                <div class="item">
                   <img src="{{ URL::to('/public/homeslide/'.@$hm->image) }}">
                </div>
                @endif
            @empty
            <div class="item">
               <img src="{{ $new.'/resources/assetsite/img/slider-img/slider-img-4.jpg'}}">
            </div>
            @endforelse
           
            
        </div>
        <div class="slideshowcontent">
            <div class="container">
            
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="display-table">
                            <div class="display-table-cell">
                                @if(!empty($result['homeslide']))
                                <?php $sl = $result['homeslide'][0]; ?>
                                <h1> @if($session['language']=='en') {{ $sl->title }} @elseif($session['language']=='ku') {{ $sl->titlekurdish }} @else {{ $sl->titlearabic }} @endif</h1>
                                <p>@if($session['language']=='en') {{ strip_tags($sl->description) }} @elseif($session['language']=='ku') {{ strip_tags($sl->descriptionkurdish) }} @else {{ strip_tags($sl->descriptionarabic) }} @endif</p>
                                @endif

                                <div class="search-ur-car">
                                    <form action="{{ url('/sell-list/sell-list') }}" method="GET" >
                                        <div class="s-brand search-item">
                                            <select class="custom-select" name="brand" onchange="filterCategory(this.value)">
                                                <option value="">{{ trans('labels.carBrand') }}</option>
                                                @forelse($result['brand'] as $brands) 
                                                      <option value="{{ $brands->id }}"> {{ $brands->name }}</option>
                                                @empty    
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="s-model search-item">
                                            <select class="custom-select" name="category" id="filterCategorys">
                                              <option value="">{{ trans('labels.selectCategoryType') }}</option>
                                                
                                            </select>
                                        </div>

                                        <div class="s-year search-item">
                                            <select class="custom-select" name="year">
                                              <option value="">{{ trans('labels.yearOfCar') }}</option>
                                              @forelse($result['year'] as $years) 
                                                    <option value="{{ $years }}"> {{ $years }} </option>
                                              @empty    
                                              @endforelse
                                            </select>
                                        </div>

                                        <div class="s-city search-item">
                                            <select class="custom-select" name="city">
                                                <option value="">{{ trans('labels.selectCity') }}</option>
                                                @forelse($result['city'] as $city) 
                                                      <option value="{{ $city->id }}"> @if($session['language']=='ar') {{ $city->ar }} @elseif($session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                                                @empty    
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="main-srch-btn search-item">
                                            <button type="submit"><i class="fas fa-search"></i>{{ trans('labels.search') }}</button>
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
                        <h2>{{ trans('labels.ourServices') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>

            <!-- Service Content Start -->
            <div class="row text-center">
                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="{{ URL::to('sell-list') }}">
                    <div class="service-item">
                        <i class="fab fa-opencart"></i>
                        <h3>{{ trans('labels.sellBuyCar') }}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                    </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="{{ URL::to('companyadminlist') }}">
                    <div class="service-item">
                        <i class="far fa-building"></i>
                        <h3>{{ trans('labels.rentalCompanies') }}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                    </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="{{ URL::to('showroomlist') }}">
                    <div class="service-item">
                        <i class="fas fa-building"></i>
                        <h3>{{ trans('labels.showRooms') }}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit admollitia.</p>
                    </div>
                </a>
                </div>
                <!-- Single Service End -->

                <!-- Single Service Start -->
                <div class="col-lg-3 col-md-6 ">
                    <a href="{{ URL::to('storeadminlist') }}">
                    <div class="service-item">
                        <i class="fas fa-shopping-basket"></i>
                        <h3>{{ trans('labels.store') }}</h3>
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
                        <h2>{{ trans('labels.sellBuyCar') }}</h2>
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
                               @forelse($result['sellcar'] as $sellcars)

                               <?php @$modelName = DB::table('car_model')->where('id',$sellcars->prop_category)->first(); ?>
                                <div class="item">
                                   <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                    <a href="{{ URL::to('/car_Detail/'.$sellcars->id) }}">
                                                    <?php $image = DB::table('car_img')->where('car_id',@$sellcars->id)->first(); ?>

                                                    @if(file_exists(public_path().'/carImage/'.@$image->img_name)  AND @$image->img_name != '')

                                                        <img src="{{ URL::to('/public/carImage/'.$image->img_name) }}" >
                                                    @else
                                                        
                                                        <img src="{{ $new.'/resources/assetsite/img/car/car-1.jpg'}}" alt="JSOFT">
                                                    @endif
                                                </a>
                                                 @if($sellcars->pro_type != '') 
                                                     <div class="list-rest">
                                                    <a href="javascript:void(0)">
                                                        @if($sellcars->pro_type == '1') 
                                                           {{ trans('labels.forsale') }}
                                                        @elseif($sellcars->pro_type == '2')
                                                           {{ trans('labels.forrent') }}
                                                        @endif
                                                    </a>
                                                    </div>
                                                @endif
                                            </div>
                                           

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="{{ URL::to('/car_Detail/'.$sellcars->id) }}">{{ @$sellcars->car_name }}</a>
                                                    @if($sellcars->pro_type == '1') 
                                                        @if($sellcars->sale_price !='')<span class="price">${{ @$sellcars->sale_price }}</span>@endif
                                                    @elseif($sellcars->pro_type == '2')
                                                        @if($sellcars->month_rentprice !='')<span class="price">${{ @$sellcars->month_rentprice }}</span>@endif
                                                    @endif
                                                    
                                                </h3>

                                                <h5><i class="fas fa-map-marker-alt"></i> {{ @$sellcars->googleLocation }} </h5>

                                                <div class="p-car-feature">
                                                    @if($sellcars->year_of_car !='')<a href="javascript:void(0)">{{ $sellcars->year_of_car }}</a>@endif
                                                    @if($sellcars->gear_type == 'Automatic')<a href="javascript:void(0)">{{ trans('labels.Automatic') }}</a>@elseif($sellcars->gear_type == 'Manual')<a href="javascript:void(0)">{{ trans('labels.Manual') }}</a>@endif

                                                    @if($session['language'] == 'en')
                                                      <a href="javascript:void(0)">{{ @$modelName->name }}</a>
                                                    @elseif ($session['language'] == 'ku')
                                                      <a href="javascript:void(0)">{{ @$modelName->ku }}</a>
                                                    @else
                                                      <a href="javascript:void(0)">{{ @$modelName->ar }}</a>
                                                    @endif

                                                    

                                                </div>
                                            </div>
                                        </div> 
                                </div>
                                @empty
                                @endforelse

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
                @forelse($result['ban'] as $bann)
                
                    @if(file_exists(public_path('/dsaImage/'.@$bann->image)) AND @$bann->image !='' )
                    <img src="{{ URL::to('/public/dsaImage/'.@$bann->image)}}" alt="">
                    @endif
                     
                @empty
                @endforelse
                 
            </div>
        </div>
    </section>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2>{{ trans('labels.rentalCompanies') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part">
                <div class="owl-carousel owl-theme car-rent">
                    <?php //echo '<pre>'; print_r($result['company']); die; ?>
                    @forelse($result['company'] as $companies)
                    <div class="item">
                        <div class="img_real_home">
                            <div class="img_real">
                                 <a href="{{ URL::to('/companyList/'.$companies->myid) }}">
                                @if(file_exists(@$companies->image) AND @$companies->image != '')
                                    <img src="{{ URL::to('/'.$companies->image) }}" >
                                @else
                                    <img src="{{ $new.'/public/default-image.jpeg'}}">
                                @endif
                            </a>
                            </div>
                            <div class="real_content">
                            
                                <div class="estate_real">
                                    <ul class="esta_ul">
                                        <li class="esta_li">
                                            <a href="{{ URL::to('/companyList/'.$companies->myid) }}">{{ @$companies->first_name }}  {{ @$companies->last_name }}</a>
                                            
                                        </li>
                                        @if($companies->phone != '')
                                        <li class="esta_li telp">
                                            <a href="tel:012345-01234">
                                                <i class="fas fa-phone-alt"></i><span>{{ @$companies->phone }}</span>
                                            </a>
                                            
                                        </li>
                                        @endif
                                        @if($companies->email != '')

                                        <li class="esta_li telp">
                                            <a href="mailto:abc@gmail.com">
                                                <i class="fas fa-envelope"></i><span>{{ @$companies->email }}</span>
                                            </a>
                                        </li>    
                                        @endif
                                                               
                                    </ul>

                                </div>
                            </div>
                     </div>
                    </div>
                    @empty
                    @endforelse 

                </div>
                </div>
                </div>
                <div class="col-md-6">

                    <div class="section-title  text-center">
                        <h2>{{ trans('labels.showRooms') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>

                    <div class="showroom-part">
                
                <div class="owl-carousel owl-theme show-part">
                    
                    @forelse($result['showroom'] as $showrooms)
                    <div class="item">
                        <div class="img_real_home">
                            <div class="img_real">
                            <a href="{{ URL::to('/showroomList/'.$showrooms->myid) }}">
                            @if(file_exists(@$showrooms->image)  AND @$showrooms->image != '')
                                <img src="{{ URL::to('/'.$showrooms->image) }}" id="chimg">
                            @else
                                <img src="{{ $new.'/public/default-image.jpeg'}}">
                            @endif
                            </a>  
                            </div>
                        <div class="real_content">
                            
                            <div class="estate_real">
                                <ul class="esta_ul">
                                    <li class="esta_li">
                                        <a href="{{ URL::to('/showroomList/'.$showrooms->myid) }}">{{ @$showrooms->first_name }}  {{ @$showrooms->last_name }}</a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="tel:012345-01234">
                                            <i class="fas fa-phone-alt"></i><span>{{ @$showrooms->phone }}</span>
                                        </a>
                                        
                                    </li>
                                    <li class="esta_li telp">
                                        <a href="mailto:abc@gmail.com">
                                            <i class="fas fa-envelope"></i><span>{{ @$showrooms->email }}</span>
                                        </a>
                                    </li>  
                                </ul>

                            </div>
                        </div>
                        </div>
                    </div>
                    @empty
                    @endforelse

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
                        <h2>{{ trans('labels.about') }}</h2>
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

                            @if(file_exists(public_path().'/aboutImage/'.$result['about']->image)  && $result['about']->image != '')
                                <img src="{{ URL::to('/public/aboutImage/'.$result['about']->image) }}" id="chimg">
                            @else
                               <img src="{{ $new.'/resources/assetsite/img/home-2-about.png'}}" alt="JSOFT">
                            @endif
                               
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
                            @if(strlen($result['about']->description)>500)
                            <?php @$content = $result['about']->description; ?>
                            <p style="display: none" id="testa"><?php echo substr( preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", @$content),500); ?></p>
                           
                            @endif
                            
                    </div>
                    @if(strlen($result['about']->description)>500)
                    <div  class="button intro_button"><a href="javascript:void(0)"  id="test">{{ trans('labels.READ MORE') }}</a></div>
                    @endif
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
                        <h2>{{ trans('labels.DownloadIraqCarApplication') }}</h2>
                        <p>{{ trans('labels.Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy & sell') }}</p>
                        <div class="app-btns">
                            <a href="javascript:void(0)"><i class="fab fa-android"></i>{{ trans('labels.androidStore') }}</a>
                            <a href="javascript:void(0)"><i class="fab fa-apple"></i>{{ trans('labels.appleStore') }}</a>
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
        url: '{{route("category.filter")}}',
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
  

@endsection