<script src="<?php echo e(url('public/adminlte/js')); ?>/jquery-1.11.3.min.js"></script>



<script src="<?php echo e(url('public/adminlte/js')); ?>/datatables.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/dataTables.buttons.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/buttons.flash.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/jszip.min.js"></script>


<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>

<script src="http://propertylaunch.pro/public/adminlte/js/buttons.html5.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/buttons.print.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/buttons.colVis.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/dataTables.select.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/jquery-ui.min.js"></script>	

<script src="http://propertylaunch.pro/public/adminlte/js/bootstrap.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/select2.full.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/main.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/plugins/fastclick/fastclick.js"></script>
<script src="http://propertylaunch.pro/public/adminlte/js/app.min.js"></script>
 <script src="http://propertylaunch.pro/public/adminlte/js/ckeditor.js"></script>
 <script src="http://propertylaunch.pro/public/adminlte/js/bootstrap-datepicker.js"></script>	
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
 window._token = '<?php echo e(csrf_token()); ?>';
$(document).ready(function(){ 
 $('.dataTables_filter').addClass('pull-left'); 
  $('.dt-buttons').addClass('pull-right'); 
 $('.dataTables_length').addClass('pull-right'); 
 $('.buttons-copy').css( 'display', 'none' );
 $('.buttons-print').css( 'display', 'none' );


 	$('#selectAll').click(function() {
        if ($(this).prop('checked')) {
            $('.case').prop('checked', true);
        } else {
            $('.case').prop('checked', false);
        }
    });


 });
    
	function ConfirmDelete()    //single delete row in all view
	{  
		var x = confirm("Are you sure you want to delete?");
		if(x)
	    	return true;
		else
	    	return false;
	}


</script>


 




<?php echo $__env->yieldContent('javascript'); ?>