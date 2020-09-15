@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.importFile') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <div class="panel-heading">
                    
                
                <form action="{{route('carModel.import.save')}}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.import') }}</button>
                            <a href="{{ url('admin/category') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter"> 
                            <div class="form-group">
                                <label for="Sample File">{{ trans('labels.sampleFile') }} <span class="clsred">*</span></label>
                                <a href="{{route('carModel.sample.download')}}" class="btn btn-primary">{{ trans('labels.download') }}</a>

                            </div>
                            <div class="form-group">
                                <label for="prolevid">{{trans('labels.carBrand')}} <span class="clsred">*</span></label>  
                                <select required autofocus name="car_brand_id" class="field">
                                    <option value="">{{trans('labels.selectCarBrand')}}</option>
                                            @foreach($carBrands as $carBrand) 
                                                <option value="{{ $carBrand->id }}">{{ $carBrand->name }}</option>                          
                                            @endforeach  
                                </select>            
                            </div> 
                            <div class="form-group">
                                <label for="name">{{ trans('labels.selectFile') }} <span class="clsred">*</span></label>
                                <input type="file" name="car_model_csv" required>
                            </div>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.import') }}</button>
                                  <a href="{{ url('admin/category') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    


@endsection


