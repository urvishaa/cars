<?php $__env->startSection('content'); ?>


<script>
function filterGlobal () { 
    /*$('#tabpropertyidproper').DataTable().column([0,1]).search(
        $('#usertype').val()
        $('#userId').val()



    ).draw();*/

    oTable = $('#tabpropertyidproper').DataTable()
        oTable.columns(0).search($('#usertype').val().trim());  
        oTable.columns(1).search($('#userId').val().trim());  
        oTable.columns(2).search($('#showRoomId').val().trim());  
        oTable.draw();  
    

}
    $(document).ready(function () {
        $('#tabpropertyidproper').DataTable({
            "processing": true,
            "serverSide": true,
            
            "ajax":{
                     "url": "<?php echo e(url('admin/topProperty/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "propertyId" },
                { "data": "days" },
                { "data": "options" }
            ]    

        });
        $('#usertype').on( 'change', function () { 
             filterGlobal();
        })
        $('#userId').on( 'change', function () { 
             filterGlobal();
        })
        $('#showRoomId').on( 'change', function () { 
             filterGlobal();
        })
    });
</script>
    <div class="box-header-main">
    <h3 class="page-title "><?php echo e(trans('labels.topProperty')); ?> </h3>    
    <p><a href="<?php echo e(url('/admin/topProperty/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i><?php echo e(trans('labels.addNew')); ?></a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('labels.delete')); ?></a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.propertyList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
            
            
        </div>

        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabpropertyidproper">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th><?php echo e(trans('labels.id')); ?></th>                     
                        <th><?php echo e(trans('labels.property')); ?></th>                     
                        <th><?php echo e(trans('labels.days')); ?></th>                     
                        <th><?php echo e(trans('labels.action')); ?></th>
                    </tr>
                </thead>       

            </table>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $('#usertype').on('click',function() {
      var usertype = $('#usertype').val();
        if (usertype == 1) {
            $('#usershide').css('display','block');
            $('#ShowRoomAdminhide').css('display','none');
        } else if (usertype == 2) {
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
        }
    });


</script>


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