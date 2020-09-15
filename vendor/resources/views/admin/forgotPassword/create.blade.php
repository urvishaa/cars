@extends('layouts.app')

@section('content')

<h3 class="page-title">Change Password</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="/realestate/admin/property_features/save" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Change Password</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="{{ url('admin/property_features') }}" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}

                     {{-- <div class="form-group">
                        <label for="name">User Type <span class="clsred">*</span></label>
                            <select name="u_type" id="u_type" class="field"  autofocus required>
                                 <option value="">--Select User Group--</option>
                                    @forelse($usergroups as $pro) 
                                          <option value="{{ $pro->id }}">{{ $pro->typeName }}</option>                          
                                    @empty    
                                    @endforelse  
                                
                            </select>
                    </div> --}}
                  
                     
                    <div class="form-group">
                        <label for="name">Name <span class="clsred">*</span></label>
                        <input type="text" name="fename" value="" class="form-control" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="published">Published <span class="clsred">*</span></label>
                        <select class="form-control" name="published" id="published">
                          <option value="1" @if(isset($result['edittemplate']->published)) {{ old('published',$result['edittemplate']->published)=="1"? 'selected':''}} @endif>Published</option>
                          <option value="2" @if(isset($result['edittemplate']->published)) {{ old('published',$result['edittemplate']->published)=="2"? 'selected':''}} @endif>Unpublished</option>
                        </select>
                    </div>
                

                    <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="{{ url('admin/property_features') }}" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    

<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
    

</script> 
@endsection


