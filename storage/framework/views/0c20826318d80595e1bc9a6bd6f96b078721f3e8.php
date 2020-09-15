<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo e(url('/admin')); ?>" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           School</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           School</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
         <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <!-- <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> -->
            <i class="fas fa-bars"></i>
        </a>


       <?php 
         /*$user = Auth::getUser();        
        if($user->u_type!=4)
        {
               echo ("<script LANGUAGE='JavaScript'>
           window.location.href=document.location.origin+'/schoolpro';
            </script>");
        }*/
       ?>
                
        <a href="<?php echo e(url('')); ?>"  target="_blank" class="newlogocls" style="float:right;" title="Preview school">
          view site <i class="fas fa-arrow-alt-circle-right"></i>           
        </a>
    </nav>
 
</header>



