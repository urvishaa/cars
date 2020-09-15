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
                { "data": "pro_type" },
                { "data": "sale_price" },
                { "data": "userType" },
                { "data": "users" },
                { "data": "published" },
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
    <h3 class="page-title "><?php echo e(trans('labels.property')); ?> </h3>    
    <p><a href="<?php echo e(url('/admin/property/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i><?php echo e(trans('labels.addNew')); ?></a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('labels.delete')); ?></a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.propertyList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
            
            <div class="input-group">
                    <select name="usertype" id="usertype">  
                        <option value=""><?php echo e(trans('labels.selectUserType')); ?></option>              
                        <option value="1"><?php echo e(trans('labels.users')); ?></option>              
                        <option value="2"><?php echo e(trans('labels.showRoomAdmin')); ?></option>              
                    </select> 
                
                    <div id="usershide" class="usershow" style="display: none">
                        <select name="userId" id="userId" class="field" >
                             <option value=""><?php echo e(trans('labels.selectUser')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($user->id); ?>"><?php echo e($user->username); ?></option>                          
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>                                  
                        </select>
                    </div>

                    <div id="ShowRoomAdminhide" class="usershow" style="display: none">
                        <select name="showRoomId" id="showRoomId" class="field">
                             <option value=""><?php echo e(trans('labels.selectShowRoomAdmin')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $ShowRoomAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ShowRoom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($ShowRoom->myid); ?>"><?php echo e($ShowRoom->first_name); ?> <?php echo e($ShowRoom->last_name); ?></option>                          
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>                                  
                        </select>
                    </div>

                <a href="<?php echo e(url('/admin/property')); ?>" id="cancel" name="cancel" class="btn btn-default">Clear</a>
            </div>
        </div>

        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabpropertyidproper">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th><?php echo e(trans('labels.id')); ?></th>                     
                        <th><?php echo e(trans('labels.image')); ?></th>
                        <th><?php echo e(trans('labels.name')); ?></th>
                        <th><?php echo e(trans('labels.type')); ?></th>
                        <th><?php echo e(trans('labels.price')); ?></th>
                        <th><?php echo e(trans('labels.userType')); ?></th>
                        <th><?php echo e(trans('labels.users')); ?></th>
                        <th><?php echo e(trans('labels.published')); ?></th>
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