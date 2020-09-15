@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ trans('labels.Setting') }}  <small>{{ trans('labels.Setting') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
 
      <li class="active">{{ trans('labels.Setting') }}</li>
    </ol>
  </section>
  

  <section class="content"> 

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.Setting') }} </h3>
          </div>          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                    <br>                       
                        @if (count($errors) > 0)
                              @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  {{$errors->first()}}
                                </div>
                              @endif
                          @endif
                  
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/updatesetting', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                              
                                {!! Form::hidden('id',  0 , array('class'=>'form-control', 'id'=>'id')) !!}
                                                      
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.secure_secret') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="secure_secret" class="form-control field-validate" value="">
                                  </div>
                                </div>   

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.online_url') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="online_url" class="form-control field-validate" value="">
                                  </div>
                                </div>  

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.access_code') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="access_code" class="form-control field-validate" value="">
                                  </div>
                                </div>                                 
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.merchant_txn_ref') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="merchant_txn_ref" class="form-control field-validate" value="">
                                  </div>
                                </div>                                 
                          
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.merchant_id') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="merchant_id" class="form-control field-validate" value="">
                                  </div>
                                </div>                                 
                                                         
                          
                                
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
                                <a href="{{ URL::to('admin/updatesetting')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                              </div>
                              <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                  </div>
              </div>
            </div>
            
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>

  </section>
  <!-- /.content --> 
</div>
@endsection 