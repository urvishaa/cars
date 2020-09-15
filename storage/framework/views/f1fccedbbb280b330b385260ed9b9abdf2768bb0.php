<?php $__env->startSection('content'); ?>

<script>

    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('admin/contactAgent/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "id" },
                { "data": "agentName" },
                { "data": "type" },
                { "data": "name" },
                { "data": "nationality" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "dateFrom" },
                { "data": "dateTo" }
                
            ]    

        });
    });
</script>

    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.contactAgent')); ?></h3>    
    </div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.ProductList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
       
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>                        
                        <th><?php echo e(trans('labels.id')); ?></th>                     
                        <th><?php echo e(trans('labels.agentName')); ?></th>
                        <th><?php echo e(trans('labels.type')); ?></th>
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.nationality')); ?></th>
                        <th><?php echo e(trans('labels.email')); ?></th>
                        <th><?php echo e(trans('labels.phone')); ?></th>
                        <th><?php echo e(trans('labels.dateFrom')); ?></th>
                        <th><?php echo e(trans('labels.dateTo')); ?></th>
                    </tr>
                </thead>       

            </table>
            </div>
        </div>
    </div>

<script type="text/javascript">

$( document ).ready(function() {
    $('.deletesellected').click(function(){ 
        var checkValues = $('input[name=case]:checked').map(function()
        {  return $(this).val(); }).get();

        if(checkValues !='')
        {
            var res=confirm('Are you Sure you want to delete User?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'<?php echo e(url("/admin/car_accessories/alldelete")); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                        //alert(data); return false;
                        location.reload();
                        
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one User'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>