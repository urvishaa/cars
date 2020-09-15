<?php $__env->startSection('content'); ?>

<script>
function filterGlobal () { 
    oTable = $('#tabuseridpos').DataTable()
        oTable.columns(1).search($('#storeName').val().trim());  
       
        oTable.draw();  
    

}
    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('admin/car_accessories/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "storeName" },
                { "data": "image" },
                { "data": "name" },
                { "data": "price" },
                { "data": "published" },
                { "data": "options" }
            ]    

        });
        $('#storeName').on( 'change', function () { 
             filterGlobal();
        })
    });
</script>
 <?php $admin = auth()->guard('admin')->user(); ?>
    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.Product')); ?></h3>    
    <p><a href="<?php echo e(url('/admin/car_accessories/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i><?php echo e(trans('labels.addNew')); ?></a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('labels.delete')); ?></a> </p></div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.ProductList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">

            <?php if($admin['issubadmin'] == 0 ): ?>
                <div class="input-group">
                    <select name="storeName" id="storeName">  
                        <option value=""><?php echo e(trans('labels.SelectStore')); ?></option>              
                        <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                              <option value="<?php echo e($store->myid); ?>"><?php echo e($store->first_name); ?> <?php echo e($store->last_name); ?></option>                          
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                        <?php endif; ?>                
                    </select> 
                
                <a href="<?php echo e(url('/admin/car_accessories')); ?>" id="cancel" name="cancel" class="btn btn-default">Clear</a>
            </div>
            <?php endif; ?>
                
           

        </div>
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th><?php echo e(trans('labels.id')); ?></th>                     
                        <th><?php echo e(trans('labels.storeName')); ?></th>                     
                        <th><?php echo e(trans('labels.image')); ?></th>
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.price')); ?></th>
                        <th><?php echo e(trans('labels.published')); ?></th>
                        <th><?php echo e(trans('labels.action')); ?></th>
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
            var res=confirm('Are you Sure you want to delete product?');
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
        else   {  alert('Select atleast one product'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>