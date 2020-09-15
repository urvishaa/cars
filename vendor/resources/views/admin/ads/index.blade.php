@extends('layouts.app')

@section('content')

<script>
function filterGlobal () {
    $('#tabuserid').DataTable().column(0).search(
        $('#category').val()
      
    ).draw();
}
    $(document).ready(function () { 
        $('#tabuseridpos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('admin/ads/allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"},
                     
                   },
            "columns": [
                { "data": "checkdata","bSortable": false , "className": "text-center" },
                { "data": "id" },
                { "data": "name" },
                { "data": "published" },
                { "data": "options" }
            ]    

        });
        $('#category').on( 'change', function () {
             filterGlobal();
        })
    });
</script>

    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.ads') }}</h3>    
    <p><a href="{{ url('/admin/ads/create') }}" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"> </i>{{ trans('labels.addNew') }}</a>
     <a class="btn btn-danger deletesellected" > <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('labels.delete') }}</a> </p></div>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
           {{ trans('labels.adsList') }}
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
                        <th>{{ trans('labels.title') }}</th>
                        <th>{{ trans('labels.published') }}</th>
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
                    url:'{{ url("/admin/ads/alldelete") }}',
                    data:'ids='+checkValues,
                    success:function(data){
                        location.reload();
                   }    
                });            
        }
        else   {  alert('Select atleast one category'); }
    });
});

</script>
@endsection