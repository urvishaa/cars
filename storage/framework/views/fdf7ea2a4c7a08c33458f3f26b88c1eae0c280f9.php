<?php $__env->startSection('content'); ?>
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>
     <section class="store_main">
        <div class="container">
            <!-- <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.storeAdminList')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div> -->
                    <!-- <div class="car-rent-tr-fri">
                                    <form >
                                        <div class="s-brand input -text search-item">
                                           <input type="text" name="productname" id="productname" placeholder="<?php echo e(trans('labels.productName')); ?>">
                                        </div>


                                        <div class="s-year input -text search-item">
                                           <input type="text" name="storename" id="storename"  placeholder="<?php echo e(trans('labels.storeName')); ?>"> 
                                        </div>

                                        <div class="s-city search-item">
                                            <select class="custom-select" id="city" name="city">
                                                <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                                <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                      <option value="<?php echo e($city->id); ?>"><?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="main-srch-btn search-item">
                                            <button type="button" id="searchStore"><i class="fa fa-search"></i><span><?php echo e(trans('labels.search')); ?></span></button>
                                        </div>
                                    </form>
                                </div> -->

                                <div class="section-title  text-center sthowroom-detail">
                                    <div class="show-ret"> 
                                        <h2><?php echo e(trans('labels.storeAdminList')); ?></h2>
                                    </div>
                                    <div class="show-select">                             
                                        <select id="searchStore" name="searchStore">
                                          <option value="0" ><?php echo e(trans('labels.selectCity')); ?></option>
                                            <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                                  <option value="<?php echo e($city->id); ?>"  <?php if(isset($result['filters']) AND $result['filters'] == @$city->id): ?> selected <?php endif; ?> > <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                            <?php endif; ?>
                                        </select>                      
                                    </div>
                                </div>
                                <div class="img-store-lower">
                                    <div class="row low-retr-eri" id="store">
                                 
                                          <input type="hidden" name="totalcount" id="totalcount" value="0">
                                       
                                    </div>
                                </div>
        </div> 
     </section>
<script type="text/javascript">


$('#searchStore').change(function(){    
    // var city =  $('#city').val();
    var city = document.getElementById("searchStore").value;

    if(city == 0)
    {
        location.href = "<?php echo e(URL::to('/storeadminlist')); ?>"
    }
    
    $.ajax({
        url: "<?php echo e(URL::to('/storeResult')); ?>",
        method: "POST",
        data:{city:city},
        success: function(data){
     
          var reu = JSON.parse(data);
          $('#store').html(reu['result']);
           $('.property-slider2').owlCarousel({
            autoplay:true,
            autoplayHoverPause:true,
            loop:true,
            nav:false,
            dots:true,
            smartSpeed:1000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
           
        }
    });
  
    });


$(function() {
  
   
    load_data();

});

$(window).scroll(function(city=""){ 
    var city = document.getElementById("searchStore").value;       
    //$('.load_more_button').hide();
    if(city == ''){
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
          load_data($('#load_more_button').val());
        }
    }
   
  });

$(document).on("click", "#load_more_button", function() {
     $('.load_more_button').hide();
     load_data($('#load_more_button').val());
});


 function load_data(city='')
 { 
    var totalcount = $('#totalcount').val();
    var nodata = $('#nodata').val();
    
    if(nodata != 0)
    {
        
    $.ajax({
        url: "<?php echo e(URL::to('/storeResult')); ?>",
        method: "POST",
        data:{totalcount:totalcount,city:city},
        success: function(data){

        totalcount = parseInt(totalcount) + 8;
        $('#totalcount').val(totalcount);
        $('.load_more_button').hide();
          var reu = JSON.parse(data);
          
          $('#store').append(reu['result']);
           $('.property-slider2').owlCarousel({
            autoplay:true,
            autoplayHoverPause:true,
            loop:true,
            nav:false,
            dots:true,
            smartSpeed:1000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
           
        }
    });
    }

}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>