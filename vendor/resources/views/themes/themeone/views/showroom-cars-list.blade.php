@extends('layout')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  $data = $result['showroomdetail'];
   //echo '<pre>'; print_r($data); die;
?>


@section('iamge')
  @if(@$data->image != '') 
    @if(file_exists(@$data->image)  AND @$data->image != '')
     <?php echo URL::to('/'.$data->image); ?>
    @else 
      <?php echo URL::to('/public/default-image.jpeg'); ?>
    @endif 
  @else
  <?php echo URL::to('/public/default-image.jpeg'); ?>
  @endif
@endsection

@section('title')
  @if(@$data->first_name != '')
    <?php echo @$data->first_name.' '.@$data->last_name ; ?>
  @else
   <?php echo "Iraq car"; ?>
  @endif
 
@endsection

 @section('description')
  @if(@$data->phone != '')
    <?php echo @$data->phone; ?>
  @else
   <?php echo "Iraq car"; ?>
  @endif
  @if(@$data->email != '')
    <?php echo @$data->email; ?>
  @else
   <?php echo "Iraq car"; ?>
  @endif
@endsection 

@section('content')

<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d73ab59ab6f1000123c8260&product=inline-share-buttons' async='async'></script>

 
    <section id="detail-part" class="section-padding detail-part">
        <div class="container">
            <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2>{{ @$data->first_name }} {{ @$data->last_name }}</h2>
                       </div>
                       <!-- <div class="show-select">
                             
                              <select>
                              <option value="volvo">City</option>
                              <option value="saab">Saab</option>
                              <option value="mercedes">Mercedes</option>
                              <option value="audi">Audi</option>
                            </select>
                          
                        </div> -->
                    </div>
            <div class="row">
                <!-- Car List Content Start -->
                <div class="col-lg-5">
                    <div class="detail-car car-deta-res">
                        <div class="img_real_home Car-rent">
                                <div class="img_real">
                                    @if(file_exists(@$data->image)  AND @$data->image != '')
                                    <img src="{{ URL::to('/'.$data->image) }}" id="chimg">
                                    @else
                                        <img src="{{ $new.'/public/default-image.jpeg'}}">
                                    @endif
                                </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                                                                             
                                                <li class="esta_li">
                                                    <a href="javascript:void(0)">{{ @$data->first_name }} {{ @$data->last_name }} </a>
                                                    
                                                </li>
                                                                                             
                                                @if($data->phone != '')
                                                <li class="esta_li telp">
                                                    <a href="tel:{{ @$data->phone }}">
                                                       <label><i class="fa fa-mobile-alt"></i></label><span>{{ @$data->phone }}</span>
                                                    </a>
                                                    
                                                </li>
                                                @endif
                                                                                         
                                                @if($data->email != '')
                                                <li class="esta_li telp">
                                                     <a href="mailto:{{ @$data->email }}"><label><i class="far fa-envelope"></i></label><span>{{ @$data->email }}</span></a>
                                                </li> 
                                                @endif
                                                                      
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    <div class="sharethis-inline-share-buttons" id="myDIV"></div>
                                </div>               
                               <!--  <div class="tag_price listing_price detail_rent agent">
                                  <a href="#"><i class="fas fa-comment-dots"></i>{{ trans('labels.contact_agent') }}</a>
                                </div> -->
                                
                      </div>
                      
                </div>
                <!-- Car List Content End -->

                <!-- Sidebar Area Start -->
                <div class="col-lg-7">
                    <div class="derti-app">
                      <div class="details-content">
                       <h2>{{ trans('labels.about') }}</h2>
                        @if($data->description != '')<p>{{ @$data->description }}</p>@else <p>{{ trans('labels.notAvailable') }}</p> @endif
                        
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
                    @if(count($result['showroomCars']))
                    <div class="section-title  text-center">
                        <h2>{{ trans('labels.thebestdeals') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    @endif
                        <div class="row">
                            @forelse($result['showroomCars'] as $showroomCar)
                            <?php @$modelName = DB::table('car_model')->where('id',$showroomCar->prop_category)->first(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-popular-car">
                                    <div class="p-car-thumbnails">
                                         <a  href="{{ URL::to('/car_Detail/'.$showroomCar->id) }}">  
                                          <?php $image = DB::table('car_img')->where('car_id',$showroomCar->id)->first(); 
                            
                                            if(!empty($image))
                                            {
                              
                                              if((file_exists(public_path().'/carImage/'.$image->img_name)))
                                                  {     
                                                      ?>                              
                                                   <img src="{{ URL::to('/public/carImage/'.$image->img_name) }}">                          
                                                 <?php } 
                                                  else 
                                                  {   ?>                                 
                                                      <img src="{{ URL::to('/public/default-image.jpeg') }}" >                                
                                                <?php  }
                                              }  
                                              else
                                              { ?>
                                                  
                                                <img src="{{ URL::to('/public/default-image.jpeg') }}" >
                                             <?php }  ?>
                                       </a> 
                                        @if($showroomCar->pro_type != '')     
                                        <div class="list-rest">
                                            <a href="javascript:void(0)">
                                              @if($showroomCar->pro_type == '1') 
                                                 {{ trans('labels.forsale') }}
                                              @elseif($showroomCar->pro_type == '2') 
                                                 {{ trans('labels.forrent') }}
                                              @endif
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    

                                    <div class="p-car-content">
                                        <h3>
                                            <a href="{{ URL::to('/car_Detail/'.$showroomCar->id) }}">{{ @$showroomCar->car_name }}</a>
                                            @if($showroomCar->pro_type == '1') 
                                                @if($showroomCar->sale_price !='')<span class="price">${{ @$showroomCar->sale_price }}</span>@endif
                                            @elseif($showroomCar->pro_type == '2')
                                                @if($showroomCar->month_rentprice !='')<span class="price">${{ @$showroomCar->month_rentprice }}</span>@endif
                                            @endif
                                           
                                        </h3>

                                        <h5><i class="fas fa-map-marker-alt"></i> {{ $showroomCar->googleLocation }}</h5>

                                        <div class="p-car-feature">
                                            @if($showroomCar->year_of_car !='')<a href="javascript:void(0)">{{ $showroomCar->year_of_car }}</a>@endif
                                            @if($showroomCar->gear_type == 'Automatic')<a href="javascript:void(0)">{{ trans('labels.Automatic') }}</a>@elseif($showroomCar->gear_type == 'Manual')<a href="javascript:void(0)">{{ trans('labels.Manual') }}</a>@endif
                                              
                                            @if(isset($session['language']) AND $session['language'] == 'en')
                                              <a href="javascript:void(0)">{{ $modelName->name }}</a>
                                            @elseif(isset($session['language']) AND $session['language'] == 'ku')
                                              <a href="javascript:void(0)">{{ $modelName->ku }}</a>
                                            @else(isset($session['language']) AND $session['language'] == 'ar')
                                              <a href="javascript:void(0)">{{ $modelName->ar }}</a>
                                            @endif     

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                           
                            @endforelse
                           
                        </div>
                         <div style="margin-bottom: 25px;"> {{ @$result['showroomCars']->links('vendor.pagination.default') }}</div>
                </div>             
            </div>
          </div>          
        </div>
          
    </section>

  
@endsection