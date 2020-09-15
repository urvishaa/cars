@extends('layouts.app')

@section('content')

<script>

    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/contactAgent/allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
                   },
            "columns": [
                { "data": "id" },
                { "data": "agentName" },
                { "data": "type" },
                { "data": "name" },
                { "data": "nationality" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "dateFrom" },
                { "data": "dateTo" }
                
            ]    

        });
    });
</script>

    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.contactAgent') }}</h3>    
    </div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.ProductList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
       
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>                        
                        <th>{{ trans('labels.id') }}</th>                     
                        <th>{{ trans('labels.agentName') }}</th>
                        <th>{{ trans('labels.type') }}</th>
                        <th>{{ trans('labels.name') }}</th>
                        <th>{{ trans('labels.nationality') }}</th>
                        <th>{{ trans('labels.email') }}</th>
                        <th>{{ trans('labels.phone') }}</th>
                        <th>{{ trans('labels.dateFrom') }}</th>
                        <th>{{ trans('labels.dateTo') }}</th>
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
                    type:'POST',
                    url:'{{url("/admin/car_accessories/alldelete") }}',
                    data:'ids='+checkValues,
                    success:function(data){
                        //alert(data); return false;
                        location.reload();
                        
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one User'); }
    });
});

</script>
@endsection