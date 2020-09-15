<?php $__env->startSection('content'); ?>

<?php //echo "<pre>";
//print_r($result['error']); exit; ?>
 

  <main id="main">
    <section id="about">
      <div class="container">
        <div class="row">

        
         
          <div class="col-lg-10 col-md-12">
            <div class="about">
              <FONT color='orange'><b>Not Calculated - No 'SECURE_SECRET' present.</b></FONT> <br>
              <a href="<?php echo e(URL::to('/')); ?>" class="rteip">BACK TO SITE</a>              
            </div>
          </div>
        </div>
      </div>

    </section>
  <?php $__env->stopSection(); ?> 


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>