@extends('layout')
@section('content')
<?php $session = Session::all(); ?>

<style type="text/css">
  .heem { display: inline-block !important; width: 100%; }
  .heem .oonecls { display: flex; align-items: flex-start; margin-top: 15px; width: 100%; }
  .heem > a { margin-left: 0; }
</style>


@if(!isset($session['language']) AND $session['language'] == '' )

    <div class="modal hide fade" id="frst-popp">
        <div class="modal-dialog modal-sm modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">{{ trans('labels.Select Language') }}</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            
            <div class="modal-body" style="padding-top: 20px; padding-bottom: 25px;">
              <select class="form-control" onchange="langs()" id="language">
                <option selected="" disabled="">{{ trans('labels.Choose Language') }}</option>
                <option value="en">{{ trans('labels.English') }}</option>
                <option value="ar">{{ trans('labels.Arabic') }}</option>
                <option value="ku">{{ trans('labels.Kurdish') }}</option>
              </select>
            </div>       
          </div>
        </div>
    </div>

@endif 


<div class="super_container">
  <div class="super_overlay"></div>
 

  <!-- Home -->

  <div class="home">
    
    <!-- Home Slider -->
    <div class="home_slider_container">
       <div class="owl-carousel owl-theme home_slider">
        
        <!-- Slide -->
        @forelse($result['homeslider'] as $slide)
        <div class="slide">
          <div class="background_image" style="background-image:url('resources/assets/website/images/index.png')"></div>
          <div class="home_container">
            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="home_content">
                    <div class="home_title">
                      <h1>@if(isset($session['language']) AND $session['language'] == 'en')
                          {{ @$slide->title }}
                          @elseif(isset($session['language']) AND $session['language'] == 'ku')
                          {{ @$slide->titlekurdish }}
                          @else
                          {{ @$slide->titlearabic }}
                          @endif</h1>
                    </div>
                    <div class="home_price_tag">
                      <p>@if(isset($session['language']) AND $session['language'] == 'en')
                          {{ strip_tags(@$slide->description) }}
                          @elseif(isset($session['language']) AND $session['language'] == 'ku')
                          {{ strip_tags(@$slide->descriptionkurdish) }}
                          @else
                          {{ strip_tags(@$slide->descriptionarabic) }}
                          @endif</p>
                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="slide">
          <div class="background_image" style="background-image:url('resources/assets/website/images/index.png')"></div>
          <div class="home_container">
            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="home_content">
                    <div class="home_title"><h1>{{ trans('labels.FIND YOUR DREAM HOUSE') }}</h1></div>
                    <div class="home_price_tag">
                      <p>Lorem ipsum dolor sit amet, conconsectetuer adipiscing elit</p>
                      <p> Lorem ipsum dolor sit amet, conconsectetuer</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforelse
       </div>

       <!-- Home Slider Navigation -->
       <div class="home_slider_nav"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
       
    </div>
  </div>

  <!-- Search -->
  <div class="search">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="search_container">
            <div class="search_form_container">
              <div class="search_form">
              <form action="{{ url('/property_list/property-list') }}" method="GET" class="" name="form">
                <div class="d-flex flex-lg-row flex-column align-items-start justify-content-lg-between justify-content-start">
                  <div class="search_inputs d-flex flex-lg-row flex-column align-items-start justify-content-lg-between justify-content-start property-main">


                    <select class="search_input prop" name="search" id="search">
                      <option value="">{{ trans('labels.selectPropertyType') }}</option>
                        @forelse($result['property_type'] as $pro_type) 
                              <option value="{{ $pro_type->id }}"> @if($session['language']=='ar') {{ $pro_type->ar }} @elseif($session['language']=='ku') {{ $pro_type->ku }} @else {{ $pro_type->name }} @endif</option>                          
                        @empty    
                        @endforelse
                    </select>
                    <select class="search_input" name="city">
                      <option value="">{{ trans('labels.selectCity') }}</option>
                        @forelse($result['city'] as $city) 
                              <option value="{{ $city->id }}"> @if($session['language']=='ar') {{ $city->ar }} @elseif($session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                        @empty    
                        @endforelse
                    </select>
                    <select class="search_input" name="category">
                      <option value="">{{ trans('labels.category') }}</option>
                        @forelse($result['category'] as $cat) 
                              <option value="{{ $cat->id }}"> @if($session['language']=='ar') {{ $cat->ar }} @elseif($session['language']=='ku') {{ $cat->ku }} @else {{ $cat->name }} @endif</option>
                        @empty    
                        @endforelse
                    </select>
                  
                    <input class="search_button sale-inr" type="submit" value=" {{ trans('labels.search') }} " >
                    </form> 
                  </div>
                  </div>
                  
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Featured -->

  <div class="featured">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="section_title_container text-center">
            <div class="section_subtitle">{{ trans('labels.the best deals') }}</div>
            <div class="section_title"><h1>{{ trans('labels.Featured Properties') }}</h1></div>
          </div>
        </div>
      </div>
      <div class="row featured_row">
        
        <!-- Featured Item -->
<div class="prop_slde">
                  <div class="owl-carousel owl-theme property-slider">
          @forelse($result['property'] as $key => $value)
         
        <?php  $property_img = DB::table('property_img')->where('property_id',$value->id)->first();
               $data1 = DB::table('properties')->select('*')->where('id',$value->id)->first(); ?>
              
                    <div class="listing">
                      <div class="listing_image">
                        @if ($property_img == "")
                         <a href="{{ url('/property-detail/'.$value->id)}}">
                            <div class="listing_image_container">                             
                            <img src="{{ URL::to('/public/default-image.jpeg')}}" alt=""> 
                            </div></a>
                         @else <a href="{{ url('/property-detail/'.$value->id)}}">
                            <div class="listing_image_container">
                             <img src="{{ URL::to('/public/propertyImage/'.$property_img->img_name)}}" alt="">
                            </div></a>
                        @endif
                        <div class="tags">
                          <div class="tag tag_sale"><a href="#">
                            @if($data1->pro_type == 1) 
                              {{ trans('labels.forsale') }}
                            @else
                              {{ trans('labels.forrent') }}
                            @endif
                            </a></div>
                        </div>
                        <div class="listing_price">
                            
                            @if($data1->pro_type == 1 AND $data1->sale_price != '' AND $data1->sale_price > 0) 
                            <div class="tag_price">
                                $ {{ $data1->sale_price }}
                            </div>
                            @elseif($data1->pro_type == 2 AND $data1->month_rentprice != '' AND $data1->month_rentprice > 0)
                            <div class="tag_price">
                                $ {{ $data1->month_rentprice }}
                            </div>
                            @else
                            @endif
                        </div>
                      </div>

                      <?php
                        if (!empty($data1->lat) && !empty($data1->lng)) {
                            $earthRadius = '6371000';
                          $kilometer = "";
                          $user_ip = $_SERVER['REMOTE_ADDR']; 
                          //$geo = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=b2b33070109f1130df4c000ed64bd537b2060e8f287c0a8394d348353d3087eb&ip=".$user_ip."&format=json"));
                          $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".$user_ip));
                          //echo "<pre>"; print_r($geo); die;
                          //$lati = $geo->latitude; 
                          //$long = $geo->longitude;
                          $lati = $geo['geoplugin_latitude']; 
                          $long = $geo['geoplugin_longitude'];

                          $latFrom = $data1->lat;
                          $lonFrom = $data1->lng;
                          
                          $theta = $long - $lonFrom; 
                          $dist = sin(deg2rad($lati)) * sin(deg2rad($latFrom)) +  cos(deg2rad($lati)) * cos(deg2rad($latFrom)) * cos(deg2rad($theta));
                          $dist = acos($dist);
                          $dist = rad2deg($dist);
                          $miles = $dist * '60' * '1.1515';
                          
                          $kilometer = $miles * '1.609344'; 
                        } else {
                          $kilometer = "";
                        }
                        
                        ?>


                      <div class="listing_content">
                        <div class="prop_location listing_location d-flex flex-row align-items-start justify-content-start heem">
                          <a href="http://eqaratiraq.net/property-detail/42">{{$value->property_name}}</a>
                          <div class="oonecls">
                          <img src="{{ URL::to('/resources/assets/website/images/icon_1.png')}}" alt="">
                           <a href="{{ URL::to('/property-detail/'.$value->id) }}" >{{ @$data1->googleLocation }}</a></div>
                        </div>
                        <div class="listing_info">
                          <ul class="d-flex flex-row align-items-center justify-content-start flex-wrap">
                            <li class="property_area d-flex flex-row align-items-center justify-content-start">
                              <img src="{{ URL::to('/resources/assets/website/images/icon_2.png')}}" alt="">
                              
                              <span><?php echo round($kilometer, 2)." "; ?>{{ trans('labels.kilometer') }}</span>
                            </li>
                            <li class="d-flex flex-row align-items-center justify-content-start">
                              <img src="{{ URL::to('/resources/assets/website/images/icon_3.png')}}" alt="">
                              <span>{{ @$data1->bath }} {{ trans('labels.Bath') }}</span>
                            </li>
                            <li class="d-flex flex-row align-items-center justify-content-start">
                              <img src="{{ URL::to('/resources/assets/website/images/icon_4.png')}}" alt="">
                              <span>{{ @$data1->bedroom }} {{ trans('labels.Bedroom') }}</span>
                            </li>
                            
                          </ul>
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

  <!-- Map Section -->
<div class="bann-banner">
      <div class="container">
        <div class="pre_trer">
            
            <div class="testimonials_slider_container">
              <div class="owl-carousel owl-theme bannr-ad-slider">
                
                <!-- Slide -->
                @forelse($result['ads'] as $adds)
                <div class="test_slide">
                  <div class="img_real_home_bann">
                    <div class="img_real_banner">
                      <a href="{{ @$adds->adUrl }}" target="_blank">
                        @if(file_exists(public_path('/bannerImage/'.@$adds->image)) AND @$adds->image !='' )
                        <img src="{{ URL::to('/public/bannerImage/'.@$adds->image)}}" alt="">
                        @endif
                      </a>
                    </div>              
                  </div>
                </div>
                @empty
                <!-- <div class="test_slide">
                  <div class="img_real_home_bann">
                    <div class="img_real_banner">
                      <a>
                        <img src="{{ URL::to('/resources/assets/img/bann1.png')}}">
                      </a>
                    </div>              
                  </div>
                </div> -->
                @endforelse
            
              </div>
            </div>
          </div>

      </div>
   </div>
   
   <div class="real_app">
      <div class="container">
         <div class="download_inr">
           <h1>{{ trans('labels.Download Iraq Real State Application') }}</h1>
           <p>{{ trans('labels.Sed do eiusmod temporut labore et dolore magna aliqua. Your perfect place to buy & sell') }}</p>
            
          
            <div class="down-imag">
              <a href="https://apps.apple.com/us/app/eqarat-iraq/id1477793098?ls=1">
                <img src="{{ URL::to('/resources/assets/website/images/app-store.png')}}" alt="">
              </a>
              <a href="https://play.google.com/store/apps/details?id=com.iraq.realestate">
                <img src="{{ URL::to('/resources/assets/website/images/google-play.png')}}" alt="">
              </a>
            </div>
          
         </div>
      </div>
   </div>
  <div class="map_section container_reset">
    <div class="container">
      <div class="row row-xl-eq-height">

        <!-- Map -->
        <div class="col-xl- order-xl-1 order-2">
          <div class="map">
            <div id="google_map" class="google_map">
              <div class="map_container">
                <div id="map"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Content -->
        

      </div>
    </div>
  </div>

  <!-- Hot -->

  

  <!-- Testimonials -->

  <div class="testimonials container_reset">
    <div class="container">
      <div class="row row-eq-height">
        
        <!-- Testimonials Image -->
        <!-- <div class="col-xl-6">
          <div class="testimonials_image">
            <div class="background_image" style="background-image:url(images/testimonials.jpg)"></div>
            <div class="testimonials_image_overlay"></div>
          </div>
        </div> -->

        <!-- Testimonials Content -->
        <div class="col-xl-12">
          <div class="testimonials_content">
            <div class="section_title_container">
              
              <div class="section_title"><h1>{{ trans('labels.Clients testimonials') }}</h1></div>
            </div>

            <!-- Testimonials Slider -->
            <div class="testimonials_slider_container">
              <div class="owl-carousel owl-theme test_slider">
                
                @forelse($result['testimonials'] as $data)
                <div class="test_slide">
                  <div class="test-inr">
                  <div class="test_quote">"{{ @$data->title }}"</div>
                  <div class="test_text">
                    <?php $content = @$data->description; ?>
                    <p><?php echo preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", $content); ?></p>
                  </div>
                  <div class="test_author"><a href="#">{{ @$data->username }}</a></div>
                    </div>
                </div>

                @empty
                @endforelse

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function()
{
  "use strict";
  initpropertySlider();
  function initpropertySlider()
  {
    if($('.property-slider').length)
    {
      var propSlider = $('.property-slider');
      propSlider.owlCarousel(
      {
        autoplay:true,
        autoplayHoverPause:true,
        loop:false,
        nav:false,
        dots:true,
        smartSpeed:1000,
        responsive:{
              0:{
                  items:1,
              },
              768:{
                  items:2,
              },
              1000:{
                  items:3,
              }
          }
      });
    }
  }

});
</script>

<script type="text/javascript">
  $(document).ready(function()
{
  "use strict";
  initbannrAdSlider();
  function initbannrAdSlider()
  {
    if($('.bannr-ad-slider').length)
    {
      var bannrAdSlider = $('.bannr-ad-slider');
      bannrAdSlider.owlCarousel(
      {
        autoplay:true,
        autoplayHoverPause:true,
        loop:true,
        nav:false,
        rtl: true,
        dots:true,
        smartSpeed:1000,
        responsive:{
              0:{
                  items:1,
              },
              600:{
                  items:1,
              },
              1000:{
                  items:1,
              }
          }
      });
    }
  }

});






function langs(){
  var fil = document.getElementById("language").value;

  var url='{{ URL::to("/") }}';

 
 var urls=url+'?language='+fil;
  window.location.href=urls;


}


</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#frst-popp').modal('show');
    });
</script>





@endsection 

