@extends('layouts.app')
@section('content')


<style>
#map {
  height: 50%;
}
#description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}
#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}
</style>

<h3 class="page-title">{{ trans('labels.createTopCar') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/topCar') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                       <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            {{-- <a href="{{ url('admin/topCar/create') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a> --}}
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    
                    <div class="centerdiv">
                        <div class="subcenter">      
                          <div class="form-group">
                            <label for="mainCarId">{{ trans('labels.Car') }} <span class="clsred">*</span></label>
                            <select class="field select2" name="mainCarId[]" autofocus required id="mainCarId" multiple="multiple" data-placeholder="{{ trans('labels.selectCategoryType') }}">
                                @forelse($car as $pro_cat) 
                                    @if(isset($Topcar) !='')
                                      <option value="{{ $pro_cat->id }}"  @if(in_array($pro_cat->id, $Topcar)) {{ 'selected' }} @endif >{{ $pro_cat->car_name }}</option>
                                    @else
                                      <option value="{{ $pro_cat->id }}">{{ $pro_cat->car_name }}</option>
                                    @endif
                                @empty    
                                @endforelse  
                            </select>
                          </div>

                          <div class="form-group">
                            <label></label>
                            <input type="button" onclick="add_new_img(jQuery('#mainCarId').val())" value="{{ trans('labels.add') }}">
                          </div>
                          <div id="add_textBox" ></div>


                          <script type="text/javascript">

                              function add_new_img(proppertyId)
                              {  
                                  $.ajax({
                                      type: "POST",
                                      url: "{{ url('admin/topCar/getCarId') }}",
                                      data: {proppertyId:proppertyId},
                                      
                                      success: function(result){
                                          
                                          $('#add_textBox').html(result)
                                      }
                                  });
                              }
                          </script>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  {{-- <a href="{{ url('admin/topCar/create') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a> --}}
                                </div>
                          </div>
                        </div>
                      </div>
                </form>
                            
            </div> 
        </div>


<script type="text/javascript">
    
    $( document ).ready(function() {

      @if(isset($Topcar) != "") 
        add_new_img(jQuery('#mainCarId').val());  
      @endif

      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
    

</script> 



@endsection


