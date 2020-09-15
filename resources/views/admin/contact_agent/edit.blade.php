@extends('layouts.app')

@section('content')

<h3 class="page-title">{{ trans('labels.editProduct') }}</h3>  


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/car_accessories/update/'.$product['id']) }}" method="POST" enctype="multipart/form-data">
                <div class="panel-heading">
                    
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <a href="{{ url('admin/car_accessories') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                          </div>
                        </div>
                    </div>
                        {{-- {{ method_field('PUT') }} --}}
                    {!! csrf_field() !!}

                    <div class="centerdiv">
                        <div class="subcenter"> 
                          
                          <div class="form-group" >
                              <label for="store">{{ trans('labels.store') }} <span class="clsred">*</span></label>
                                <select name="store_id" id="store" class="field" onchange="getval(this.value);" required autofocus>
                                  <option value="">{{ trans('labels.SelectStore') }}</option>
                                    @foreach($result['storeAdmin'] as $store) 

                                        <option value="{{ $store->myid }}" 
                                            @if($store->myid == $product['store_id']) 
                                            {{ 'selected="selected"' }} @else {{ "" }} @endif>{{ $store->first_name }} {{ $store->last_name }}</option>
                                    @endforeach
                                </select>
                          </div>
        
                          
                          <div class="form-group" >
                              <label for="category">{{ trans('labels.category') }} <span class="clsred">*</span></label>
                                <select name="category_id" id="category" class="field" required autofocus>
                                  <option value="">{{ trans('labels.SelectCategory') }}</option>
                                  @foreach($result['pro_category'] as $cate) 
                                          <option value="{{ $cate['id'] }}" 
                                          @if($cate['id'] == $product['category_id']) 
                                          {{ 'selected="selected"' }} @else {{ "" }} @endif>{{ $cate['name'] }}</option>
                                    
                                    @endforeach
                                </select>
                          </div>


                          <div class="form-group">
                              <label for="name">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                              <input type="text" name="name" value="{{ $product['name'] }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="price">{{ trans('labels.price') }} <span class="clsred">*</span></label>
                              <input type="text" name="price" value="{{ $product['price'] }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="specification">{{ trans('labels.specification') }} <span class="clsred">*</span></label>
                              <textarea name="specification" class="form-control" required autofocus>{{ $product['specification'] }}</textarea>
                          </div>

                          <div class="form-group">
                              <label for="description">{{ trans('labels.description') }} <span class="clsred">*</span></label>
                              <textarea name="description" class="form-control" required autofocus>{{ $product['description'] }}</textarea>
                          </div>

                          <h4><strong>{{ trans('labels.attribute') }}</strong></h4>

                          <div class="form-group">
                              <label for="size">{{ trans('labels.size') }} <span class="clsred">*</span></label>
                              <input type="text" name="size" value="{{ $product['size'] }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="model">{{ trans('labels.model') }} <span class="clsred">*</span></label>
                              <input type="text" name="model" value="{{ $product['model'] }}" class="form-control" required autofocus>
                          </div>

                          <div class="form-group">
                              <label for="color">{{ trans('labels.color') }} <span class="clsred">*</span></label>
                              <input type="text" name="color" value="{{ $product['color'] }}" class="form-control" required autofocus>
                          </div>
                          
                          <div class="form-group">
                              <label for="name">{{ trans('labels.published') }} <span class="clsred">*</span></label>
                              <select class="form-control" name="status" id="status">
                                <option value="1" @if(isset($product['status'])) {{ old('status',$product['status'])=="1"? 'selected':''}} @endif>{{ trans('labels.published') }}</option>
                                <option value="2" @if(isset($product['status'])) {{ old('status',$product['status'])=="2"? 'selected':''}} @endif>{{ trans('labels.unpublished') }}</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label>{{ trans('labels.images') }}</label>
                              <div class="form-group">
                                <?php 
                                if (isset($property_img)) {
                                    foreach ($property_img as $key => $proImg) {
                                      //echo "<pre>"; print_r($proImg); die;
                                       ///$show_img = date('Ymd') . "." . $proImg->img_name;
                                 ?>
                                  <input type="hidden" class="form-control" name="image[]" id="image" value="@if(isset($proImg->img_name)){{ $proImg->img_name }} @endif">
                                  <input type="hidden" class="form-control" name="image_id[]" id="image_id" value="@if(isset($proImg->id)){{ $proImg->id }} @endif">
                                    <div class="col-md-3"><img src="@if(isset($proImg->img_name)){{ url('/public/productImage/'.$proImg->img_name ) }} @endif" class="btn popup_image" height="100px" width="100px"/>
                                        <?php $proid = $proImg->id; ?>
                                    <div class="form-group"><input type="button" class="btn btn-danger" name="" onclick="delete_img('{{ $proid }}')" value="{{ trans('labels.delete') }}"></div></div>
                                <?php } 
                                }   ?>
                                    <div id="add_img"></div>
                                    <div class="form-group"><input type="button" onclick="add_new_img()" value="{{ trans('labels.addNewImage') }}"></div>
                              </div>
                          </div>
                                          
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

    $( document ).ready(function() {


      //alert('gsdfg');

      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    });  

function add_new_img()
{
    jQuery('#add_img').append('<div class="col-md-3"><div class="form-group"><input type="file" name="image[]" id="image" accept="image/x-png,image/jpeg"></div></div>');
}

function delete_img(del_id)
    {
        //alert(del_id);
        $.ajax({
            type: "POST",
            url: "{{ url('admin/car_accessories/delete_img') }}",
            data: {del_id:del_id},
            
            success: function(result){
                location.reload();
            }
        });

    }

</script> 

<script type="text/javascript">
                            
  function getval(store_id)
  { //alert(store_val); return false;

    //var store_id = store_val.value;
    
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

@endsection

