@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('labels.editProCategory') }} </h3>  

        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/procategory/update_carCategory/'.$car_features->id) }}" method="POST" >
                <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/procategory') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{-- {{ method_field('PUT') }} --}}
                    {!! csrf_field() !!}

                    

                    <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="fename">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="{{ $car_features->name }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ar">{{ trans('labels.Ar') }} <span class="clsred">*</span></label>
                              <input type="text" name="ar" value="{{ $car_features->ar }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ku">{{ trans('labels.Ku') }} <span class="clsred">*</span></label>
                              <input type="text" name="ku" value="{{ $car_features->ku }}" class="form-control" required autofocus>
                          </div>


                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" @if(isset($car_features->published)) {{ old('published',$car_features->published)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($car_features->published)) {{ old('published',$car_features->published)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>
                                          
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/procategory') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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

