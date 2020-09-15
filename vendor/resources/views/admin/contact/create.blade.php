@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.contact') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ route('contact.save') }}" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="{{ $contact->id ? $contact->id : '' }}">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ route('contact.create') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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
                                <input type="text" name="title" value="{{ $contact->title ? $contact->title : '' }}" class="form-control prop-admin" required autofocus></div>
                          </div>

                           <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.description') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="description" class="form-control " id="editor">{{ $contact->description ? $contact->description : '' }}</textarea>
                              </div>
                          </div>


                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="address">{{ trans('labels.address') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="address" value="{{ $contact->address ? $contact->address : '' }}" class="form-control prop-admin" required autofocus></div>
                          </div>

                         <div class="form-group row">
                              <div class="col-md-2">
                                <label for="phone">{{ trans('labels.phone') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="phone" value="{{ $contact->phone ? $contact->phone : ''  }}" class="form-control prop-admin" required autofocus></div>
                          </div>

                          

                          <div class="form-group row">
                              <div class="col-md-2">
                                <label for="email">{{ trans('labels.email') }} <span class="clsred">*</span></label>
                              </div>
                              <div class="col-md-10">
                                <input type="email" name="email" value="{{ $contact->email ? $contact->email : '' }}" class="form-control prop-admin" required autofocus></div>
                          </div>
                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('contact.create') }}" id="cancel" name="cancel" class="btn btn-default" required>{{ trans('labels.cancel') }}</a>
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

@endsection


