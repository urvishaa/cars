

<div class="container-fuild">
  <div class="container">
    <div class="products-area"> 

    
     <div class="heading">
        <h2>KTG FABRICS</h2>
      </div>
        <div class="row"> 
            <div class="col-xs-12 col-sm-12">
                <div class="row">
                    
                    <div class="products products-3x">
                        
                        <?php $counter = 0;
                        foreach($result['commonContent']['categories'] as $categories_data) {
                            if($categories_data->id !='6'){
                        ?>
                                <?php if($counter<=9): ?>
                                <div class="product">
                                    <div class="blog-post">
                                        <article>
                                            <div class="module">
                                                <a href="<?php echo e(URL::to('/shop?category='.$categories_data->slug)); ?>" class="cat-thumb">
                                                   <img class="img-fluid" src="<?php echo e(asset('').$categories_data->image); ?>" alt="<?php echo e($categories_data->name); ?>">             
                                                </a>
                                                <a href="<?php echo e(URL::to('/shop?category='.$categories_data->slug)); ?>" class="cat-title stars">
                                                    <?php
                                                    echo $categories_data->name;
                                                  
                                                    ?>
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                                <?php endif; ?>  
                                <?php $counter++;?>
                        <?php  }}?>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </div>
</div>



    <section class="newbane">
        <?php echo $__env->make('common.banner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>

