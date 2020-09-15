
<footer class="footer-content">
  <div class="container">
    <div class="row btm_brdr">
      <div class="col-12 col-md-6 col-lg-4">
        <div class="footer-block">
        	<div class="single-footer">
              <h5><?php echo app('translator')->getFromJson('website.Navigation'); ?></h5>
              <ul class="links-list pl-0 mb-0">
                <li> <a href="<?php echo e(URL::to('/')); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo app('translator')->getFromJson('website.Home'); ?></a> </li>
                <li> <a href="<?php echo e(URL::to('/shop')); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo app('translator')->getFromJson('website.About'); ?></a> </li>
                <li> <a href="<?php echo e(URL::to('/orders')); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo app('translator')->getFromJson('website.Services'); ?></a> </li>
                <li> <a href="<?php echo e(URL::to('/contact-us')); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo app('translator')->getFromJson('website.Contact'); ?></a> </li>
               <!--  <li> <a href="<?php echo e(URL::to('/wishlist')); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo app('translator')->getFromJson('website.Wishlist'); ?></a> </li> -->            
              </ul>
            </div>
            <div class="single-footer">
              <h5><?php echo app('translator')->getFromJson('website.Shop'); ?></h5>
              <ul class="links-list pl-0 mb-0">
                <li>New In </li>
                <li>Floral </li>
                <li>Fabrics </li>
                <li>Tools </li>
                <li>Decor </li>
                <!-- <?php if(count($result['commonContent']['pages'])): ?>
                    <?php $__currentLoopData = $result['commonContent']['pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li> <a href="<?php echo e(URL::to('/page?name='.$page->slug)); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo e($page->name); ?></a> </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>       -->      
               
              </ul>
            </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="single-footer abt_str">
          <h5><?php echo app('translator')->getFromJson('website.Contact Us'); ?></h5>
          <ul class="contact-list  pl-0 mb-0">
            <li> <i class="fa fa-map-marker"></i><span><?php echo e($result['commonContent']['setting'][4]->value); ?> <?php echo e($result['commonContent']['setting'][5]->value); ?> <?php echo e($result['commonContent']['setting'][6]->value); ?>, <?php echo e($result['commonContent']['setting'][7]->value); ?> <?php echo e($result['commonContent']['setting'][8]->value); ?></span> </li>
            <li> <i class="fa fa-phone"></i><span><?php echo e($result['commonContent']['setting'][11]->value); ?></span> </li>
            <li> <i class="fa fa-envelope"></i><span> <a href="mailto:sales@brandbychoice.com"><?php echo e($result['commonContent']['setting'][3]->value); ?></a> </span> </li>
      
          </ul>
        </div>
      </div>

      <div class="col-12 col-lg-4">
        <div class="single-footer flast_col">
            <div class="newsletter">
            	<h5><?php echo app('translator')->getFromJson('website.Subscribe for Newsletter'); ?></h5>
                <div class="block">
                    <input type="email" placeholder="<?php echo app('translator')->getFromJson('website.Your email address here'); ?>">
                    <button type="button" class="btn btn-secondary"><?php echo app('translator')->getFromJson('website.Subscribe'); ?></button>
                </div>
            </div>
            
            <div class="socials">
            	<!-- <h5><?php echo app('translator')->getFromJson('website.Follow Us'); ?></h5> -->
                <ul class="list">
                	<li>
                    	<?php if(!empty($result['commonContent']['setting'][50]->value)): ?>
                    		<a href="<?php echo e($result['commonContent']['setting'][50]->value); ?>" class="fa fa-facebook" target="_blank"></a>
                        <?php else: ?>
                        	<a href="#" class="fa fa-facebook"></a>
                        <?php endif; ?>                        
                    </li>
                    <li>
                    <?php if(!empty($result['commonContent']['setting'][52]->value)): ?>
                        <a href="<?php echo e($result['commonContent']['setting'][52]->value); ?>" class="fa fa-twitter" target="_blank"></a>
                    <?php else: ?>
                        <a href="#" class="fa fa-twitter"></a>
                    <?php endif; ?></li>
                    <li>
                    <?php if(!empty($result['commonContent']['setting'][51]->value)): ?>
                        <a href="<?php echo e($result['commonContent']['setting'][51]->value); ?>" class="fa fa-google" target="_blank"></a>
                    <?php else: ?>
                        <a href="#" class="fa fa-google"></a>
                    <?php endif; ?>
                    </li>
                    <li>
                    <?php if(!empty($result['commonContent']['setting'][53]->value)): ?>
                        <a href="<?php echo e($result['commonContent']['setting'][53]->value); ?>" class="fa fa-linkedin" target="_blank"></a>
                    <?php else: ?>
                        <a href="#" class="fa fa-linkedin"></a>
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
          
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="footer py-2 my-2">
  <div class="container">
    <div class="row">
    	<div class="footer-image col-12 col-md-6 cr-left">
          <p>© 2018 - KTG | All Rights Reserved</p>
            <!-- <img class="img-fluid" src="<?php echo e(asset('').'public/images/payments.png'); ?>"> -->
        </div>
        <div class="footer-info col-12 col-md-6 cr-right">
          <p>Designed & Developed by: <a href="http://besiders.com/" target="_blank"><img class="img-fluid" src="<?php echo e(asset('').'public/images/besiders.png'); ?>"></a></p>
          <!-- <p> © <?php echo app('translator')->getFromJson('website.Copy Rights'); ?>. <a href="#"><?php echo app('translator')->getFromJson('website.Privacy'); ?></a> · <a href="#"><?php echo app('translator')->getFromJson('website.Terms'); ?></a> </p> -->
        </div>
        <div class="floating-top"><a href="#" class="fa fa-angle-up"></a></div>
    </div>
  </div>
</div>

<!--notification-->
<div id="message_content"></div>

<!--- loader content --->
<div class="loader" id="loader">
	<img src="<?php echo e(asset('').'public/images/loader.gif'); ?>">
</div>
