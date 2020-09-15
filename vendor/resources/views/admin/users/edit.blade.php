@extends('layouts.app')

@section('content')


<h3 class="page-title">{{ trans('labels.editUser') }}</h3>  


    <div class="panel panel-default programcrcls">
        
            <div class="panel-body">
                <form action="{{ url('admin/users/'.$user->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="panel-heading">
              
                        <div class="form-group abovebtn-right">
                             
                              <div class="col-md-12">
                                <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                <a href="{{ url('admin/users') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
                              </div>
                        </div>
                    </div>
                        {{ method_field('PUT') }}
                    {!! csrf_field() !!}
                    <div class="centerdiv">
                        <div class="subcenter">
                            <div class="form-group">
                                <label for="name">{{ trans('labels.name') }} <span class="clsred">*</span></label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="lname">{{ trans('labels.LastName') }} <span class="clsred">*</span></label>
                                <input type="text" name="lname" id="lname" value="{{ $user->lname }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="username">{{ trans('labels.userName') }} <span class="clsred">*</span></label>        
                                <input type="text" name="username" value="{{ $user->username }}" class="form-control" required autofocus> 
                            </div>

                            <div class="form-group">
                                <label for="gender">{{ trans('labels.gender') }}</label>        
                                <input type="radio" name="gender" value="1" {{ $user->gender == 1 || $user->gender == '' ? 'checked="checked"' : '' }}> {{ trans('labels.male') }}
                                <input type="radio" name="gender" value="2" {{ $user->gender == 2 ? 'checked="checked"' : '' }}> {{ trans('labels.female') }}
                            </div>

                            <div class="form-group">
                                <label for="aged">{{ trans('labels.aged') }} </label>        
                                <input type="checkbox" name="aged" value="1" {{ $user->aged == 1 ? 'checked="checked"' : '' }} > {{ trans('labels.aged') }}
                            </div>
                            
                            <div class="form-group">
                                <label for="password">{{ trans('labels.password') }} </label>        
                                <input type="password" name="password" value="" class="form-control" >    
                                <input type="hidden" name="old_password" id="old_password" value="{{ $user->password }}" >
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('labels.email') }} <span class="clsred">*</span></label>        
                                <input type="Email" name="email" value="{{ $user->email }}" class="form-control" required autofocus>    
                            </div>
                            <div class="form-group">
                                <label for="dob">{{ trans('labels.dateOfBirth') }} </label>        
                                <input type="text" name="dob" value="{{ $user->dob }}" class="date form-control">    
                            </div>       

                            <div class="form-group">
                                <label for="dob">{{ trans('labels.profileImage') }}</label>                      
                                <input class="col-md-3" name="image"  value="" type="file">  

                                @if($user->image != "")
                                    <div class="col-md-2"><img src="@if(isset($user->image)){{ url('/public/profileImage/'.$user->image ) }} @endif" class="btn popup_image" height="100px" width="100px"/></div>
                                @else
                                    <div class="col-md-2"><img src="{{ url('/public/default-image.jpeg' ) }}" class="btn popup_image" height="100px" width="100px"/></div>
                                @endif
                                <input type="hidden" name="oldimage" value="{{ $user->image }}">
                            </div>

                            <div class="form-group">
                                <label for="dob">{{ trans('labels.address') }}</label>                      
                                <textarea name="address" placeholder="Enter Address">{{ $user->address }}</textarea>
                            </div>
                            
                            
                            <div class="form-group">
                                  <label class="col-md-4 control-label" for="submit"></label>
                                  <div class="col-md-8">
                                    <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                                    <a href="{{ url('admin/users') }}" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a>
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

</script> 

@endsection

