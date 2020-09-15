@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.newYear') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/year/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/year') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter"> 

                          <div class="form-group">
                            <label for="car_brand">{{ trans('labels.carBrand') }} <span class="clsred">*</span></label>
                            <select class="field select2" name="car_brand_id" autofocus id="car_brand" data-placeholder="{{ trans('labels.selectCarBrand') }}" onchange="filterCategory(this.value)">
                                      <option value="">{{ trans('labels.selectCarBrand') }}</option>
                                @forelse($carBrand as $brand) 
                                      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @empty    
                                @endforelse  
                            </select>
                          </div>


                          <div class="form-group">
                            <label for="prop_category">{{ trans('labels.propertyCategory') }} <span class="clsred">*</span></label>
                            <select class="field select2" name="car_model_id" autofocus  data-placeholder="{{ trans('labels.selectCategoryType') }}" id="filterCategorys">
                                      <option value="">{{ trans('labels.selectCategoryType') }}</option>
                            </select>
                          </div>


                          <div class="form-group">
                              <label for="name">{{ trans('labels.year') }} <span class="clsred">*</span></label>
                              <input type="number" name="year" class="form-control" required autofocus>
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


