@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.newcity') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/city/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/city') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                           <div class="form-group">
                              <label for="name">{{ trans('labels.Arabic') }} <span class="clsred">*</span></label>
                              <input type="text" name="ar" value="" class="form-control" required autofocus>
                          </div>

                           <div class="form-group">
                              <label for="name">{{ trans('labels.Kurdish') }} <span class="clsred">*</span></label>
                              <input type="text" name="ku" value="" class="form-control" required autofocus>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/city') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
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

