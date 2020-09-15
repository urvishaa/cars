<?php $__env->startSection('content'); ?>
<?php
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  // href='.url("/car_Detail/$row->id").'>';
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
  //  alert('hello2'); return false;
    $( "#amount" ).val( "$" + 1000 + " - $" + 15000 );  
    $( "#slider-range" ).slider({ 
      range: true,
      min: 1000,
      max: 100000,
   		values: [ 1000, 15000 ],
      slide: function( event, ui ){ 
        
       $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );   
       $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        var carbrand = document.getElementById("carbrand").value;
        var city = document.getElementById("city").value;
        var year = document.getElementById("year").value;  
        var minkm = document.getElementById("minkm").value;
        var maxkm = document.getElementById("maxkm").value;    
       
          var minprice = ui.values[0];
          var maxprice = ui.values[1];
          $('#minprice').val(minprice);
          $('#maxprice').val(maxprice) ;
          $.ajax({
            url: '<?php echo e(URL::to("/carResult")); ?>',
            type: 'POST',        
            data: {minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,carbrand:carbrand,city:city,year:year},
            success: function(repsonse){
              //alert(repsonse); return false;
              var reu = JSON.parse(repsonse);
             $('#car').html(reu['result']);
            },
          });
      
      }
    });

  });


   $( function() {
  //  alert('hello1'); return false;

       $( "#amount1" ).val( "$" + 100 + " - $" + 55000 );  
    $( "#slider-range1" ).slider({
      range: true,
      min: 100,
      max: 500000,
     values: [ 100, 55000 ],
      slide: function( event, ui ) {
          $( "#amount1" ).val(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );   
          $( "#amount1" ).val( $( "#slider-range1" ).slider( "values", 0 ) +
          " - " + $( "#slider-range1" ).slider( "values", 1 ) );
          var carbrand = document.getElementById("carbrand").value;
          var city = document.getElementById("city").value;  
          var year = document.getElementById("year").value;  
          var minprice = document.getElementById("minprice").value;
          var maxprice = document.getElementById("maxprice").value;  
     
          var minkm = ui.values[0];
          var maxkm = ui.values[1];
          $('#minkm').val( ui.values[0] )
          $('#maxkm').val( ui.values[1] )
          $.ajax({
            url: '<?php echo e(URL::to("/carResult")); ?>',
            type: 'POST',
            data: {minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,carbrand:carbrand,city:city,year:year},
            success: function(repsonse){
              var reu = JSON.parse(repsonse);
              $('#car').html(reu['result']);
            },
          });
      }
    });
  });
   
  </script>

<section id="sell-buy-main" class="section-padding sell-buy-main">
        <div class="container">
            <div class="row">
                <!-- Section Title Start -->
                <div class="col-lg-12">
                    <div class="section-title  text-center">
                        <h2><?php echo e(trans('labels.sellBuyCar')); ?></h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                </div>
                <!-- Section Title End -->
            </div>
            <div class="row">
                
                <div class="col-md-4 col-lg-3">
                    <div class="sell-sidebar-ter">
                        <h3><label><?php echo e(trans('labels.filter')); ?></label><button id="btnClear"><?php echo e(trans('labels.clear')); ?></button></h3>

                        <div class="chs-sidebar">
                            <div class="chk-select">
                                <div class="ch-tri">
                                    <select name="carbrand" onchange="ddfilter()" id="carbrand">
                                      <option value=""><?php echo e(trans('labels.carBrand')); ?></option>
                                      <?php $__empty_1 = true; $__currentLoopData = $result['brand']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brands): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                            <option value="<?php echo e($brands->id); ?>"  <?php if(isset($_GET['brand'])): ?> <?php if($_GET['brand']==$brands->id): ?>  <?php echo e('selected="selected"'); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?> <?php endif; ?> >
                                            <?php if(isset($session['language']) AND $session['language']=='en'): ?> <?php echo e($brands->name); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($brands->ku); ?> <?php else: ?> <?php echo e($brands->ar); ?> <?php endif; ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                      <?php endif; ?>
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="category" onchange="ddfilter()" id="category">
                                      <option value=""><?php echo e(trans('labels.selectCategory')); ?></option>
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="year" onchange="ddfilter()" id="year">
                                     <option  value=""><?php echo e(trans('labels.yearOfCar')); ?></option>
                                      <?php $__empty_1 = true; $__currentLoopData = $result['year']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $years): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                            <option value="<?php echo e($years); ?>"  <?php if(isset($_GET['year'])): ?> <?php if($_GET['year']==$years): ?>  <?php echo e('selected="selected"'); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?> <?php endif; ?> > <?php echo e($years); ?> </option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                      <?php endif; ?>
                                    </select>
                                </div>
                                <div class="ch-tri">
                                    <select name="city" onchange="ddfilter()" id="city">
                                      <option value=""><?php echo e(trans('labels.selectCity')); ?></option>
                                      <?php $__empty_1 = true; $__currentLoopData = $result['city']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                            <option value="<?php echo e($city->id); ?>" <?php if(isset($_GET['city'])): ?> <?php if($_GET['city']==$city->id): ?>  <?php echo e('selected="selected"'); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?> <?php endif; ?>> <?php if(isset($session['language']) AND $session['language']=='ar'): ?> <?php echo e($city->ar); ?> <?php elseif(isset($session['language']) AND $session['language']=='ku'): ?> <?php echo e($city->ku); ?> <?php else: ?> <?php echo e($city->name); ?> <?php endif; ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                      <?php endif; ?>
                                    </select>
                                </div>
                               
                               <input type="hidden" name="maxprice" id="maxprice" value="">
                               <input type="hidden" name="minprice" id="minprice" value="">
                                <input type="hidden" name="maxkm" id="maxkm" value="">
                               <input type="hidden" name="minkm" id="minkm" value="">
                              
<!-- 
                              <input type="hidden" name="maxkm" id="maxkm" value=""> -->
                              <input type="hidden" name="brandhide" id="brandhide" value="<?php if( isset( $_GET['brand'] ) ): ?><?php echo e($_GET['brand']); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?>">
                              <input type="hidden" name="cityhide" id="cityhide" value="<?php if( isset( $_GET['city'] ) ): ?><?php echo e($_GET['city']); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?>">
                              <input type="hidden" name="yearhide" id="yearhide" value="<?php if( isset( $_GET['year'] ) ): ?><?php echo e($_GET['year']); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?>">
                              <input type="hidden" name="categoryhide" id="categoryhide" value="<?php if( isset( $_GET['category'] ) ): ?><?php echo e($_GET['category']); ?> <?php else: ?> <?php echo e(''); ?> <?php endif; ?>">


                                <div class="ch-tri">
                                  <label for="amount"><?php echo e(trans('labels.priceRange')); ?>:</label>
                                  <!-- <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold; display: none;"> -->
                                  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                               <div id="slider-range"></div>
                                </div>

                                <div class="ch-tri">
                                  <label for="amount1"><?php echo e(trans('labels.kilometerRange')); ?>:</label>
                                  <!-- <input type="text1" id="amount1" readonly style="border:0; color:#f6931f; font-weight:bold; display: none;"> -->
                                  <input type="text" id="amount1" readonly style="border:0; color:#f6931f; font-weight:bold;">
                               <div id="slider-range1"></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
               
                <div class="col-md-8 col-lg-9">

                  <div class="blog_posts main_sec scrollpane">
                    <div class="row" id="car">
                          <input type="hidden" name="totalcount" id="totalcount" value="0">
                       
                    </div>
                  </div>
                </div>
                
            </div>
        </div>
    </section>
<script type="text/javascript">


$(function() {
    load_data();
  //  alert('hello'); return false;

    var carbrand =jQuery('#carbrand').val();
    var category = "<?php echo e($result['selectedCategory']); ?>";
    jQuery.ajax({
        type: "GET",
        url: '<?php echo e(route("category.filter")); ?>',
        data: {'id':carbrand,'selectedCategory':category},
        success: function(res){
          jQuery("#category").html(res);
        }
      });

});

$(window).scroll(function(city="",carbrand="",category="",year="",maxprice="",minprice="",maxkm="",minkm=""){ 

    var carbrand = document.getElementById("carbrand").value;
    var city = document.getElementById("city").value;
    var year = document.getElementById("year").value;
    var category = document.getElementById("category").value;
    var minkm = document.getElementById("minkm").value;
    var maxkm = document.getElementById("maxkm").value;  
    var minprice = document.getElementById("minprice").value;
    var maxprice = document.getElementById("maxprice").value; 
    
    
   if(city == '' && carbrand =='' && category =='' && year =='' && maxprice =='' && minprice == '' && maxkm == '' && minkm == ""){
      if($(window).scrollTop() + $(window).height() == $(document).height()) {
        load_data($('#load_more_button').data('id'));

      }
    }
  });


  
// $('#load_more_button').click(function(){
$(document).on("click", "#load_more_button", function() {
     $('.load_more_button').hide();
     load_data($('#load_more_button').data('id'));
});



 function load_data(sort="")
 { 
  //alert('hello');
    
    var carbrand = document.getElementById("brandhide").value;
    var city = document.getElementById("cityhide").value;
    var year = document.getElementById("yearhide").value;
    var category = document.getElementById("categoryhide").value;
    var totalcount = $('#totalcount').val();
    var nodata = $('#nodata').val();

    
    if(nodata != 0){
        $.ajax({
            url: "<?php echo e(URL::to('/carResult')); ?>",
            method: "POST",
            data:{carbrand:carbrand,city:city,year:year,category:category,totalcount:totalcount},
            success: function(data){
            totalcount = parseInt(totalcount) + 21;
            $('#totalcount').val(totalcount);
             $('#hppp').hide();
              var reu = JSON.parse(data);
              $('#car').append(reu['result']);
               
            }
        });
      }
}



$('#btnClear').click(function(){  
  location.href = "<?php echo e(URL::to('/sell-list')); ?>"
});


  


function ddfilter(){ 
  var carbrand = document.getElementById("carbrand").value;
  var city = document.getElementById("city").value;
  var year = document.getElementById("year").value;
  var category = document.getElementById("category").value;
  var minkm = document.getElementById("minkm").value;
  var maxkm = document.getElementById("maxkm").value;  
  var minprice = document.getElementById("minprice").value;
  var maxprice = document.getElementById("maxprice").value; 
  var totalcount = $('#totalcount').val(); 
 
  if(city == ''){ city = null }
  if(carbrand == ''){ carbrand = null }
  if(category == ''){ category = null }
  if(year == ''){ year = null }
  if(carbrand != ""){
    var cats = jQuery("#category").val();
    jQuery("#category").empty();
    jQuery.ajax({
				type: "GET",
				url: '<?php echo e(route("category.filter")); ?>',
				data: {'id':carbrand,'selectedCategory':cats},
				success: function(res){
					jQuery("#category").html(res);
				}
			});
  }
   $.ajax({
      url: "<?php echo e(URL::to('/carResult')); ?>",
      method: "POST",
      data:{carbrand:carbrand,city:city,minkm:minkm,maxkm:maxkm,minprice:minprice,maxprice:maxprice,year:year,category:category,totalcount:totalcount},
      success: function(data){
   
        var reu = JSON.parse(data);
        $('#car').html(reu['result']);
      }
  });
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>