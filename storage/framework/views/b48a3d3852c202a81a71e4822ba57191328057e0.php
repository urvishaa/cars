<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
  
      <div class="box-header-main"><h3 class="page-title">Users Group List </h3>    
    <p><a href="<?php echo e(url('admin/user_group')); ?>" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>Add New</a>
    <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> Delete</a> </p></div>
      
      <div class="panel panel-default">
        <div class="panel-heading">
           Users Group List
        </div>
          <!-- /.box-header -->
          <div class="panel-body table-responsive progrmslistcls">  
          <div class="prolisttabcls">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                <th><?php echo e(trans('labels.index')); ?></th>
                <th><?php echo e(trans('labels.TYPE')); ?></th>
                <th><?php echo e(trans('labels.parent')); ?></th>
                <th><?php echo e(trans('labels.action')); ?></th>
              </tr>
              </thead>
              <tbody>
                <?php 
                  $i=1;
                 ?>
                          
                <?php $__currentLoopData = $usergroupList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$usergroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                     <?php 
                    $usergroupList123 = DB::table('usergroups')->where('id', $usergroup->parentGroup)->get(); 
                     if(!empty($usergroupList123[0]))
                     {
                        $hello=  $usergroupList123[0]->typeName;
                     }
                     else
                     {
                        $hello ="-";
                     }
                    ?>
                <tr>
                    <?php if ($usergroup->id > 3) { ?>
                      <td style="text-align:center;"><input type="checkbox" name="case" id="selectvalue" value="<?php echo e($usergroup->id); ?>" /></td>
                    <?php } else { ?>
                      <td></td>
                    <?php } ?>
                    <td><?php echo e($i++); ?></td>
                    <td><?php echo e($usergroup->typeName); ?></td>
                    <td><?php echo e($hello); ?></td>
                    <td>
                      <a class="btn btn-primary" href="<?php echo e(url('admin/editUserGroup',$usergroup->id)); ?>">Edit</a>
                      <?php if ($usergroup->id > 3) { ?>
                          <a class="btn btn-danger" href="<?php echo e(url('admin/deleteUserGroup',$usergroup->id)); ?>">Delete</a>
                      <?php } ?>
                      
                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
          </div>
              <!-- /.box-body -->
      </div>

    <!-- /.content --> 
  
<?php $__env->stopSection(); ?> 
 

<script type = "text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
 <script type = "text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>



<script type="text/javascript">

 $(function () { 
    $('#example1').DataTable({
      /*'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]*/
    })
  })
</script>

<script type="text/javascript">
$( document ).ready(function() {
$('#selectAll').click(function (e) { 
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});


    $('.deletesellected').click(function(){ 
        var checkValues = $('input[name=case]:checked').map(function()
        {
          return $(this).val(); }).get();

        if(checkValues !='')
        { 
            var res=confirm('Are you Sure you want to delete User?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'post',
                    url:'<?php echo e(url('/admin/usergroup/usergroupmultidelete')); ?>',
                    data:'ids='+checkValues,
                    success:function(data){
                      location.reload();
                      //alert(data); return false;
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one User'); }
    });
});
</script>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>