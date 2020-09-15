@extends('layout')
@section('content')

<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
?>
<section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title  text-center">
                        <h2>car List</h2>
                        <span class="title-line"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="rent-part scrollpane" >
                    
                            <div class="item" id="post_data">
                                
                            </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

<script>

 function load_data(id="",sort="")
 { 


 	 var type = '<?php if (!empty($_GET['search'])) {  echo $_GET['search']; } ?>';
 	 var city = '<?php if (!empty($_GET['city'])) {  echo $_GET['city']; } ?>';
   var category = '<?php if (!empty($_GET['category'])) {  echo $_GET['category']; } ?>';
 	 var totalcount = $('#totalcount').val();
 	
  $.ajax({
   url:"{{ url('car_listing/load_data') }}",
   method:"POST",
   data:{
   		  id:id,
		  sort:sort,
		  type:type,
		  city:city,
      category:category,
		  totalcount:totalcount,
		  
   },
 	
   success:function(response)
   { 
      //alert(response);
      /*var reu = JSON.parse(response);
      var deta = reu['resultdata'];
      var info = reu['infowindow'];
      totalcount = parseInt(totalcount) + 4;
      $('#totalcount').val(totalcount);
*/
      //alert(reu['infowindow']);
      //console.log(reu['infowindow']);

//      map_data(deta,info);
     
   		
    $('#load_more_button').remove();
    //$('#post_data').append(reu['result']);
    $('#post_data').append(response);
    
    	if($('.bannr-ad-slider').length)
		{ 
			var bannrAdSlider = $('.bannr-ad-slider');
			bannrAdSlider.owlCarousel(
			{
				autoplay:true,
				autoplayHoverPause:true,
				loop:true,
				nav:false,
				dots:true,
				smartSpeed:1000,
				responsive:{
			        0:{
			            items:1,
			        },
			        600:{
			            items:1,
			        },
			        1000:{
			            items:1,
			        }
			    }
			});
		}
   }
  })

}



 $(function() {
    load_data();
    $(".scrollpane").scroll(function() {  //alert('hello');
        var $this = $(this);

        // alert($this); return false;
       //alert($this.scrollTop()); return false;
        var $results = $("#post_data");
        //alert($results.data()); return false;
        //if ($results.data("loading")) { 
			if ($this.scrollTop() + $this.height() == $results.height()) {
            	load_data($('#load_more_button').data('id'));
            } 
        //} else {
            //alert('hello'); return false;
        //}
    });
});




 /*$(document).on('click', '#load_more_button', function(){ //alert('jiiii'); return false;
  var id = $(this).data('id');
  $('#load_more_button').html('<b>Loading...</b>');
//  load_data(id);
 });*/


$(document).ready(function()
{
	"use strict";
	initbannrAdSlider();
	function initbannrAdSlider()
	{
		if($('.bannr-ad-slider').length)
		{
			var bannrAdSlider = $('.bannr-ad-slider');
			bannrAdSlider.owlCarousel(
			{
				autoplay:true,
				autoplayHoverPause:true,
				loop:true,
				nav:false,
				dots:true,
				smartSpeed:1000,
				responsive:{
			        0:{
			            items:1,
			        },
			        600:{
			            items:1,
			        },
			        1000:{
			            items:1,
			        }
			    }
			});
		}
	}

});

</script>

@endsection