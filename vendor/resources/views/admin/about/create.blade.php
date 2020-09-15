@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.about') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/about/save') }}" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="old_image" value="{{ @$about->image }}">
                  <input type="hidden" name="id" value="{{ @$about->id }}">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <!-- <a href="{{ url('admin/dashboard/this_month') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a> -->
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name">{{ trans('labels.image') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                  @if(@$about->id != '')
                                  <input type="file" name="image">
                                    @if(file_exists(base_path().'/public/aboutImage/'.@$about->image)  && @$about->image != '')
                                    <img height="50px" width="50px" src="{{ URL::to('public/aboutImage/'.@$about->image)}}">
                                    @endif

                                @else
                                <input type="file" name="image" required autofocus>
                                @endif
                                </div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.description') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor">{{ @$about->description }}</textarea>
                              </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <!-- <a href="{{ url('admin/dashboard/this_month') }}" id="cancel" name="cancel" class="btn btn-default" required>{{ trans('labels.cancel') }}</a> -->
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
</script> 

<script>
  ClassicEditor
          .create( document.querySelector( '#editor' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>

@endsection


