@extends('layout')
@section('content')
<?php
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {

    $( "#amount" ).val( "$" + 1000 + " - $" + 15000 );  
    $( "#slider-range" ).slider({ 
      range: true,
      min: 1000,
      max: 100000,
   		values: [ 1000, 15000 ],
      slide: function( event, ui ){ 

       $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );   
       $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        var carbrand = document.getElementById("carbrand").value;
        var city = document.getElementById("city").value;
        var year = document.getElementById("year").value;  
        var minkm = document.getElementById("minkm").value;
        var maxkm = document.getElementById("maxkm").value;    

          var minprice = ui.values[0];
          var maxprice = ui.values[1];
          $('#minprice').val(minprice);
          $('#maxprice').val(maxprice) ;
          $.ajax({
            url: '{{ URL::to("/carResult") }}',
            type: 'POST',        
            data: {minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,carbrand:carbrand,city:city,year:year},
            success: function(repsonse){
              var reu = JSON.parse(repsonse);
             $('#car').html(reu['result']);
            },
          });
      
      }
    });

  });


   $( function() {
       $( "#amount1" ).val( "$" + 100 + " - $" + 55000 );  
    $( "#slider-range1" ).slider({
      range: true,
      min: 100,
      max: 500000,
     values: [ 100, 55000 ],
      slide: function( event, ui ) {
          $( "#amount1" ).val(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );   
          $( "#amount1" ).val( $( "#slider-range1" ).slider( "values", 0 ) +
          " - " + $( "#slider-range1" ).slider( "values", 1 ) );
          var carbrand = document.getElementById("carbrand").value;
          var city = document.getElementById("city").value;  
          var year = document.getElementById("year").value;  
          var minprice = document.getElementById("minprice").value;
          var maxprice = document.getElementById("maxprice").value;  
 
          var minkm = ui.values[0];
          var maxkm = ui.values[1];
          $('#minkm').val( ui.values[0] )
          $('#maxkm').val( ui.values[1] )
          $.ajax({
            url: '{{ URL::to("/carResult") }}',
            type: 'POST',
            data: {minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,carbrand:carbrand,city:city,year:year},
            success: function(repsonse){
              var reu = JSON.parse(repsonse);
              $('#car').html(reu['result']);
            },
          });
      }
    });
  });
   
  </script>

<section id="sell-buy-main" class="section-padding sell-buy-main">
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
                
                <div class="col-md-4 col-lg-3">
                    <div class="sell-sidebar-ter">
                        <h3><label>{{ trans('labels.filter') }}</label><button id="btnClear">{{ trans('labels.clear') }}</button></h3>

                        <div class="chs-sidebar">
                            <div class="chk-select">
                                <div class="ch-tri">
                                    <select name="carbrand" onchange="ddfilter()" id="carbrand">
                                      <option value="">{{ trans('labels.carBrand') }}</option>
                                      @forelse($result['brand'] as $brands) 
                                            <option value="{{ $brands->id }}"  @if(isset($_GET['brand'])) @if($_GET['brand']==$brands->id)  {{ 'selected="selected"'}} @else {{ '' }} @endif @endif >
                                            @if(isset($session['language']) AND $session['language']=='en') {{ $brands->name }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $brands->ku }} @else {{ $brands->ar }} @endif</option>
                                      @empty    
                                      @endforelse
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="category" onchange="ddfilter()" id="category">
                                      <option value="">{{ trans('labels.selectCategory') }}</option>
                                      @forelse($result['category'] as $categorys) 
                                            <option value="{{ $categorys->id }}"  @if(isset($_GET['category'])) @if($_GET['category']==$categorys->id)  {{ 'selected="selected"'}} @else {{ '' }} @endif @endif >
                                            @if(isset($session['language']) AND $session['language']=='en') {{ $categorys->name }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $categorys->ku }} @else {{ $categorys->ar }} @endif</option>
                                      @empty    
                                      @endforelse
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="year" onchange="ddfilter()" id="year">
                                     <option  value="">{{ trans('labels.yearOfCar') }}</option>
                                      @forelse($result['year'] as $years) 
                                            <option value="{{ $years }}"  @if(isset($_GET['year'])) @if($_GET['year']==$years)  {{ 'selected="selected"'}} @else {{ '' }} @endif @endif > {{ $years }} </option>
                                      @empty    
                                      @endforelse
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="city" onchange="ddfilter()" id="city">
                                      <option value="">{{ trans('labels.selectCity') }}</option>
                                      @forelse($result['city'] as $city) 
                                            <option value="{{ $city->id }}" @if(isset($_GET['city'])) @if($_GET['city']==$city->id)  {{ 'selected="selected"'}} @else {{ '' }} @endif @endif> @if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                                      @empty    
                                      @endforelse
                                    </select>
                                </div>
                               
                               <input type="hidden" name="maxprice" id="maxprice" value="">
                               <input type="hidden" name="minprice" id="minprice" value="">
                                <input type="hidden" name="maxkm" id="maxkm" value="">
                               <input type="hidden" name="minkm" id="minkm" value="">
                              
<!-- 
                              <input type="hidden" name="maxkm" id="maxkm" value=""> -->
                               <input type="hidden" name="brandhide" id="brandhide" value="@if( isset( $_GET['brand'] ) ){{$_GET['brand']}} @else {{ '' }} @endif">
                                 <input type="hidden" name="cityhide" id="cityhide" value="@if( isset( $_GET['city'] ) ){{$_GET['city']}} @else {{ '' }} @endif">
                                   <input type="hidden" name="yearhide" id="yearhide" value="@if( isset( $_GET['year'] ) ){{$_GET['year']}} @else {{ '' }} @endif">
                                     <input type="hidden" name="categoryhide" id="categoryhide" value="@if( isset( $_GET['category'] ) ){{$_GET['category']}} @else {{ '' }} @endif">


                                <div class="ch-tri">
                                  <label for="amount">{{ trans('labels.priceRange') }}:</label>
                                  <!-- <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold; display: none;"> -->
                                  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                               <div id="slider-range"></div>
                                </div>

                                <div class="ch-tri">
                                  <label for="amount1">{{ trans('labels.kilometerRange') }}:</label>
                                  <!-- <input type="text1" id="amount1" readonly style="border:0; color:#f6931f; font-weight:bold; display: none;"> -->
                                  <input type="text" id="amount1" readonly style="border:0; color:#f6931f; font-weight:bold;">
                               <div id="slider-range1"></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
               
                <div class="col-md-8 col-lg-9">

                   
                    <div class="row" id="car">
                       
                       
                    </div>
                </div>
                
            </div>
        </div>
    </section>
<script type="text/javascript">

$(document).ready(function(){

  $('#btnClear').click(function(){        
      
        $('#carbrand').val('');
        $('#city').val('');
        $('#year').val('');
        $('#category').val('');
        $('#minkm').val('');
        $('#maxkm').val('');
        $('#minprice').val('');
        $('#maxprice').val('');

        $.ajax({
        url: "{{ URL::to('/carResult') }}",
        method: "POST",
         // data:{carbrand:carbrand,city:city,year:year,category:category},
        success: function(data){
          var reu = JSON.parse(data);
          $('#car').html(reu['result']);

            $( "#amount" ).val( "$" + 1000 + " - $" + 15000 );  
            $( "#slider-range" ).slider({ 
                range: true,
                values: [ 1000, 15000 ],
                slide: function( event, ui ){                 
                 $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                " - $" + $( "#slider-range" ).slider( "values", 1 ) );  
                }
            });

            $( "#amount1" ).val( "$" + 100 + " - $" + 55000 );  
            $( "#slider-range1" ).slider({ 
                range: true,
                values: [ 100, 55000 ],
                slide: function( event, ui ){                 
                 $( "#amount1" ).val( "$" + $( "#slider-range1" ).slider( "values", 0 ) +
                " - $" + $( "#slider-range1" ).slider( "values", 1 ) );  
                }
            });

        }
    });
      
    });

 
  
  var carbrand = document.getElementById("brandhide").value;
  var city = document.getElementById("cityhide").value;
  var year = document.getElementById("yearhide").value;
  var category = document.getElementById("categoryhide").value;



    $.ajax({
        url: "{{ URL::to('/carResult') }}",
        method: "POST",
         data:{carbrand:carbrand,city:city,year:year,category:category},
        success: function(data){
          var reu = JSON.parse(data);
           $('#car').html(reu['result']);
        }
    });
});


function ddfilter(){
  var carbrand = document.getElementById("carbrand").value;
  var city = document.getElementById("city").value;
  var year = document.getElementById("year").value;
  var category = document.getElementById("category").value;
  var minkm = document.getElementById("minkm").value;
  var maxkm = document.getElementById("maxkm").value;  
  var minprice = document.getElementById("minprice").value;
  var maxprice = document.getElementById("maxprice").value;  

  if(city == ''){ city = null }
  if(carbrand == ''){ carbrand = null }
  if(category == ''){ category = null }
  if(year == ''){ year = null }

   $.ajax({
      url: "{{ URL::to('/carResult') }}",
      method: "POST",
      data:{carbrand:carbrand,city:city,minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,year:year,category:category},
      success: function(data){
        var reu = JSON.parse(data);
        $('#car').html(reu['result']);
      }
  });
}

</script>
@endsection