<?php $__env->startSection('content'); ?>


<script>
function filterGlobal () {
    $('#tabpropertyidproper').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}
    $(document).ready(function () {
        $('#tabpropertyidproper').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "<?php echo e(url('admin/property/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "property_img" },
                { "data": "property_name" },
                { "data": "sale_price" },
                { "data": "ownerid" },
                { "data": "agentid" },
                { "data": "options" }
            ]    

        });
        $('#category').on( 'change', function () {
             filterGlobal();
        })
    });
</script>
    <div class="box-header-main">
    <h3 class="page-title ">Property </h3>    
    <p><a href="<?php echo e(url('/admin/property/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>Add New</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> Delete</a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           Property List
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
     
       

        </div>
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabpropertyidproper">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th>Id</th>                     
                        <th>Property Image</th>
                        <th>Property Name</th>
                        <th>Price</th>
                        <th>Owner Name</th>
                        <th>Agent Name</th>
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
            var res=confirm('Are you Sure you want to delete Property?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'<?php echo e(url("admin/property/propertymultidelete")); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one Property'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>