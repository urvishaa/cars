


<?php echo $__env->make('common.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


   <body class="loader-active fixmycls">
      <?php echo $__env->make('common.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    	<?php echo $__env->yieldContent('content'); ?>    
      <?php echo $__env->make('common.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	</body>

</html>

