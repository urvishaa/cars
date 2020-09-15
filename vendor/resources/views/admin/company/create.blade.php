@extends('layouts.app')
@section('content')

  <!-- Content Header (Page header) -->
<!--   @if (count($errors) > 0)
                      @if($errors->any())
                      <div class="alert alert-success alert-dismissible">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{$errors->first()}}
                      </div>
                    @endif
                  @endif  -->

  <section class="content-header">
    <div class="box-header-main"><h3 class="page-title">{{ trans('labels.company') }} </h3></div>
  </section>
 
<?php 
$urlnew = url(''); 
$new = str_replace('index.php', '', $urlnew); 
?>

  <!-- Main content -->
  <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $new.'/resources/views/admin/images/admin_profile/default-image.jpeg'; ?>"   alt="profile picture">

              <h3 class="profile-username text-center"></h3>

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
              {{-- <li><a href="#passwordDiv" data-toggle="tab">{{ trans('labels.Password') }}</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">
                  
                  <!-- The timeline -->
                   {!! Form::open(array('url' =>'admin/companyAdmin/store', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','validate')) !!}
                            
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.AdminFirstName') }}<span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="first_name" id="first_name" value="" class="form-control" required="required" autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminFirstNameText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('labels.LastName') }}<span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="text" name="last_name" id="last_name" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminLastNameText') }}</span>
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('labels.Email') }}<span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" value="" class="form-control" required autofocus>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AdminEmailText') }}</span>
                        </div>
                      </div>

                      
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.Picture') }}
                        </label>
    
                        <div class="col-sm-10">
                            <input type="file" name="newImage" id="newImage" value="" class="">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.PictureText') }}</span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.Address') }} <span style="color: red">*</span></label>
    
                        <div class="col-sm-10">
                            <textarea name="address" id="address" class="form-control" required></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.AddressText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">{{ trans('labels.description') }}</label>
    
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control"></textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.DescriptionText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.City') }}<span style="color: red">*</span></label>
                        <div class="col-sm-10">  
                            <select class="field select2 form-control" name="city[]" autofocus required id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.selectCity') }}">
                                  <option value="">{{ trans('labels.selectCity') }}</option>
                                    @forelse($result['cities'] as $city) 
                                       <option  value="{{ $city->id }}">{{ $city->name }}</option>
                                    @empty    
                                    @endforelse  
                              </select>                     
                            
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.city') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.Country') }}</label>
                        <div class="col-sm-10">                       
                            <select class="form-control" name="country" id="entry_country_id" required>
                                <option value="">{{ trans('labels.SelectCountry') }}</option>
                                @foreach($result['countries'] as $countries)
                                    <option value="{{ $countries->countries_id }}">{{ $countries->countries_name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CountryText') }}</span>
                        </div>
                      </div>

                      

                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.ZipCode') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="zip" id="zip" value="" class="form-control">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.Phone') }}</label>
    
                        <div class="col-sm-10">
                            <input type="text" name="phone" id="phone" value="" class="form-control" required>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            {{ trans('labels.PhoneText') }}</span>
                        </div>
                      </div>
                      

                      <div class='form-horizontal'>
                        <div class="form-group">
                          <label for="password" class="col-sm-2 control-label">{{ trans('labels.NewPassword') }}<span style="color: red">*</span></label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" required name="password" placeholder="{{ trans('labels.newPassword') }}">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                            <span style="display: none" class="help-block"></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <label for="re-password" class="col-sm-2 control-label">{{ trans('labels.Re-EnterPassword') }}<span style="color: red">*</span></label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="re_password" required name="re_password" placeholder="{{ trans('labels.reEnterPassword') }}">
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                            <span style="display: none" class="help-block"></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">{{ trans('labels.save') }}</button>
                          </div>
                        </div>
                      </div>


                      
                      {{-- <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Save</button>
                        </div>
                      </div> --}}
                    {{-- {!! Form::close() !!} --}}
              </div>
              <!-- /.tab-pane -->

              {{-- <div class="tab-pane" id="passwordDiv">
                 <div class='form-horizontal'>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">{{ trans('labels.NewPassword') }}<span style="color: red">*</span></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" required name="password" placeholder="{{ trans('labels.newPassword') }}">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="re-password" class="col-sm-2 control-label">{{ trans('labels.Re-EnterPassword') }}<span style="color: red">*</span></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="re_password" required name="re_password" placeholder="{{ trans('labels.reEnterPassword') }}">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">{{ trans('labels.save') }}</button>
                    </div>
                  </div>
              </div> --}}
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
    var zone = zone_val.value;
     
    $.ajax({
        url: "{{ url('/admin/company/zones') }}",
        data: { zone_val: zone },
        type: "post",
        success: function(data){
          //alert(data); 
          $('#zoneId').html(data);
        }
    });

  }
</script>


@endsection 