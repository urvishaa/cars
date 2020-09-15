@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.homeslide') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/homeslide/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/homeslide') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name">{{ trans('labels.title') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="title" value="" class="form-control prop-admin" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.description') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor"></textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name">{{ trans('labels.titlearabic') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="titlearabic" value="" class="form-control prop-admin" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.descriptionarabic') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="descriptionarabic" class="form-control " id="editor1"></textarea>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name">{{ trans('labels.titlekurdish') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="titlekurdish" value="" class="form-control prop-admin" required autofocus></div>
                          </div>

                          <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.descriptionkurdish') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="descriptionkurdish" class="form-control " id="editor2"></textarea>
                              </div>
                          </div>

                           <div class="form-group row">
                              <div class="col-md-2">
                                <label for="name">{{ trans('labels.image') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                
                                  <input type="file" name="image" required="" autofocus="">
                                 
                                </div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/homeslide') }}" id="cancel" name="cancel" class="btn btn-default" required>{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>

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
<script>
  ClassicEditor
          .create( document.querySelector( '#editor1' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>
<script>
  ClassicEditor
          .create( document.querySelector( '#editor2' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>

@endsection


