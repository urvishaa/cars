<!DOCTYPE html>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
?>
 <?php @$session = Session::all(); ?>
@if(Session::get('language') == "ku")
<html lang="ku" class="arabic-lang kurdish-lang" dir="rtl">
@elseif(Session::get('language') == "en")
<html lang="en" class="eng-lang">
@else                
<html lang="ar" class="arabic-lang" dir="rtl">
@endif

<head>
   

    <title>Iraq Car</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
   
    <meta property="og:url" content="{{url('/')}}" />  
    <meta property="og:title" content="@yield('title')" /> 
    <meta property="og:type" content="@yield('title')" />     
    <meta property="og:image" content="@yield('iamge')"/>
    <meta property="fb:app_id" content = "360780478178141" />
    <meta property="og:site_name" content="Iraq Car"/>

    
<!--     <meta property="og:image:alt" content="{{ URL::to('resources/assetsite/img/logo.png')}}" />
    <meta property="og:image:secure_url" content="{{ URL::to('resources/assetsite/img/logo.png')}}" /> 
    <meta property="og:image:type" content="image/jpeg" /> 
    <meta property="og:image:width" content="400" /> 
    <meta property="og:image:height" content="300" />  -->
    <meta property="og:description" content="@yield('description')" />
        


    <!--=== Bootstrap CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/bootstrap.min.css'}}" rel="stylesheet">
    <!--=== Vegas Min CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/plugins/vegas.min.css'}}" rel="stylesheet">
    <!--=== Slicknav CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/plugins/slicknav.min.css'}}" rel="stylesheet">
    <!--=== Magnific Popup CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/plugins/magnific-popup.css'}}" rel="stylesheet">
    <!--=== Owl Carousel CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/plugins/owl.carousel.min.css'}}" rel="stylesheet">
    <!--=== Gijgo CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/plugins/gijgo.css'}}" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="{{ $new.'/resources/assetsite/hstyle.css'}}" rel="stylesheet">
    <!--=== Responsive CSS ===-->
    <link href="{{ $new.'/resources/assetsite/css/responsive.css'}}" rel="stylesheet">

    <script src="{{ $new.'/resources/assetsite/js/jquery-3.2.1.min.js'}}"></script>

    <!-- <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d8df48d981da200122534d7&product=inline-share-buttons' async='async'></script> -->

    
    
</head>

