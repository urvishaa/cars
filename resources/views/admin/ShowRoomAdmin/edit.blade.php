@extends('layouts.app')
@section('content')

  <!-- Content Header (Page header) -->

  <?php 
    if (isset($message)) { ?>
      <div class="alert alert-danger" role="alert">
        <span><?php echo $message ?></span>
      </div>
    <?php }
   ?>

  <section class="content-header">
    <div class="box-header-main"><h3 class="page-title"> {{ trans('labels.showRoomAdmin') }} </h3></div>
  </section>
  
  <!-- Main content -->
  <section class="content">

      <div class="row">
        <div class="col-md-3">
<?php 
$urlnew = url(''); 
$new = str_replace('index.php', '', $urlnew); 
?>
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if($ShowRoomAdmin->image != "")
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/'.$ShowRoomAdmin->image; ?>" alt="<?php echo $ShowRoomAdmin->first_name; ?> profile picture">
              @else
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/resources/views/admin/images/admin_profile/default-image.jpeg'; ?>"   alt="profile picture">
              @endif
              <h3 class="profile-username text-center"><?php echo $ShowRoomAdmin->first_name.' '.$ShowRoomAdmin->last_name; ?></h3>

              <p class="text-muted text-center">{{ trans('labels.Administrator') }}</p>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">{{ trans('labels.Profile') }}</a></li>
              <li><a href="#passwordDiv" data-toggle="tab">{{ trans('labels.Password') }}</a></li>
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">
                 {{--  @if (count($errors) > 0)
                      @if($errors->any())
                      <div class="alert alert-success alert-dismissible">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="icon fa fa-check"></i> {{ trans('labels.Success') }}</h4>
                        {{$errors->first()}}
                      </div>
                    @endif
                  @endif --}}
                <!-- The timeline -->
                    <form action="{{ url('admin/showRoomAdmin/updateShowRoomAdmin/'.$ShowRoomAdmin->myid) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                   {{-- {!! Form::open(array('url' =>'admin/showRoomAdmin', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!} --}}
                            
                            {!! Form::hidden('oldImage', $ShowRoomAdmin->image, array('class'=>'form-control', 'id'=>'oldImage'))!!}

                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.AdminFirstName') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="first_name" id="first_name" value="<?php echo $ShowRoomAdmin->first_name ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminFirstNameText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('labels.LastName') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="last_name" id="last_name" value="<?php echo $ShowRoomAdmin->last_name ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminLastNameText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('labels.Email') }}</label>
    
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" value="<?php echo $ShowRoomAdmin->email ?>" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminEmailText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.Picture') }}
                        </label>
    
                        <div class="col-sm-10">
                            <input type="file" name="newImage" id="newImage">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.PictureText') }}</span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.Address') }} </label>
    
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control"><?php echo $ShowRoomAdmin->address ?></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AddressText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">{{ trans('labels.description') }} <span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control"><?php echo $ShowRoomAdmin->description ?></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.DescriptionText') }}</span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.City') }}</label>
                        <div class="col-sm-10">                       
                           <select class="field select2 form-control" name="city[]" autofocus required id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.selectCity') }}">
                               @forelse($result['cities'] as $city) 
                                  @if(isset($setProperty) !='')
                                    <option value="{{ $city->id }}"  @if(in_array($city->id, $setProperty)) {{ 'selected' }} @endif >{{ $city->name }}</option>
                                  @else
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                  @endif
                              @empty    
                              @endforelse  
                          </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.selectCity') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.Country') }}</label>
                        <div class="col-sm-10">                       
                            <select class="form-control" name="country" id="entry_country_id" onchange="zones(this.value)">
                                <option value="">{{ trans('labels.SelectCountry') }}</option>
                                @if($ShowRoomAdmin->country != "")
                                    @foreach($result['countries'] as $countries)
                                        <option @if($ShowRoomAdmin->country==$countries->countries_id) selected @endif value="{{ $countries->countries_id }}">{{ $countries->countries_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CountryText') }}</span>
                        </div>
                      </div>

                      
                     

                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.ZipCode') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="zip" id="zip" value="<?php echo $ShowRoomAdmin->zip ?>" class="form-control">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.Phone') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="phone" id="phone" value="<?php echo $ShowRoomAdmin->phone ?>" class="form-control">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.PhoneText') }}</span>
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success">{{ trans('labels.save') }}</button>
                        </div>
                      </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="passwordDiv">
                <form action="{{ url('admin/showRoomAdmin/updateAdminPassword/'.$ShowRoomAdmin->myid) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                 {{-- {!! Form::open(array('url' =>'admin/showRoomAdmin/updateAdminPassword', 'onSubmit'=>'return validatePasswordForm()', 'id'=>'updateAdminPassword', 'name'=>'updateAdminPassword' , 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!} --}}
                 <div class='form-horizontal'>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">{{ trans('labels.NewPassword') }}</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('labels.NewPassword') }}">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="re-password" class="col-sm-2 control-label">{{ trans('labels.Re-EnterPassword') }}</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="{{ trans('labels.Re-EnterPassword') }}">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Save</button>
                    </div>
                  </div>
                </div>
                  {!! Form::close() !!}
                {{-- </form> --}}
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
  <!-- /.content --> 

<script type="text/javascript">
  
  function zones(zone_val)
  { 

    $.ajax({
        url: "{{ url('/admin/showRoomAdmin/zones') }}",
        data: { zone_val: zone_val },
        type: "post",
        success: function(data){
          $('#zoneId').html(data);
        }
    });

  }
</script>



@endsection 