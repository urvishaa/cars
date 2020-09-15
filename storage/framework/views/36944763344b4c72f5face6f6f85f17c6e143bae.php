<div class="hakromain">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<div id="demo" class="demon">
    <div class="container">  
        <div class="floware">   

            <ul class="ulmycls">
                <li class="dropdownMenuButtonn">
                <div class="dropdown dropdownMenuButtonn">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category
                  </button>
                  <div class="dropdown-menu dropdownMenuButtonn" aria-labelledby="dropdownMenuButtonn">
                    <ul>
                        <h3>Category</h3>

                        <?php foreach($result['commonContent']['categories'] as $cate) { ?>
                        <li class="dropdown-item <?php echo "catt".$cate->id; ?>" onclick="newprocess('<?php echo $cate->id; ?>','1')" ids="<?php echo $cate->id; ?>" iddata="<?php echo "catt".$cate->id; ?>" databy="<?php echo trim($cate->name); ?>"> <i class="fa fa-check"></i> <?php echo $cate->name; ?></li>
                        <?php } ?>
                    </ul>
                  </div>
                </div>
                </li>


                <?php $main_array =array();  
                    foreach($result['all_attribute'] as $all_attribute) { ?>
                    <li  class="dropdownMenuButton<?php echo $all_attribute['product_main']->products_options_id; ?>">
                    <div class="dropdown dropdownMenuButton<?php echo $all_attribute['product_main']->products_options_id; ?>" > 
                        <?php 

                        $main_array[]=$all_attribute['product_main']->products_options_id; 
                        ?>
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $all_attribute['product_main']->products_options_id; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $all_attribute['product_main']->products_options_name; ?>
                      </button>
                      <div class="dropdown-menu dropdownMenuButton<?php echo $all_attribute['product_main']->products_options_id; ?>" aria-labelledby="dropdownMenuButton<?php echo $all_attribute['product_main']->products_options_id; ?>">
                        <ul>
                            <h3>   <?php echo  $all_attribute['product_main']->products_options_name; ?> </h3>
                            <?php foreach($all_attribute['product_detai'] as $detail) { ?>
                                <li class="dropdown-item <?php echo "att".$detail->products_options_values_id; ?>" iddata="<?php echo "att".$detail->products_options_values_id; ?>" onclick="newprocess('<?php echo $cate->id; ?>','2')" databy="<?php echo trim($detail->products_options_values_name); ?>"> <i class="fa fa-check"></i> <?php echo $detail->products_options_values_name ?></li>
                            <?php } ?>
                        </ul>
                      </div>
                    </div>
                    </li>
                <?php }  ?> 

            </ul>   

            <div class="newwrapper">
              <input type="text" placeholder="Search..">
            </div> 
        </div>  
     </div>
</div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php $__currentLoopData = $result['slides']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$slides_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li data-target="#myCarousel" data-slide-to="<?php echo e($key); ?>" class="<?php if($key==0): ?> active <?php endif; ?>"></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ol>
	<div class="carousel-inner">
    	
		<?php $__currentLoopData = $result['slides']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$slides_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<div class="carousel-item  <?php if($key==0): ?> active <?php endif; ?>">

				<a href="<?php echo e(URL::to('shop?type=deals')); ?>">			
				<img width="100%" class="first-slide"  src="<?php echo e(asset('').$slides_data->image); ?>" width="100%" alt="First slide">
				</a>
				
				<div class="slidermain">
					<div class="sliderinr">
				        <a href="<?php echo e($slides_data->url); ?>"><?php echo e($slides_data->title); ?></a>
				        <!-- <p><?php echo e($slides_data->title); ?></p> -->
				    </div>
				</div>
			</div>		
					
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


	</div>
</div>
</div>


