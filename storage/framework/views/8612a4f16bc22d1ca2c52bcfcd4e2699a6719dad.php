<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <?php if(!empty($web_setting[86]->value)): ?>
  	<link rel="icon" href="<?php echo e(asset('').$web_setting[86]->value); ?>" type="image/gif">
  <?php endif; ?>
  <link href="<?php echo asset('resources/views/admin/bootstrap/css/bootstrap.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset('resources/views/admin/bootstrap/css/styles.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/select2/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">
  <link href="<?php echo asset('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
  <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/datepicker/datepicker3.css'); ?>">
  <link href="<?php echo asset('resources/views/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset('resources/views/admin/dist/css/AdminLTE.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset('resources/views/admin/dist/css/skins/_all-skins.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset('resources/views/admin/plugins/iCheck/all.css'); ?>" media="all" rel="stylesheet" type="text/css" />    
 <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/timepicker/bootstrap-timepicker.min.css'); ?>">
 <link rel="stylesheet" href="<?php echo asset('resources/views/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
</head>
