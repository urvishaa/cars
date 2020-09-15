@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.addPdfReport') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/pdf_report') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <h3 style="text-align: center;">{{ trans('labels.addPdfReport') }}</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/pdf_report') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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
                        <label for="price">{{ trans('labels.propertyName') }}<span class="clsred">*</span></label>
                            <select name="pro_name" id="pro_name" class="field"  autofocus required>
                                 <option value="">{{ trans('labels.selectPropertyName') }}</option>
                                    @forelse($Property as $pro_name) 
                                          <option value="{{ $pro_name->id }}">{{ $pro_name->property_name }}</option>
                                    @empty    
                                    @endforelse  
                                
                            </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">{{ trans('labels.pdfUpload') }} <span class="clsred">*</span></label>
                        <input type="file" name="pdf_upload" value="" class="form-control" required autofocus>
                    </div>
                    
                    
                    <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/property_features') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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


