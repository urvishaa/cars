
@extends('layouts.app')

@section('content')


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
                     "url": "{{ url('admin/topCar/allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
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
    <h3 class="page-title ">{{ trans('labels.topCar') }} </h3>    
    <p><a href="{{ url('/admin/topCar/create') }}" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>{{ trans('labels.addNew') }}</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('labels.delete') }}</a> </p>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.carList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">
         
        </div>

        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabpropertyidproper">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th>{{ trans('labels.id') }}</th>                     
                        <th>{{ trans('labels.car') }}</th>                     
                        <th>{{ trans('labels.days') }}</th>                     
                        <th>{{ trans('labels.action') }}</th>
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
            var res=confirm('Are you Sure you want to delete top Car?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'{{ url("admin/car/carmultidelete") }}',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one top car'); }
    });
});

</script>
@endsection