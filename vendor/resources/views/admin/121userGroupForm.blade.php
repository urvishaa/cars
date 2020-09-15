@extends('layouts.app')
{{-- @extends('admin.layout') --}}
@section('content')
  <!-- Content Header (Page header) -->
  
  <!-- Main content -->
     <h3 class="page-title"><?php if(empty($result['edituser']->id)) { ?>
               {{ trans('labels.add_userGroup') }}  
     <?php } else { ?>
              {{ trans('labels.edit_userGroup') }}
     <?php } ?> </h3>    
     <div class="panel panel-default">
        <div class="panel-heading">
           <?php if(empty($result['edituser']->id)) { ?>
               {{ trans('labels.add_userGroup') }}  
           <?php } else { ?>
               {{ trans('labels.edit_userGroup') }}
           <?php } ?>
        </div>
      <!-- SELECT2 EXAMPLE -->
        <div class="panel-body table-responsive progrmslistcls">  
          <div class="prolisttabcls">
            <form action="{{ url('admin/saveUserGroup') }}" method="POST" >
              {{ csrf_field() }}
                <input type="hidden" class="form-control" name="id" id="id" value="@if(isset($result['edituser']->id)) {{ $result['edituser']->id }} @endif">
            
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>{{ trans('labels.TYPE') }}</label>
                        <input type="text" class="form-control" required="" name="typeName" id="typeName" value="@if(isset($result['edituser']->typeName)) {{ $result['edituser']->typeName }} @endif">
                      </div>

                      <div class="form-group">
                        <label>{{ trans('labels.PARENTGROUP') }}</label>
                        <select class="form-control" id="parentGroup" name="parentGroup" style="width: 100%;">
                          <option value="">{{ trans('labels.select_parentGroup') }}</option>
                            @php 
                              $test=0;
                            @endphp
                            @foreach($result['getparentName'] as $parenName)
                            @if($test == 0) 
                              @if(isset($result['edituser']->parentGroup)) 
                              @if($result['edituser']->parentGroup == $parenName->id) 
                                <option selected value="{{ $parenName->id }}">{{ $parenName->typeName }}</option>
                                {{-- @php $test = 1; @endphp --}}
                              @else
                                <option value="{{ $parenName->id }}">{{ $parenName->typeName }}</option>
                              @endif
                            @else 
                                <option value="{{ $parenName->id }}">{{ $parenName->typeName }}</option>
                            @endif
                            @endif
                            @endforeach
                        </select>
                      </div>

                      <input type="submit" class="btn btn-default" name="submit" id="submit_button" value="{{ trans('labels.SUBMIT') }}">

                    </div>
                  </div>
                </div>        
            </form>
          </div>
        </div>
    </div>
  <!-- /.content --> 
@endsection 