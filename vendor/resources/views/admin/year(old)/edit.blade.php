@extends('layouts.app')
@section('content')

<?php //echo '<pre>'; print_r($year); die; ?>
<h3 class="page-title">{{ trans('labels.edit') }}  {{ trans('labels.year') }}</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/year/update_year/'.$year->id) }}" method="POST" >
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/year') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{-- {{ method_field('PUT') }} --}}
                    {!! csrf_field() !!}

                    
                    <div class="centerdiv">
                        <div class="subcenter"> 
                           <div class="form-group">
                            <label for="car_brand">{{ trans('labels.carBrand') }} </label>
                            <select class="field select2" name="car_brand_id" autofocus id="car_brand" data-placeholder="{{ trans('labels.selectCarBrand') }}" onchange="filterCategory(this.value)">
                                      <option value="">{{ trans('labels.selectCarBrand') }}</option>
                                @forelse($carBrand as $brand) 
                                      <option value="{{ $brand->id }}" {{ $year->car_brand_id ==  $brand->id ? 'selected="selected"' : '' }}>{{ $brand->name }}</option>
                                @empty    
                                @endforelse  
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="car_model_id">{{ trans('labels.propertyCategory') }} </label>
                            <select class="field select2" name="car_model_id" autofocus  data-placeholder="{{ trans('labels.selectCategoryType') }}" id="filterCategorys">
                              <option value="">{{ trans('labels.selectCategoryType') }}</option>
                                
                                @forelse($carModels as $carModel)

                                          <option value="{{ $carModel->id }}" @if($carModel->id == $year->car_model_id)  selected  @endif  >{{ $carModel->name }}</option>
                                    @empty    
                                @endforelse  
                            </select>
                          </div>

                          

                          <div class="form-group">
                              <label for="name">{{ trans('labels.year') }} <span class="clsred">*</span></label>
                              <input type="number" name="year" value="{{ $year->year }}" class="form-control" required autofocus>
                          </div>
                        
                                          
                          <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                    <a href="{{ url('admin/year') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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
    function filterCategory(name){
      jQuery("#filterCategorys").empty();
      jQuery.ajax({
        type: "GET",
        url: '{{route("category.filter")}}',
        data: {'id':name},
        success: function(res){
          jQuery("#filterCategorys").html(res);
        }
      });
    }

</script> 

@endsection

