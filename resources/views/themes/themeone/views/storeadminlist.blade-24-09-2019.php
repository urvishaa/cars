@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>
     <section class="store_main">
        <div class="container">
            <div class="section-title  text-center">
                        <h2>{{ trans('labels.storeAdminList') }}</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="car-rent-tr-fri">
                                    <form >
                                        <div class="s-brand input -text search-item">
                                           <input type="text" name="productname" id="productname" placeholder="{{ trans('labels.productName') }}">
                                        </div>


                                        <div class="s-year input -text search-item">
                                           <input type="text" name="storename" id="storename"  placeholder="{{ trans('labels.storeName') }}"> 
                                        </div>

                                        <div class="s-city search-item">
                                            <select class="custom-select" id="city" name="city">
                                                <option value="">{{ trans('labels.selectCity') }}</option>
                                                @forelse($result['city'] as $city) 
                                                      <option value="{{ $city->id }}">@if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                                                @empty    
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="main-srch-btn search-item">
                                            <button type="button" id="searchStore"><i class="fa fa-search"></i><span>{{ trans('labels.search') }}</span></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="img-store-lower">
                                    <div class="row low-retr-eri" id="store">
                                 
                                       
                                       
                                    </div>
                                </div>
        </div> 
     </section>
<script type="text/javascript">
$(document).ready(function(){

      

    $('#searchStore').click(function(){    

        var city =  $('#city').val();
        var productname = document.getElementById("productname").value;
        var storename = document.getElementById("storename").value;

        // alert('fdf')

        $.ajax({
        url: "{{ URL::to('/storeResult') }}",
        method: "POST",
        data:{productname:productname,storename:storename,city:city},
        success: function(data){
          var reu = JSON.parse(data);

           $('#store').html(reu['result']);
        }
        });
      
    });

 

    $.ajax({
        url: "{{ URL::to('/storeResult') }}",
        method: "POST",
        // data:{carbrand:carbrand,city:city,year:year,category:category},
        success: function(data){
          var reu = JSON.parse(data);
           $('#store').html(reu['result']);
           $('.property-slider2').owlCarousel({
            autoplay:true,
            autoplayHoverPause:true,
            loop:true,
            nav:false,
            dots:true,
            smartSpeed:1000,
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
        }
    });

});

  

   
</script>
@endsection