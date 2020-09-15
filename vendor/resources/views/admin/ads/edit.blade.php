@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('labels.editAds') }} </h3>  

        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/ads/update_ads/'.$ads->id) }}" method="POST" enctype="multipart/form-data" >
                <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/ads') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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
                              <label for="name">{{ trans('labels.adsType') }}<span class="clsred">*</span></label>
                              <select class="form-control" name="type">
                                <option value="1"  @if(isset($ads->type)) {{ old('type',$ads->type)=="1"? 'selected':''}} @endif>{{ trans('labels.fixAds') }}</option>
                                <option value="2" @if(isset($ads->type)) {{ old('type',$ads->type)=="2"? 'selected':''}} @endif>{{ trans('labels.randomAds') }}</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="fename">{{ trans('labels.title') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="{{ $ads->name }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }}<span class="clsred">*</span></label>
                              <textarea name="description" id="description" class="form-control" required autofocus>{{ $ads->description }}</textarea>
                          </div>

                          <div class="form-group">
                                <label for="dob">{{ trans('labels.banner') }}</label>                      
                                <input class="col-md-3" name="image"  value="" type="file">  

                                @if($ads->image != "")
                                    <div class="col-md-2"><img src="@if(isset($ads->image)){{ url('/public/dsaImage/'.$ads->image ) }} @endif" class="btn popup_image" height="100px" width="100px"/></div>
                                @else
                                    <div class="col-md-2"><img src="{{ url('/public/default-image.jpeg' ) }}" class="btn popup_image" height="100px" width="100px"/></div>
                                @endif
                                <input type="hidden" name="oldimage" value="{{ $ads->image }}">
                            </div>

                            <?php //echo "<prE>"; print_r($ads); die; ?>

                          <div class="form-group">
                              <label for="image">{{ trans('labels.fromDate') }}</label>                      
                              <input class="form-control" name="fromdate"  value="{{ $ads->fromdate }}" type="date">  
                          </div>
                          
                          <div class="form-group">
                              <label for="image">{{ trans('labels.toDate') }}</label>                      
                              <input class="form-control" name="todate"  value="{{ $ads->todate }}" type="date">  
                          </div>
                          
                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" @if(isset($ads->published)) {{ old('published',$ads->published)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($ads->published)) {{ old('published',$ads->published)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>
                                          
                          
                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/ads') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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

