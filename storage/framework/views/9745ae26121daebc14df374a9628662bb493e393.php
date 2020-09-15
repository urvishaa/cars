<!DOCTYPE html>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
?>
 <?php @$session = Session::all(); ?>
<?php if(Session::get('language') == "ku"): ?>
<html lang="ku" class="arabic-lang kurdish-lang" dir="rtl">
<?php elseif(Session::get('language') == "en"): ?>
<html lang="en" class="eng-lang">
<?php else: ?>                
<html lang="ar" class="arabic-lang" dir="rtl">
<?php endif; ?>

<head>
   
    <meta charset="UTF-8" />
    <!-- <meta name="robots" content="noindex,nofollow" /> -->
<!--     <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo e(URL::to('/public/favicon.png')); ?>" type="image/x-icon" /> -->


    <title>Iraq Car</title>

     <meta name="og:url" content="<?php echo e(url('/')); ?>">  
     <meta property="og:title" content="<?php echo $__env->yieldContent('title'); ?>"> 
     <meta property="og:description" content="<?php echo $__env->yieldContent('description'); ?>"> 

    <meta property="og:image" content="<?php echo $__env->yieldContent('iamge'); ?>" />
    <meta property="og:image:alt" content="<?php echo e(URL::to('/public/default-image.jpeg')); ?>" />
    <meta property="og:image:secure_url" content="https://secure.example.com/ogp.jpg" /> 
    <meta property="og:image:type" content="image/jpeg" /> 
    <meta property="og:image:width" content="400" /> 
    <meta property="og:image:height" content="300" /> 


    <!--=== Bootstrap CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!--=== Vegas Min CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/plugins/vegas.min.css'); ?>" rel="stylesheet">
    <!--=== Slicknav CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/plugins/slicknav.min.css'); ?>" rel="stylesheet">
    <!--=== Magnific Popup CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/plugins/magnific-popup.css'); ?>" rel="stylesheet">
    <!--=== Owl Carousel CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/plugins/owl.carousel.min.css'); ?>" rel="stylesheet">
    <!--=== Gijgo CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/plugins/gijgo.css'); ?>" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/hstyle.css'); ?>" rel="stylesheet">
    <!--=== Responsive CSS ===-->
    <link href="<?php echo e($new.'/resources/assetsite/css/responsive.css'); ?>" rel="stylesheet">

    <script src="<?php echo e($new.'/resources/assetsite/js/jquery-3.2.1.min.js'); ?>"></script>

    <!-- <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d8df48d981da200122534d7&product=inline-share-buttons' async='async'></script> -->

    
    
</head>


