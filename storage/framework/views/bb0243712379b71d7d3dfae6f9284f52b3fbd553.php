
<div class="container">

    <div class="heading">
        <h2>NEW ARRIVALS</h2>
    </div>
    <div class="homeslide owl-carousel owl-theme">
        
        <?php foreach($result['commonContent']['recentProducts']['product_data'] as $image) {  ?>
        <div class="item">
            <div class="slidiv">
                <div class="slidivone">
                    <img class="img-thumbnail" src="<?php echo e(asset('').$image->products_image); ?>" alt="img-fluid">
                </div>
                <div class="slidivtwo"> 
                    <span> <?php echo e($image->products_name); ?> </span>
                    <p> <?php echo html_entity_decode($image->products_description); ?></p>
                </div>   
            </div>
        </div>    
     <?php } ?>
    </div>
</div>    
