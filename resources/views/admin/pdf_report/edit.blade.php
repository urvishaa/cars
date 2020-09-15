
@extends('layouts.app')

@section('content')


<h3 class="page-title">{{ trans('labels.editPdfFile') }}</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">

                <form action="{{ url('admin/pdf_report/update_pdfFile/'.$Pdf_report->id) }}" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    <h3 style="text-align: center;">{{ trans('labels.editPdfFile') }}</h3>
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/pdf_report') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{-- {{ method_field('PUT') }} --}}
                    {!! csrf_field() !!}

                 
                    <div class="form-group">
                        <label for="pro_name">{{ trans('labels.propertyName') }} <span class="clsred">*</span></label>
                            <select name="pro_name" id="pro_name" class="field"  autofocus required>
                                 <option value="">{{ trans('labels.selectPropertyName') }}</option>
                                    @forelse($Property as $pro_name) 
                                          <option value="{{ $pro_name->id }}" {{ $Pdf_report->pro_name ==  $pro_name->id ? 'selected="selected"' : '' }} >{{ $pro_name->property_name }}</option>                          
                                    @empty    
                                    @endforelse  
                                
                            </select>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('labels.pdfUpload') }}</label>
                        <div class="form-group">
                        <?php if (isset($Pdf_report->pdf_upload)) { ?>
                          <input type="file" name="pdf_upload" id="pdf_upload" class="form-control" value="">
                          <input type="hidden" class="form-control" name="oldpdf_upload" id="oldpdf_upload" value="@if(isset($Pdf_report->pdf_upload)){{ $Pdf_report->pdf_upload }} @endif">
                        <?php } ?>
                        </div>
                    </div>
                                    
                    
                   <div class="form-group">
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/pdf_report') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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

