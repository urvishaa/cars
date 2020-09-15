<?php $__env->startSection('content'); ?>

<script>
function filterGlobal () {
    $('#tabuserid').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}
    $(document).ready(function () {
        $('#tabuserid').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('admin/users/allsearch')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "u_type" },
                { "data": "options" }
            ]    

        });
        $('#category').on( 'change', function () {
             filterGlobal();
        })
    });
</script>
    <div class="box-header-main">
    <h3 class="page-title">Users </h3>    
    <p><a href="<?php echo e(url('/admin/users/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>Add New</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> Delete</a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           Users List
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
     
                
               
                <div class="input-group">
               
                      <select name="category" id="category">  
                        <option value="">--Select User Group--</option>              
                        <?php $__empty_1 = true; $__currentLoopData = $usergroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($value->id); ?>" <?php if($catsearch==$value->id): ?> selected=selected <?php endif; ?>><?php echo e($value->typeName); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>            
                    </select> 
                    <a href="<?php echo e(url('/admin/users')); ?>" id="cancel" name="cancel" class="btn btn-default">Clear</a>

                   
                </div>

        </div>
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuserid">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th>Id</th>                     
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type </th>
                        <th>Action</th>
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
                    type:'GET',
                    url:'<?php echo e(url("/users/alldelete")); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                        window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one User'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>