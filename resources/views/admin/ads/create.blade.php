@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('labels.newAds') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/ads') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/ads') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                      <div class="centerdiv">
                        <div class="subcenter"> 

                          <div class="form-group">
                              <label for="name">{{ trans('labels.adsType') }}<span class="clsred">*</span></label>
                              <select class="form-control" name="type">
                                <option value="1">{{ trans('labels.fixAds') }}</option>
                                <option value="2">{{ trans('labels.randomAds') }}</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="name">{{ trans('labels.title') }}<span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }}<span class="clsred">*</span></label>
                              <textarea name="description" id="description" class="form-control" required autofocus></textarea>
                          </div>

                          <div class="form-group">
                              <label for="image">{{ trans('labels.banner') }}</label>                      
                              <input class="" name="image"  value="" type="file">  
                          </div>

                          <div class="form-group">
                              <label for="image">{{ trans('labels.fromDate') }}</label>                      
                              <input class="form-control" name="fromdate"  value="" type="date" required autofocus>  
                          </div>
                          
                          <div class="form-group">
                              <label for="image">{{ trans('labels.toDate') }}</label>                      
                              <input class="form-control" name="todate"  value="" type="date" required autofocus>  
                          </div>


                          <div class="form-group">
                              <label for="published">{{ trans('labels.published') }}<span class="clsred">*</span></label>
                              <select class="form-control" name="published" id="published">
                                <option value="1" @if(isset($result['edittemplate']->published)) {{ old('published',$result['edittemplate']->published)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($result['edittemplate']->published)) {{ old('published',$result['edittemplate']->published)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
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


