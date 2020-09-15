
@extends('layouts.app')

@section('content')


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
                     "url": "{{ url('admin/car/allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
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
    <h3 class="page-title ">{{ trans('labels.Car') }} </h3>    
    <p><a href="{{ url('/admin/car/create') }}" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>{{ trans('labels.addNew') }}</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('labels.delete') }}</a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.carList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
            
            <?php if ($admin['issubadmin'] != 2 && $admin['issubadmin'] != 4 && $admin['issubadmin'] != 3) { ?>
                <div class="input-group">
                    <select name="usertype" id="usertype">  
                        <option value="">{{ trans('labels.selectUserType') }}</option>              
                        <option value="1">{{ trans('labels.users') }}</option>              
                        <option value="2">{{ trans('labels.showRoomAdmin') }}</option>              
                        <option value="3">{{ trans('labels.company') }}</option>              
                    </select> 
                
                    <div id="usershide" class="usershow" style="display: none">
                        <select name="userId" id="userId" class="field" >
                             <option value="">{{ trans('labels.selectUser') }}</option>
                                @forelse($users as $user) 
                                      <option value="{{ $user->id }}">{{ $user->username }}</option>                          
                                @empty    
                                @endforelse                                  
                        </select>
                    </div>

                    <div id="ShowRoomAdminhide" class="usershow" style="display: none">
                        <select name="showRoomId" id="showRoomId" class="field">
                             <option value="">{{ trans('labels.selectShowRoomAdmin') }}</option>
                                @forelse($ShowRoomAdmin as $ShowRoom) 
                                      <option value="{{ $ShowRoom->myid }}">{{ $ShowRoom->first_name }} {{ $ShowRoom->last_name }}</option>                          
                                @empty    
                                @endforelse                                  
                        </select>
                    </div>

                    <div id="companyhide" class="usershow" style="display: none">
                        <select name="companyId" id="companyId" class="field">
                             <option value="">{{ trans('labels.selectCompany') }}</option>
                                @forelse($company as $companies) 
                                      <option value="{{ $companies->myid }}">{{ $companies->first_name }} {{ $companies->last_name }}</option>                          
                                @empty    
                                @endforelse                                  
                        </select>
                    </div>

                <a href="{{ url('/admin/car') }}" id="cancel" name="cancel" class="btn btn-default">Clear</a>
            </div>
            <?php } ?>
            
        </div>

        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabcaridproper">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th>{{ trans('labels.id') }}</th>                     
                        <th>{{ trans('labels.image') }}</th>
                        <th>{{ trans('labels.name') }}</th>
                        <th>{{ trans('labels.type') }}</th>
                        <th>{{ trans('labels.price') }}</th>
                        <th>{{ trans('labels.userType') }}</th>
                        <th>{{ trans('labels.users') }}</th>
                        <th>{{ trans('labels.published') }}</th>
                        <th>{{ trans('labels.action') }}</th>
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
                    url:'{{ url("admin/car/Carmultidelete") }}',
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
@endsection