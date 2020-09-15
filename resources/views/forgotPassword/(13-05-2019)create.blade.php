@extends('layouts.app')

@section('content')

<h3 class="page-title">Change Password</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('/ForgotPassword/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">Change Password</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
    
                        <input type="hidden"  name="oldemail" value="{{ $user_email->email }}" class="form-control">
                        <input type="hidden"  name="userId" value="{{ $user_email->id }}" class="form-control">
                    
                    <div class="form-group">
                        <label for="name">New Password <span class="clsred">*</span></label>
                        <input type="password" name="new_password" value="" class="form-control" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Confirm Password <span class="clsred">*</span></label>
                        <input type="password" name="con_password" value="" class="form-control" required autofocus>
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


