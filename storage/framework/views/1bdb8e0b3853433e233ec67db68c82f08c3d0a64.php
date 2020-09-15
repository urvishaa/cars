<?php $__env->startSection('content'); ?>

<script>
/*function filterGlobal () {
    $('#tabuserid').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}*/
    $(document).ready(function () { 
        // var urls = "<?php echo e(route('admin.orderlist.allposts')); ?>";

        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(route('admin.order_rental.allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "id" },
                { "data": "firstName" },
                 { "data": "email" },
                  { "data": "total" },
                  { "data": "phone" },
                { "data": "options" }
            ]    

        });
        /*$('#category').on( 'change', function () {
             filterGlobal();
        })*/
    });
</script>

    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.orderList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>          
                            <th><?php echo e(trans('labels.orderid')); ?></th>                     
                            <th><?php echo e(trans('labels.name')); ?></th>
                            <th><?php echo e(trans('labels.status')); ?></th>
                            <th><?php echo e(trans('labels.total')); ?></th>
                            <th><?php echo e(trans('labels.date')); ?></th>
                            <th><?php echo e(trans('labels.action')); ?></th>
                        </tr>

                    </thead>
                       
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>