@extends('layouts.app')

@section('content')


<h3 class="page-title">{{ trans('labels.editCarBrand') }}</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/carBrand/update/'.$carBrand->id) }}" method="POST" >
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/carBrand') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{-- {{ method_field('PUT') }} --}}
                    {!! csrf_field() !!}

                    {{-- <div class="form-group">
                        <label for="prolevid">User Type <span class="clsred">*</span></label>  
                        <select required autofocus id="u_type" name="u_type" class="field">
                            <option value="">--Select User Group--</option>
                                    @forelse($usergroups as $pro) 
                                          <option value="{{ $pro->id }}" {{ $user->u_type ==  $pro->id ? 'selected="selected"' : '' }}>{{ $pro->typeName }}</option>                          
                                    @empty    
                                    @endforelse  
                        </select>            
                    </div>    --}}

                    <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="{{ $carBrand->name }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ar">{{ trans('labels.Ar') }} <span class="clsred">*</span></label>
                              <input type="text" name="ar" value="{{ $carBrand->ar }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ku">{{ trans('labels.Ku') }} <span class="clsred">*</span></label>
                              <input type="text" name="ku" value="{{ $carBrand->ku }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }} <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus>{{ $carBrand->description }}</textarea>
                          </div>
                          
                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" @if(isset($carBrand->status)) {{ old('status',$carBrand->status)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($carBrand->status)) {{ old('status',$carBrand->status)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>
                                          
                          <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                    <a href="{{ url('admin/carBrand') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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

