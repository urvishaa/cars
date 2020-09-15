<?php $__env->startSection('content'); ?>

<script>
function filterGlobal () {
    $('#tabuserid').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}
    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('admin/procategory/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "name" },
                { "data": "ar" },
                { "data": "ku" },
                { "data": "published" },
                { "data": "options" }
            ]    

        });
        $('#category').on( 'change', function () {
             filterGlobal();
        })
    });
</script>

    <div class="box-header-main"><h3 class="page-title"><?php echo e(trans('labels.proCategory')); ?></h3>    
    <p>
    <a href="<?php echo e(url('/admin/procategory/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i><?php echo e(trans('labels.addNew')); ?></a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('labels.delete')); ?></a> </p></div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.proCategoryList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">    


        </div>
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th><?php echo e(trans('labels.id')); ?></th>                     
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.Ar')); ?></th>
                        <th><?php echo e(trans('labels.Ku')); ?></th>
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
            var res=confirm('Are you Sure you want to delete product category?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'<?php echo e(url("/admin/procategory/carCategoryalldelete")); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                   }    
                });            
        }
        else   {  alert('Select atleast one product category'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>