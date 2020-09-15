@extends('layouts.app')

@section('content')

<script>

    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/year/allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "year" },
                { "data": "options" }
            ]    

        });
        
    });
</script>
<?php //exit; ?>
    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.year') }}</h3>    
    <p><a href="{{ url('/admin/year/create') }}" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>{{ trans('labels.addNew') }}</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('labels.delete') }}</a> </p></div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.yearList') }}
        </div>
        <div class="panel-body table-responsive progrmslistcls">  
        <div class="srchprocls">

        </div>
        <div class="prolisttabcls">
                <table class="table table-bordered" id="tabuseridpos">
                <thead>
                    <tr>                        
                        <th style="text-align:center;"><input type="checkbox" id="selectAll" /></th>  
                        <th>{{ trans('labels.id') }}</th>                     
                        <th>{{ trans('labels.year') }}</th>
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
            var res=confirm('Are you Sure you want to delete User?');
            if(res=="flase")
            {   return false;  }
                $.ajax({
                    type:'POST',
                    url:'{{url("/admin/year/yearalldelete") }}',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                        
                        //window.location = data.url;
                   }    
                });            
        }
        else   {  alert('Select atleast one year'); }
    });
});

</script>
@endsection