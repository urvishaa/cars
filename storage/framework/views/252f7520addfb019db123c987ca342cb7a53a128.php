<?php $__env->startSection('content'); ?>
 <section id="intro" class="clearfix">
    <div class="container d-flex h-100">
      <div class="row justify-content-center align-self-center">
        <div class="col-md-4 intro-info order-md-first order-last">
          <h2 class="wow fadeInUp">TRANSFORM<br>IN JUST<span>8 WEEKS!</span></h2>
          <div class="banerbtn wow fadeInUp">
            <a href="<?php echo e(URL::to('/buynow')); ?>" class="btn-get-started scrollto">JOIN US!</a>
          </div>
        </div>
  
        <div class="col-md-6 intro-img order-md-last order-first">
          <img src="<?php echo e(URL::to('/resources/assets/img/mayanassar1.png')); ?>">
        </div>
      </div>

    </div>
  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">

      <div class="container">
        <div class="row">

          <div class="col-lg-5 col-md-6">
            <div class="about-img wow fadeInLeft">
              <img src="<?php echo e(URL::to('/resources/assets/img/about-img.jpg')); ?>" alt="">
            </div>
          </div>

          <div class="col-lg-5 col-md-6">
            <div class="about-content">
              <h2>ABOUT MAYA</h2>
              
              <p>Maya Nassar is a fitness entrepreneur,international fitness model champion and certified specialist in sports nutritionand personal training.<br>She started her fitness journey several years ago when she transformed from being overweight and unhealthy to getting into the best shape of her life. Maya has lost a total of five dress sizes and 20 kilograms of fat.</p>
              
              <p>She started competing in fitness modeling competitions internationally and has won a total of 9 trophies. Maya is the only athlete in history to be endorsed by an Arab government to compete abroad internationally.<br>Maya is currently a proud owner of a brand with over 300,000+ followers which encompassed a live TV fitness
                show, an online platform consisting of a website and fitness mobile app, 
                and a state-of-the-art fitness center with two successful branches.</p>
              <a href="http://startlivingright.net" target="_blank" class="rteip">Visit maya’s SITE</a>
              
            </div>
          </div>
        </div>
      </div>

    </section><!-- #about -->


    <!--==========================
      Services Section
    ============================-->
   

    <!--==========================
      Why Us Section
    ============================-->
    <section class="why-us">
      <div class="container">
        
        <header class="section-header">
          <h3>PERSONALIZED<br>TRAINING PROGRAM</h3>
          <p>Starting at 99$</p>
        </header>

        <div class="row">

          <div class="col-lg-9 col-xl-7">
            <div class="tr-zire">
              <div class="row">
                <div class="col-md-12 row wow fadeInUp">
                    <div class="col-md-6 stri-tri">
                      <div class="stri-img">
                        <img src="<?php echo e(URL::to('/resources/assets/img/about-1.jpg')); ?>">
                        <p class="tre">Diet Plans Only</p>
                      </div>
                       <div class="stri-abt">
                          <p class="week">8 weeks $99</p>
                          <p class="minute">15 minute phone consultation<br>
                          Customized diet plan</p>
                       </div>
                    </div>
                    <div class="col-md-6 stri-tri">
                      <div class="stri-img">
                        <img src="<?php echo e(URL::to('/resources/assets/img/about-2.jpg')); ?>">
                        <p class="tre">Training Programs Only</p>
                      </div>
                       <div class="stri-abt">
                          <p class="week">4 weeks $99</p>
                          <p class="minute">15 minute phone consultation<br>
                          Customized diet plan</p>
                       </div>
                     </div>
                    
                </div>
                <div class="col-md-12 row wow fadeInUp">
                    <div class="col-md-6 stri-tri">
                      <div class="stri-img">
                        <img src="<?php echo e(URL::to('/resources/assets/img/about-3.jpg')); ?>">
                        <p class="pack">Standard Package</p>
                        <p class="time">8 Week Diet + Training Plan</p>
                      </div>
                       <div class="stri-abt">
                          <p class="week">8 weeks $99</p>
                          <p class="minute">15 minute phone consultation</p>
                       </div>
                    </div>
                      <div class="col-md-6 stri-tri">
                        <div class="stri-img">
                          <img src="<?php echo e(URL::to('/resources/assets/img/about-4.jpg')); ?>">
                          <p class="tre">Gold Package</p>
                        </div>
                           <div class="stri-abt">
                              <p class="week">12 weeks plan 270$</p>
                              <p class="minute">15 minute phone consultation</p>
                           </div>
                      </div>
                   </div>
                  </div>  
                <div class="col-md-12">
                  <div class="terra col-md-12">
                      <a href="<?php echo e(URL::to('/buynow')); ?>">buy now</a>
                  </div>
                </div>
            </div>
          </div>

          <div class="myansr-prslzd">
            <img src="<?php echo e(URL::to('/resources/assets/img/mayanassar2.png')); ?>">
          </div>

        </div>

      </div>

    
    </section>



  <?php $__env->stopSection(); ?> 


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>