@extends('layouts.app')

@section('content')
    
<script>
/*function filterGlobal () {
    $('#tabuserid').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}*/
    $(document).ready(function () { 
        // var urls = "{{ route('admin.orderlist.allposts') }}";

        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ route('admin.orderlist.allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
                   },
            "columns": [
                { "data": "order_id" },
                { "data": "name" },
                 { "data": "status" },
                  { "data": "total" },
                  { "data": "date" },
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
           {{ trans('labels.orderList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                    <thead>
                        <tr>          
                            <th>{{ trans('labels.orderid') }}</th>                     
                            <th>{{ trans('labels.name') }}</th>
                            <th>{{ trans('labels.status') }}</th>
                            <th>{{ trans('labels.total') }}</th>
                            <th>{{ trans('labels.date') }}</th>
                            <th>{{ trans('labels.action') }}</th>
                        </tr>

                    </thead>
                       
                </table>
            </div>
        </div>
    </div>
@endsection