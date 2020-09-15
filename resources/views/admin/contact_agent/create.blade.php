@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.newProduct') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/car_accessories') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/car_accessories') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter"> 

                          <?php $admin = auth()->guard('admin')->user(); ?>
                          
                          <div class="form-group" >
                              <label for="store">{{ trans('labels.store') }} <span class="clsred">*</span></label>
                                <select name="store_id" id="store" class="field" onchange="getval(this);" required autofocus>
                                  <option value="">{{ trans('labels.SelectStore') }}</option>
                                    @forelse($result['storeAdmin'] as $store) 
                                          <option value="{{ $store->myid }}">{{ $store->first_name }} {{ $store->last_name }}</option>
                                    @empty    
                                    @endforelse  
                                </select>
                          </div>

                          <div class="form-group" >
                              <label for="category">{{ trans('labels.category') }} <span class="clsred">*</span></label>
                                <select name="category_id" id="category" class="field" required autofocus>
                                  <option value="">{{ trans('labels.SelectCategory') }}</option>
                                </select>
                          </div>

                          <div class="form-group">
                              <label for="name">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="price">{{ trans('labels.price') }} <span class="clsred">*</span></label>
                              <input type="text" name="price" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="specification">{{ trans('labels.specification') }} <span class="clsred">*</span></label>
                              <textarea name="specification" class="form-control" required autofocus></textarea>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }} <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus></textarea>
                          </div>

                          <h4><strong>{{ trans('labels.attribute') }}</strong></h4>

                          <div class="form-group">
                              <label for="size">{{ trans('labels.size') }} <span class="clsred">*</span></label>
                              <input type="text" name="size" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="model">{{ trans('labels.model') }} <span class="clsred">*</span></label>
                              <input type="text" name="model" value="" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="color">{{ trans('labels.color') }} <span class="clsred">*</span></label>
                              <input type="text" name="color" value="" class="form-control" required autofocus>
                          </div>
                            
                          
                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" @if(isset($result['edittemplate']->status)) {{ old('status',$result['edittemplate']->status)=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($result['edittemplate']->status)) {{ old('status',$result['edittemplate']->status)=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>


                          <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <?php if (isset($result['edittemplate']->image)) { ?>
                              {{-- <input type="file" name="image[]" id="image" value=""> --}}
                                <input type="hidden" class="form-control" name="oldimage" id="oldimage" value="@if(isset($result['edittemplate']->image)){{ $result['edittemplate']->image }} @endif">
                                  <img src="@if(isset($result['edittemplate']->image)){{ url('/public/templateImage/'.$result['edittemplate']->image) }} @endif" class="btn popup_image" height="100px" width="100px"/>  
                              <?php } else { ?>
                                <input type="file" name="image[]" id="image" required="" value="" accept="image/x-png,image/jpeg">
                              <?php } ?>
                              <input type="button" onclick="add_new_img()" value="{{ trans('labels.addNewImage') }}">
                              
                              <div id="add_img"></div>
                          </div>


                      <script type="text/javascript">
                          function add_new_img()
                          {
                              jQuery('#add_img').append('<div class="form-group"><input type="file" name="image[]" id="image" accept="image/x-png,image/jpeg"></div>');
                          }
                      </script>

                          <div class="form-group">
                                <label class="col-md-4 control-label" for="submit"></label>
                                <div class="col-md-8">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                  <a href="{{ url('admin/car_accessories') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                                </div>
                          </div>
                        </div>
                    </div>
                </form>
                            
            </div> 
        </div>
    

<script type="text/javascript">
  
  function getval(store_val)
  { 
    var store_id = store_val.value;
    
    $.ajax({
        type: "POST",
        url: "{{ url('admin/car_accessories/getCategory') }}",
        data: {store_id:store_id},
        
        success: function(result){
          //alert(result); return false;
          $('#category').html(result);
            //location.reload();
        }
    });
  }

</script>
<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    }); 
</script> 

@endsection


