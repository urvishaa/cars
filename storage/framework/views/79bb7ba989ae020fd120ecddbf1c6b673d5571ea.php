  <header id="header">

    <div class="container">
      <div class="logo float-left">
        <h1 class="text-light"><a href="<?php echo e(URL::to('/')); ?>" class="scrollto"><img src="<?php echo e(URL::to('/resources/assets/img/logo.png')); ?>"></a></h1>
      </div>
    
      <?php $url_segment = Request::segment(1);  ?>
      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li class="<?php if($url_segment=="") { echo "active"; } else { echo ""; } ?>"><a href="<?php echo e(URL::to('/')); ?>">Meet Maya</a></li>
          <li class="<?php if($url_segment=="buynow") { echo "active"; } else { echo ""; } ?>"><a href="<?php echo e(URL::to('/buynow ')); ?>">Customize Meeting Plan</a></li>
          <li><a href="#">Pregnancy Guide</a></li>
          <li><a href="#">Contact Me</a></li>
          <li class="srch"><img src="<?php echo e(URL::to('/resources/assets/img/search.png')); ?>"></li>
        </ul>
      </nav>
      
    </div>
  </header>