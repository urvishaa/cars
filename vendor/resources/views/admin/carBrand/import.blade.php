@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.importFile') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <div class="panel-heading">
                    
                
                <form action="{{route('carBrand.import.save')}}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.import') }}</button>
                            <a href="{{ url('admin/carBrand') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter"> 
                            <div class="form-group">
                                <label for="Sample File">{{ trans('labels.sampleFile') }} <span class="clsred">*</span></label>
                                <!-- <input type="file" name="car_brand_csv" required> -->
                                <a href="{{route('carBrand.sample.download')}}" class="btn btn-primary">{{ trans('labels.download') }}</a>

                            </div>
                            
                            <div class="form-group">
                                <label for="name">{{ trans('labels.selectFile') }} <span class="clsred">*</span></label>
                                <input type="file" name="car_brand_csv" required>
                            </div>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.import') }}</button>
                                  <a href="{{ url('admin/carBrand') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    


@endsection


