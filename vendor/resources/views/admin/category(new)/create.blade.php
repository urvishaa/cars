@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('labels.newPropertyCategory') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/category/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/category') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                      <div class="centerdiv">
                        <div class="subcenter"> 
                          <div class="form-group">
                              <label for="name">{{ trans('labels.name') }}<span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ar">{{ trans('labels.Ar') }}<span class="clsred">*</span></label>
                              <input type="text" name="ar" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="ku">{{ trans('labels.Ku') }}<span class="clsred">*</span></label>
                              <input type="text" name="ku" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="car_brand_id">{{ trans('labels.carBrand') }}<span class="clsred">*</span></label>
                              <select class="form-control" name="car_brand_id" required>
                                <option value="" >--Selece Car Brand--</option>
                                @foreach($carBrands as $carBrand)
                                <option value="{{$carBrand->id}}" >{{$carBrand->name}}</option>
                                @endforeach
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="year">{{ trans('labels.year') }}</label>
                              <select class="form-control" name="car_year" id="year">
                                <option value="" >--Select Car Year--</option>                                
                                @foreach($carYears as $carYear)
                                    <option value="{{$carYear->year}}" >{{ $carYear->year }}</option>
                                @endforeach
                              </select>
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
                                  <a href="{{ url('admin/category') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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


