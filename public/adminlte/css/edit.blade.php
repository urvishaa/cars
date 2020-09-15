@extends('layouts.app')

@section('content')
<div class="clseducation">

<div class="container-fluid">
    <h2>Edit Education </h2>
      <ul class="nav nav-tabs clsuledu">
        <li class="active"><a data-toggle="tab" href="#home">General Info</a></li>
        <li id="menu11"><a data-toggle="tab" href="#menu1">Admissions</a></li>
        <li><a data-toggle="tab" href="#menu2">Programs</a></li>
        <li><a data-toggle="tab" href="#menu3">About Us</a></li>
        <li><a data-toggle="tab" href="#menu4">Contact</a></li>
        <li><a data-toggle="tab" href="#menu5">Image</a></li>
        <li><a data-toggle="tab" href="#menu6">Campus</a></li>
      </ul>

    <form action="/schoolpro/admin/educations/{{ $educations->id }}" onsubmit="return check_form()" method="POST" enctype="multipart/form-data">

                    <div class="form-group abovebtn-right">
              
                          <div class="col-md-12">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="{{ url('admin/educations') }}" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                        </div>
                  
        {{ method_field('PUT') }}
        {!! csrf_field() !!}
        <div class="tab-content">

            <div id="home" class="tab-pane fade in active"> 
                <p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                             
                                 <div class="panel-body">                           
                                         
                                        <div class="form-group">
                                            <label for="Education">Education</label><span class="clsred">*</span>
                                            <select class="field form-control" onchange="notdisplay(this.value)" name="edu_type" required autofocus>
                                                <option value="" {{ $educations->edu_type == 0 ? 'selected="selected"' : '' }} >--Select Education Type--</option>
                                                <option value="1" {{ $educations->edu_type == 1 ? 'selected="selected"' : '' }} >Nursery</option>
                                                <option value="2" {{ $educations->edu_type == 2 ? 'selected="selected"' : '' }} >School</option>
                                                <option value="3" {{ $educations->edu_type == 3 ? 'selected="selected"' : '' }} >University</option>                                        
                                            </select>   
                                        </div>
                                        <div class="form-group">
                                            <label for="Name">Name</label>   <span class="clsred">*</span>     
                                            <input type="text" name="name" class="form-control" value="{{ $educations->name }}" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="Name">Logo</label>
                                            <input type="file" name="logo" value="{{ $educations->logo }}">                                     

                                            @if($educations->logo !='')
                                                <img  name="old_logo" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $educations->logo }}">
                                            @else                                      
                                                <img  name="old_logo" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                            @endif
                                        </div>



                                        <div class="form-group">
                                            <label for="Description">Description</label>  
                                            <textarea name="description" class="form-control">{{ $educations->description }}</textarea>          
                                        </div>                                    

                                        <div class="form-group">
                                            <label for="tution_fees">Tution Fees</label><span class="clsred">*</span>        
                                            <input type="text" name="tution_fees" id="tution_fees" class="form-control" value="{{ $educations->tution_fees }}" required autofocus>
                                            <span id="descval" class="descval" style="display:none;color:red;margin-left:115px;"></span>     
                                        </div>


                                        <div class="form-group">
                                            <label for="tour_desc">Tour Description</label>        
                                            <textarea name="tour_desc" class="form-control">{{ $educations->tour_desc }}</textarea>     
                                        </div>
                                        <div class="form-group">
                                            <label for="info_apply">Info Apply</label>        
                                            <textarea name="info_apply" class="form-control">{{ $educations->info_apply }}</textarea>     
                                        </div>
                                        <div class="form-group">
                                            <label for="ranking">Ranking</label>   <span class="clsred">*</span>     
                                             <input type="text" name="ranking" class="form-control" value="{{ $educations->ranking }}" required autofocus>     
                                        </div>      

                                        <div class="form-group">
                                            <label for="published">Published: </label> 
                                            <select name="published" class="field">
                                                <option value="1" {{ $educations->published == 1 ? 'selected="selected"' : '' }}>Published</option>
                                                <option value="0" {{ $educations->published == 0 ? 'selected="selected"' : '' }}>Unpublished</option>
                                            </select>                                              
                                        </div>                            
                                   
                                                
                                </div> 
                            </div>
                        </div>
                    </div>
                </p>
            </div>

            <div id="menu1" class="tab-pane fade">
                <div class="campuscls">
                    <table id="cdsets1">
                      <tr>
                          <td>
                            <p> Use this button to add new admission section</p>
                            <input type="button" class="addnew" id="cdaddvalue" value="ADD NEW" onclick="addadmissiondetail();">
                            <span id="addmindetail"  style="display:none;color:red;margin-left:310px;"></span> 
                          </td>
                      </tr>      

                      <tr>
                        <td>      

                            @forelse($Educationadmission as $eduadd)           
                                <div id="maindv{{ $eduadd->id}}">
                                    <table>
                                    <tr>                           
                                        <td>
                                            <input type="text" name="addmname[]" value="{{ $eduadd->addname }}" placeholder="Name" id="cdname" > 
                                            <textarea name="addmdesc[]" placeholder="Description" >{{$eduadd->adddesc}}</textarea> 
                                                <label class="newlbl"> File :</label><input type="file" name="addimage[]" value="">  

                                                @if($eduadd->addimage !='')                                             
                                                    <img  name="addimage" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $eduadd->addimage }}">                                                
                                                @else
                                                    <img  name="addimage" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif  
                                                                                              
                                                <input type="hidden" name="old_addimage[]" id="oldimages[]" value="{{ $eduadd->addimage }}" />            
                                            <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this)" value="delete">
                                        </td>
                                    </tr>
                                    </table>
                                </div> 
                            @empty  
                                <div id="maindv">
                                    <table>
                                    <tr>                           
                                        <td>
                                            <input type="text" name="addmname[]" placeholder="Name" id="cdname" > 
                                            <textarea name="addmdesc[]" placeholder="Description" ></textarea> 
                                           <label class="newlbl"> File :</label> <input type="file" name="campimage[]" value=""> 
                                            <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this)" value="delete">
                                        </td>
                                    </tr>
                                    </table>
                                </div>   
                            @endforelse
                   
                        </td>
                      </tr>
                    </table>
               </div>   
            </div> 

            <div id="menu2" class="tab-pane fade">
                <p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                             
                                 <div class="panel-body">   

                                    <div class="form-group">

                                        @php   $arrays=array(); @endphp
                                        @forelse($Educationprogram as $eduval)
                                            @php     
                                                $arrays[]= $eduval->pro_id;
                                            @endphp
                                        @empty    
                                        @endforelse 

                                        @forelse($programlevel as $value)  
                                            <div class="checkdata">
                                                <label>{{ $value->name }} </label>  
                                                <input type="checkbox"  id="checkAll{{ $value->id  }}" class="checkAll" name="prolevel[]" value="{{ $value->id }}">                                                                        
                                                  @php $prolel= App\Programs::getprogramlevel($value->id); @endphp
                                                    @forelse($prolel as $valuess)   
                                                        <div class="checkbox">
                                                          <label><input type="checkbox"   @if(in_array($valuess->id,$arrays)) {  checked="checked" ;  } @else { } @endif   class="checkItem{{ $value->id }}"  name="prosublevel[]" value="{{ $valuess->id }}">{{ $valuess->name }}</label>
                                                        </div>
                                                    @empty
                                                    @endforelse                                      
                                            </div>
                                        @empty    
                                        @endforelse     
                                    </div>
                                                
                                </div> 
                            </div>
                        </div>
                    </div>
                </p>
            </div>

            <div id="menu3" class="tab-pane fade">
                <p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                             
                                 <div class="panel-body">   

                                    <div class="form-group">
                                        <label for="overview">Overview</label>  
                                        <textarea name="overview" class="form-control">{{ $educations->overview }}</textarea>          
                                    </div>

                                    <div class="form-group">
                                        <label for="vision">Vision</label>  
                                        <textarea name="vision" class="form-control">{{ $educations->vision }}</textarea>          
                                    </div> 

                                    <div class="form-group">
                                        <label for="mission">Mission</label>  
                                        <textarea name="mission" class="form-control">{{ $educations->mission }}</textarea>          
                                    </div>

                                    <div class="form-group">
                                        <label for="philosophy">Philosophy</label>  
                                        <textarea name="philosophy" class="form-control">{{ $educations->philosophy }}</textarea>          
                                    </div>   

                                    <div class="form-group">
                                        <label for="accreditation">Accreditation</label>  
                                        <textarea name="accreditation" class="form-control">{{ $educations->accreditation }}</textarea>          
                                    </div>   
                                                
                                </div> 
                            </div>
                        </div>
                    </div>
                </p>
            </div>

            <div id="menu4" class="tab-pane fade">
                <p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                             
                                 <div class="panel-body">                      
                                        
                                        <div class="form-group">
                                            <label for="address">Address</label> <span class="clsred">*</span>    
                                            <input type="text" placeholder="Select Location" size="50" name="address" value="{{ $educations->address }}" class="form-control"  id="autocomplete" autocomplete="off" required autofocus>                                      
                                        </div>

                                        <div class="form-group">
                                            <label for="latitude">latitude</label><span class="clsred">*</span>        
                                            <input type="text" name="latitude" class="form-control" value="{{ $educations->latitude }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="longitude">longitude</label> <span class="clsred">*</span>       
                                            <input type="text" name="longitude" class="form-control" value="{{ $educations->longitude }}">
                                        </div>

                                         <div class="form-group">
                                            <label for="email">Email</label><span class="clsred">*</span>        
                                            <input type="email" name="email" class="form-control" value="{{ $educations->email }}" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone_number">Phone</label>  <span class="clsred">*</span>      
                                            <input type="text" name="phone_number" class="form-control" value="{{ $educations->phone_number }}" required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="website_url">Website</label>   <span class="clsred">*</span>     
                                            <input type="text" name="website_url" class="form-control" value="{{ $educations->website_url }}" required autofocus>
                                        </div>

                                         <div class="form-group">
                                            <label for="facebook_url">Facebook Url</label>        
                                            <input type="text" name="facebook_url" class="form-control" value="{{ $educations->facebook_url }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="twitter_url">Twitter Url</label>        
                                            <input type="text" name="twitter_url" class="form-control" value="{{ $educations->twitter_url }}">
                                        </div>                            
                                   
                                                
                                </div> 
                            </div>
                        </div>
                    </div>
                </p>
            </div>

            <div id="menu5" class="tab-pane fade clsmenuimg">
                <p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel panel-default">
                             
                                 <div class="panel-body">      
                                                                   
                                        <div class="form-group">
                                            <label for="address">Image 1</label>        
                                            <input type="file" name="image1">   
                                               
                                            @forelse($Educationimages as $imagess)

                                                @if($imagess->image1 !='')                                                   
                                                    <img  name="image1" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $imagess->image1 }}">                                                
                                                @else                                                    
                                                    <img  name="image1" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif 

                                            @empty
                                            @endforelse                        
                                        </div>   

                                        <div class="form-group">
                                            <label for="address">Image 2</label>        
                                            <input type="file" name="image2">                                               
                                           
                                            @forelse($Educationimages as $imagess)                                             
                                                @if($imagess->image2 !='')                                                  
                                                    <img  name="image2" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $imagess->image2 }}">                                                
                                                @else                                                    
                                                    <img  name="image2" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif                                                   
                                            @empty
                                            @endforelse
                                                                                                          
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Image 3</label>        
                                            <input type="file" name="image3">   
                                            
                                            @forelse($Educationimages as $imagess)
                                                @if($imagess->image3 !='')
                                                    <img  name="image3" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $imagess->image3 }}">                                                
                                                @else
                                                    <img  name="image3" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif                                                   
                                            @empty
                                            @endforelse                                                               
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Image 4</label>        
                                            <input type="file" name="image4">
                                            
                                            @forelse($Educationimages as $imagess)
                                                @if($imagess->image4 !='')                                           
                                                    <img  name="image4" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $imagess->image4 }}">                                              
                                                @else
                                                    <img  name="image4" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif
                                            @empty
                                            @endforelse                                                                
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Image 5</label>        
                                            <input type="file" name="image5">   
                                   
                                            @forelse($Educationimages as $imagess) 
                                                @if($imagess->image5 !='')
                                                    <img  name="image5" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $imagess->image5 }}">
                                                @else
                                                    <img  name="image5" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif
                                            @empty
                                            @endforelse 
                                        </div> 
                                                               
                                </div> 
                            </div>
                        </div>
                    </div>
                </p>
            </div>

            <div id="menu6" class="tab-pane fade">
                <p>
                <div class="campuscls">
                    <table id="cdsets12">
                      <tr>
                          <td>
                            <p> Use this button to add campus section</p>
                            <input type="button" class="addnew" id="cdaddvalue1" value="ADD NEW" onclick="addcampusdetail();">
                            <span id="campdetail"  style="display:none;color:red;margin-left:310px;"></span> 
                          </td>
                      </tr>      

                      <tr>
                        <td>    

                             @forelse($Educationcampus as $educmp)           
                                <div id="maindv{{ $educmp->id}}">
                                    <table>
                                    <tr>                           
                                        <td>
                                            <input type="text" name="campname[]" value="{{ $educmp->campname }}" placeholder="Name" id="campname"> 
                                            <textarea name="campdesc[]" placeholder="Description" >{{$educmp->campdesc}}</textarea> 
                                             <label class="newlbl"> File :</label><input type="file" name="campimage[]" value="">  

                                                @if($educmp->campimage !='')                                             
                                                    <img  name="campimage" height="50" width="50" src="{{URL::to('/public')}}/uploads/{{ $educmp->campimage }}">                                                
                                                @else
                                                    <img  name="campimage" height="50" width="50" src="{{URL::to('/public')}}/uploads/no-photo.jpg">
                                                @endif  
                                                                                              
                                                <input type="hidden" name="old_campimage[]" id="oldimage[]" value="{{ $educmp->campimage }}" />
                                            <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this)" value="delete">
                                        </td>
                                    </tr>
                                    </table>
                                </div> 
                            @empty  
                                <div id="maindv">
                                    <table>
                                    <tr>                           
                                        <td>
                                            <input type="text" name="campname[]" placeholder="Name" id="campname"> 
                                            <textarea name="campdesc[]" placeholder="Description" ></textarea>  
                                             <label class="newlbl"> File :</label><input type="file" name="campimage[]" value="">              
                                            <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this)" value="delete">
                                        </td>
                                    </tr>
                                    </table>
                                </div>   
                            @endforelse
   
                        </td>
                      </tr>
                    </table>
               </div>
               </p> 
            </div>

        </div>  
                <div class="form-group">
                <span id="descval1" class="descval" style="display:none;color:red;margin-left:310px;"></span> 
                          <label class="col-md-4 control-label" for="submit"></label>
                          <div class="col-md-8">
                            <button id="submit" name="submit" class="btn btn-primary" value="1">Save</button>
                            <a href="{{ url('admin/educations') }}" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
                          </div>
                </div>
                                  
  
    </form>                    

</div>

</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>   

function getLocation(address) 
{
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();

        document.getElementById("longitude").value = longitude; 
        document.getElementById("latitude").value = latitude; 

      } 
  }); 
}

function notdisplay(id)
{
    if(id==3)
    {    $('#menu11').hide();  }
    else
    {    $('#menu11').show();  }
}

function addadmissiondetail()
{
    var tution = document.getElementById('cdname').value;  
        
    if(tution=='')
    {        
        document.getElementById('addmindetail').innerHTML = 'Please fill out name filed on admission section.';
        document.getElementById('addmindetail').style.display = 'block';
        document.getElementById('cdname').style.border = '1px solid red';
    }
    else
    {
        document.getElementById('cdname').style.border = '';
        document.getElementById('addmindetail').style.display = 'none';
        var TR1 = document.createElement('tr');
        var TD1 = document.createElement('td');
        
        var ihtml = '';
        ihtml += '<input type="text" name="addmname[]" placeholder="Name"  value="" >';
        ihtml += '<textarea name="addmdesc[] placeholder="Description"></textarea>';
        ihtml += ' <label class="newlbl"> File :</label><input type="file" name="addimage[]"  value="">';
        ihtml += '<input type="button" class="remove" name="cddelete" onclick="cdDeleteRow(this)" class="button" value="delete">';

        TD1.innerHTML=ihtml;
    
        TR1.appendChild (TD1);
    
        TD1.setAttribute("id", "row");

        var tableset= document.getElementById("cdsets1");
        tableset.appendChild(TR1)
    }   

} 
function cdDeleteRow(r)
{

    if(window.confirm("Are you sure you want to delete field value"))
    {
        var e1=r.parentNode;
        e1.parentNode.removeChild(e1);
    }
}


function addcampusdetail()
{
    var tution = document.getElementById('campname').value;  
        
    if(tution=='')
    {        
        document.getElementById('campdetail').innerHTML = 'Please fill out name filed on campus section.';
        document.getElementById('campdetail').style.display = 'block';
        document.getElementById('campname').style.border = '1px solid red';
    }
    else
    {
        document.getElementById('campname').style.border = '';
        document.getElementById('campdetail').style.display = 'none';
        var TR1 = document.createElement('tr');
        var TD1 = document.createElement('td');
        
        var ihtml = '';
        ihtml += '<input type="text" name="campname[]" placeholder="Name"  value="" >';
        ihtml += '<textarea name="campdesc[]" placeholder="Description" id="addmdesc[]"></textarea>';
        ihtml += ' <label class="newlbl"> File :</label><input type="file" name="campimage[]" value="">';
        ihtml += '<input type="button" class="remove" name="cddelete" onclick="cdDeleteRow1(this)" class="button" value="delete">';

        TD1.innerHTML=ihtml;    
        TR1.appendChild (TD1);    
        TD1.setAttribute("id", "row");
        var tableset= document.getElementById("cdsets12");
        tableset.appendChild(TR1)
    }

}       

    $(document).ready(function(){

        $('.checkAll').click(function () { 
            if ($(this).is(':checked')) {
               var vall= $(this).attr('value');
               $(':checkbox.checkItem'+vall).prop('checked', this.checked);    
            } 
            else {
                var vall= $(this).attr('value');
                $(':checkbox.checkItem'+vall).prop('checked', this.checked);  
            }       
        });   
    });
      

    function check_form() {

        var tution = document.getElementById('tution_fees').value;       
        if(!isNaN(parseFloat(tution)) && isFinite(tution))
        {
            document.getElementById('descval1').style.display = 'none';
        }
        else
        {
            document.getElementById('descval1').innerHTML = 'Please fill out only numeric value on tution fees filed.';
            document.getElementById('descval').innerHTML = 'Please fill out only numeric value';
            document.getElementById('descval1').style.display = 'block';
            document.getElementById('descval').style.display = 'block';
            return false ;
        }
    }

function initAutocomplete() {
       
        autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete')),
            {          
             });        
      }
  </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2lQD8lHMPICHXfoXEmnT63q3zJRtJNQI&libraries=places&callback=initAutocomplete"
        async defer></script>

 <style>
   #map {
    width: 100px;
    height: 20px;
}
.controls {
    margin-top: 15px;
    border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 32px;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}
#searchInput {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 50%;
}
#searchInput:focus {
    border-color: #4d90fe;
}
.controls.inp-input {
    height: 25px;
    width: 200px;
}
    </style>




@endsection



