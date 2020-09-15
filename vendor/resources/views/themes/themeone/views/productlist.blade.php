@extends('layout')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $compareQuantity = 0;
  $data = $result['storeList'];
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

    <section class="section-padding product-detil">
        <div class="container">
            <div class="section-title  text-center sthowroom-detail">
                <div class="show-ret"> 
                    <h2>{{ @$data->first_name }} {{ @$data->last_name }}</h2>
                </div>
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

    <div class="detail-term">
    <div class="container">
    <div class="details gerti tert-ert">
        
    @if(count($result['products']))
        <div class="section-title  text-center">
            <h2>{{ trans('labels.ProductList') }}</h2>
            <span class="title-line"><i class="fa fa-car"></i></span>
        </div>
    @endif
            @if(count($result['products']))
                <div class="row">
                    @foreach($result['products'] as $product)
                        <div class="col-lg-4 col-md-6">
                            
                            <div class="rent-part">
                                    <div class="img_real_home prdct-dtil">
                                    <div class="img_real">
                                        <img src="{{ $product->img_name ? url('/public/productImage/'.$product->img_name) : url('/public/default-image.jpeg' )}}">
                                    </div>
                                    <div class="real_content">
                                        
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            @if($product->name !='')                                                 
                                                <li class="esta_li">
                                                    <h3 class="prd-title">{{$product->name}}</h3>
                                                </li>
                                            @endif
                                            @if($product->price !='' || $product->size != '') 
                                                <li class="esta_li">
                                                    <strong>{{ trans('labels.price') }}</strong> :{{$product->price}} , 
                                                    <strong>{{ trans('labels.size') }}</strong> :{{$product->size}}
                                                </li>
                                            @endif
                                            @if($product->color !=''  || $product->model != '') 
                                                <li class="esta_li">
                                                    <strong>{{ trans('labels.color') }}</strong> :{{$product->color}} , 
                                                    <strong>{{ trans('labels.model') }}</strong> :{{$product->model}}
                                                </li>
                                            @endif
                                            </ul>

                                        </div>
                                        </div>
                                        <div class="prod-disc">
                                            @if($product->description !='') 
                                                <p><strong>{{ trans('labels.description') }}</strong> : {{ substr($product->description,0,120) }} 
                                                    @if(strlen($product->description)>120)
                                                    <?php @$content = $product->description; ?>
                                                    <p style="display: none" id="testa_{{ @$product->id }}"><?php echo substr( preg_replace("#<img (.*?)src=(\"|\')http(s)?://i.imgur.com(.*?)(\"|\')#U", "[IMG=http://i.imgur.com$4]", @$content),120); ?></p>

                                                         <div class="button intro_button"><a href="javascript:void(0)" id="test_{{ @$product->id }}">{{ trans('labels.READ MORE') }}..</a></div>
                                                         <script>
                                                         $(document).ready(function(){
                                                            var ii = '{{ @$product->id }}';
                                                            $("a#test_"+ii).click(function(){
                                                            $("#testa_"+ii).toggle();
                                                            
                                                            });
                                                             
                                                          });
                                                        </script>
                                                    @else
                                                    @endif
                                                    </p>
                                            @endif
                                            <ul class="esta_ul">
                                                @if($product->specification !='') 
                                                    <li class="esta_li">
                                                        <strong>{{ trans('labels.specification') }}</strong> :{{$product->specification}}
                                                    </li>
                                                @endif

                                                @if($product->quantity !='') 
                                                <?php
                                                    $productlist = \App\PlaceOrder::where('Product_ID',$product->id)->sum('Quantity');
                                                    $compareQuantity = $product->quantity - $productlist;
                                                    ?>
                                                @endif
                                                @if($compareQuantity > 0)
                                                    <li class="esta_li">
                                                        <strong>{{ trans('labels.availableQuantity') }}</strong> :{{$compareQuantity}}
                                                    </li>
                                                    <li class="esta_li">
                                                        <a href="{{route('addnewcart',['id'=>$product->id])}}" class="btn adtcrt">{{ trans('labels.addToCart') }}</a>
                                                    </li>
                                                @else
                                                    <li class="esta_li addtocart"><div class="alert alert-danger">
                                                    {{ trans('labels.outOfStock') }}
                                                    </div></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                                                
                            <div class="col-xs-12 text-right">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="section-title  text-center">
                    <center><h5>{{ trans('labels.noResultFound') }}</h5></center>
                </div>        
            @endif   

            <div style="margin-top: 25px;"> {{ @$result['products']->links('vendor.pagination.default') }}</div>
        </div>
    </div>
</div>
    </section>
    

@endsection