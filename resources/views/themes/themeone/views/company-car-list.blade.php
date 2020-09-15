@extends('layout')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  $data = $result['companydetail'];

?>
  <?php //echo '<pre>'; print_r($data); die;?>

<?php //echo '<pre>'; print_r($data->image); die; ?>
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
                    @if(count($result['companyCars']))
                    <div class="section-title  text-center">
                        <h2>{{ trans('labels.thebestdeals') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    @endif
                        <div class="row">
                            @foreach($result['companyCars'] as $companyCar)
                            <?php @$modelName = DB::table('car_model')->where('id',$companyCar['prop_category'])->first(); ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-popular-car">
                                    <div class="p-car-thumbnails">
                                        <a  href="{{ URL::to('/rentalcar_detail/'.$companyCar['id']) }}">  
                                          <?php @$image = DB::table('car_img')->where('car_id',$companyCar['id'])->first(); ?>
                            
                              
                                              @if(file_exists(public_path().'/carImage/'.@$image->img_name) AND @$image->img_name != '')
                                                     <img src="{{ URL::to('/public/carImage/'.@$image->img_name) }}">                              
                                              @else 
                                                      <img src="{{ URL::to('/public/default-image.jpeg') }}" >                                 
                                              @endif
                                          </a> 
                                        @if($companyCar['pro_type'] != '') 
                                        <div class="list-rest">
                                          <a href="javascript:void(0)">
                                             @if($companyCar['pro_type'] == '1') 
                                               {{ trans('labels.forsale') }}
                                             @elseif($companyCar['pro_type'] == '2')
                                               {{ trans('labels.forrent') }}
                                            @endif
                                          </a>
                                        </div>
                                        @endif
                                       
                                    </div>
                                    

                                    <div class="p-car-content">
                                        <h3>
                                            <a href="{{ URL::to('/rentalcar_detail/'.$companyCar['id']) }}">{{ @$companyCar['car_name'] }}</a>
                                         
                                          @if($companyCar['pro_type'] == '1') 
                                              @if($companyCar['sale_price'] !='')<span class="price">${{ @$companyCar['sale_price'] }}</span>@endif
                                          @elseif($companyCar['pro_type'] == '2')
                                              @if($companyCar['month_rentprice'] !='')<span class="price">${{ @$companyCar['month_rentprice'] }}</span>@endif
                                          @endif
                                        </h3>

                                        <h5><i class="fas fa-map-marker-alt"></i> {{ $companyCar['googleLocation'] }}</h5>


                                        <div class="p-car-feature">
                                        @if($companyCar['year_of_car'] != '')<a href="javascript:void(0)">{{ @$companyCar['year_of_car'] }}</a>@endif

                                        @if($companyCar['gear_type'] == 'Automatic')<a href="javascript:void(0)">{{ trans('labels.Automatic') }}</a>@elseif($companyCar['gear_type'] == 'Manual')<a href="javascript:void(0)">{{ trans('labels.Manual') }}</a>@endif

                                        
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           
                            @endforeach

                            


                           
                        </div>
                        <div style="margin-bottom: 25px;"> {{ @$result['companyCars']->links('vendor.pagination.default') }}</div>
                </div>             
            </div>
          </div>          
        </div>
          
    </section>

   
@endsection