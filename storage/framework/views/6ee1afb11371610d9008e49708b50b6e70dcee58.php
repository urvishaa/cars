<?php $__env->startSection('content'); ?>


<script>
function filterGlobal () { 
    
    oTable = $('#tabcaridproper').DataTable()
        // alert(oTable.columns(0).search($('#usertype').val().trim()));
        // alert(oTable.columns(1).search($('#userId').val().trim()));
        oTable.columns(0).search($('#usertype').val().trim());  
        oTable.columns(1).search($('#userId').val().trim());  
        oTable.columns(2).search($('#showRoomId').val().trim());  
        oTable.columns(3).search($('#companyId').val().trim());  
        oTable.draw();  
    

}
    $(document).ready(function () {
        $('#tabcaridproper').DataTable({
            "processing": true,
            "serverSide": true,
            
            "ajax":{
                     "url": "<?php echo e(url('admin/car/allposts')); ?>",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "<?php echo e(csrf_token()); ?>"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "car_img","bSortable": false  },
                { "data": "car_name" },
                { "data": "pro_type" },
                { "data": "sale_price" },
                { "data": "userType" },
                { "data": "users" ,"bSortable": false },
                { "data": "published" },
                { "data": "options" }
            ]    

        });
        $('#usertype').on( 'change', function () { 
            
             filterGlobal();
        })
        $('#userId').on( 'change', function () { 
            // alert($('#userId').val());
             filterGlobal();
        })
        $('#showRoomId').on( 'change', function () { 
             filterGlobal();
        })
        $('#companyId').on( 'change', function () { 
             filterGlobal();
        })
    });

    <?php $admin = auth()->guard('admin')->user(); ?>

</script>
    <div class="box-header-main">
    <h3 class="page-title "><?php echo e(trans('labels.Car')); ?> </h3>    
    <p><a href="<?php echo e(url('/admin/car/create')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i><?php echo e(trans('labels.addNew')); ?></a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('labels.delete')); ?></a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           <?php echo e(trans('labels.carList')); ?>

        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
            
            <?php if ($admin['issubadmin'] != 2 && $admin['issubadmin'] != 4 && $admin['issubadmin'] != 3) { ?>
                <div class="input-group">
                    <select name="usertype" id="usertype">  
                        <option value=""><?php echo e(trans('labels.selectUserType')); ?></option>              
                        <option value="1"><?php echo e(trans('labels.users')); ?></option>              
                        <option value="2"><?php echo e(trans('labels.showRoomAdmin')); ?></option>              
                        <option value="3"><?php echo e(trans('labels.rentalCompanies')); ?></option>              
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

                    <div id="companyhide" class="usershow" style="display: none">
                        <select name="companyId" id="companyId" class="field">
                             <option value=""><?php echo e(trans('labels.selectCompany')); ?></option>
                                <?php $__empty_1 = true; $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                      <option value="<?php echo e($companies->myid); ?>"><?php echo e($companies->first_name); ?> <?php echo e($companies->last_name); ?></option>                          
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>    
                                <?php endif; ?>                                  
                        </select>
                    </div>

                <a href="<?php echo e(url('/admin/car')); ?>" id="cancel" name="cancel" class="btn btn-default">Clear</a>
            </div>
            <?php } ?>
            
        </div>

        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabcaridproper">
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
            $('#companyhide').css('display','none');
        } else if (usertype == 2) {
            $('#ShowRoomAdminhide').css('display','block');
            $('#usershide').css('display','none');
            $('#companyhide').css('display','none');
        } else if (usertype == 3) {
            $('#ShowRoomAdminhide').css('display','none');
            $('#usershide').css('display','none');
            $('#companyhide').css('display','block');
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
            var res=confirm('Are you Sure you want to delete Car?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'<?php echo e(url("admin/car/Carmultidelete")); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one Car'); }
    });
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>