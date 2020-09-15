@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $grandTotal =0;
?>

   
<section class="chkoutfrm">
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div class="cart-car-img">
                    <img class="rvrc-img" src="{{ URL::to('/resources/assets/img/sports-car.png')}}">
                </div>

            </div>
            
            <div class="col-md-6">               
                      
                <!-- The timeline -->
                {!! Form::open(array('url' =>route('buynow.save'), 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','validate')) !!}


                    <div class="mb-3">
                        <label for="name">{{ trans('labels.name') }} <span style="color: red">*</span></label>
                        <input type="text" name="name" id="name" value="" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="mobile">{{ trans('labels.mobile') }}<span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="" required>
                    </div>

                    <div class="mb-3">
                      <label for="address">{{ trans('labels.Address') }} <span style="color: red">*</span></label>
                      <textarea name="address" id="address" class="form-control"  required></textarea>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="">{{ trans('labels.City') }}<span style="color: red">*</span></label>
                        <select class="custom-select d-block w-100" name="city"  required>
                            <option value="">{{ trans('labels.selectCity') }}</option>
                            @foreach($result['cities'] as $city)
                                <option  value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                      </div>
                     
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-myclr btn-block" type="submit">{{ trans('labels.placeOrder') }}</button>

                {!! Form::close() !!}
            </div>
              <!-- /.nav-tabs-custom -->
            <!-- /.col -->
        </div>
      <!-- /.row -->
 
    </div>
    <!-- /.container -->
</section>

@endsection 