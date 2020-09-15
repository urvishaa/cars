@extends('layouts.app')
@section('content')

<h3 class="page-title">{{ trans('labels.newNotification') }}</h3>   


        <div class="panel panel-default programcrcls">
            
             <div class="panel-body">
                <form action="{{ url('admin/notification/save') }}" method="POST" enctype="multipart/form-data">
                 <div class="panel-heading">
                    <div class="form-group abovebtn-right">
                         
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                            <!-- <a href="#" id="cancel" name="cancel" class="btn btn-default">{{ trans('labels.cancel') }}</a> -->
                          </div>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                      <div class="centerdiv">
                        <div class="subcenter ful-wdth"> 
                          <div class="form-group row">
                              <label for="published" class="col-md-2">{{ trans('labels.type') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <select id="type" class="form-control " name="type" required="">
                                  <option disabled="" selected="" value="">{{ trans('labels.selectType') }}</option>
                                  <option value="1">{{ trans('labels.user') }}</option>
                                  <option value="2">{{ trans('labels.showRoomAdmin') }}</option>
                                  <option value="3">{{ trans('labels.StoreAdmin') }}</option>
                                  <option value="4">{{ trans('labels.company') }}</option>
                                </select>
                              </div>
                          </div>
                         
                          <div class="form-group row" id="user" >
                            <label for="published" class="col-md-2">{{ trans('labels.user') }}<span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select  class="field select2"  name="user[]"  id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.selectUser')}}">
                                <option value="alluser" >{{ trans('labels.allUsers') }}</option>
                                @forelse($user as $users)
                                <option value="{{ @$users->id }}" >{{ @$users->username }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                          </div>
                          <div class="form-group row" id="ShowRoomAdmin" >
                            <label for="published" class="col-md-2">{{ trans('labels.showRoomAdmin') }}<span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="ShowRoomAdmin[]"  id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.selectShowRoomAdmin')}}">
                                <option value="allshowRoomAdmin" >{{ trans('labels.allshowRoomAdmin') }}</option>
                                @forelse($ShowRoomAdmin as $ShowRoomAdmins)
                                <option value="{{ @$ShowRoomAdmins->myid }}" >{{ @$ShowRoomAdmins->first_name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                          </div>

                          <div class="form-group row" id="StoreAdmin" >
                            <label for="published" class="col-md-2">{{ trans('labels.store') }}<span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="StoreAdmin[]"  id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.SelectStore')}}">
                                <option value="allStoreAdmin" >{{ trans('labels.allStoreAdmin') }}</option>
                                @forelse($StoreAdmin as $StoreAdmins)
                                <option value="{{ @$StoreAdmins->myid }}" >{{ @$StoreAdmins->first_name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                          </div>

                          <div class="form-group row" id="company" >
                            <label for="published" class="col-md-2">{{ trans('labels.company') }}<span class="clsred">*</span></label>
                            <div class="col-md-10">
                            <select class="field select2 " name="company[]"  id="mainProId" multiple="multiple" data-placeholder="{{ trans('labels.selectCompany')}}">
                                <option value="allcompany" >{{ trans('labels.allcompany') }}</option>
                                @forelse($company as $companys)
                                <option value="{{ @$companys->myid }}" >{{ @$companys->first_name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                          </div>


                          <div class="form-group row">
                              <label for="name" class="col-md-2">{{ trans('labels.notification') }}<span class="clsred">*</span></label>
                              <div class="col-md-10">
                                <textarea name="notification" class="form-control " required></textarea>
                              </div>
                          </div>

                          
                          <div class="form-group">
                                <label class="col-md-2 control-label" for="submit"></label>
                                <div class="col-md-10">
                                  <button id="submit" name="submit" class="btn btn-primary" value="1">{{ trans('labels.save') }}</button>
                               
                                </div>
                          </div>
                        </div>
                      </div>
                </form>
                            
            </div> 
        </div>
    
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    
    $( document ).ready(function() {
      $('.date').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(ev){
        $(this).datepicker('hide');
        });
    });     

$(document).ready(function() {
    $("#user").hide();
    $("#ShowRoomAdmin").hide();
    $("#StoreAdmin").hide();
    $("#company").hide();

    $('#type').change(function(){
        if($(this).val() == '1'){
          $("#user").show();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").hide();
          $("#company").hide();

        }else if($(this).val() == '2'){
          $("#user").hide();
          $("#ShowRoomAdmin").show();
          $("#StoreAdmin").hide();
          $("#company").hide();
        }else if($(this).val() == '3'){
          $("#user").hide();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").show();
          $("#company").hide();
        }else if($(this).val() == '4'){
          $("#user").hide();
          $("#ShowRoomAdmin").hide();
          $("#StoreAdmin").hide();
          $("#company").show();
        }
               
    });
  
});    
</script> 

@endsection


