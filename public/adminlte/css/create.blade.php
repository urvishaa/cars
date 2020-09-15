@extends('layouts.app')
@section('content')
<div class="clseducation">

<div class="container-fluid">
  <h2>New Education </h2>
  <ul class="nav nav-tabs clsuledu">
    <li class="active"><a data-toggle="tab" href="#home">General Info</a></li>
    <li id="menu11"><a data-toggle="tab" href="#menu1">Admissions</a></li>
    <li><a data-toggle="tab" href="#menu2">Programs</a></li>
    <li><a data-toggle="tab" href="#menu3">About Us</a></li>
    <li><a data-toggle="tab" href="#menu4">Contact</a></li>
    <li><a data-toggle="tab" href="#menu5">Image</a></li>
    <li><a data-toggle="tab" href="#menu6">Campus</a></li>
  </ul>


<form action="/schoolpro/admin/educations"  method="POST" enctype="multipart/form-data">
            <div class="form-group abovebtn-right">
   
              <div class="col-md-12">
                <button id="submit" name="submit" onclick="return check_form()" class="btn btn-primary" value="1">Save</button>
                <a href="{{ url('admin/educations') }}" id="cancel" name="cancel" class="btn btn-default">Cancel</a>
              </div>
            </div>

 {{ csrf_field() }}
    <div class="tab-content">

        <div id="home" class="tab-pane fade in active"> 
            <p>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                         
                             <div class="panel-body">                           
                                     
                                    <div class="form-group">
                                        <label for="Education">Education <span class="clsred">*</span></label> 
                                        <select class="field form-control" onchange="notdisplay(this.value)" id="edu_type" name="edu_type" required autofocus>
                                            <option value="">--Select Education Type--</option>
                                            <option value="1" >Nursery</option>
                                            <option value="2" >School</option>
                                            <option value="3" >University</option>                                        
                                        </select>   
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Name <span class="clsred">*</span></label>        
                                        <input type="text" name="name" id="name" class="form-control" value="" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="Name">Logo</label>        
                                        <input type="file" name="logo">
                                        <img  name="logo" height="50" width="50" src="{{URL::to('/')}}/public/uploads/no-photo.jpg">                                            
                                    </div>
                                         
                                    <div class="form-group">
                                        <label for="Description">Description</label>  
                                        <textarea name="description" class="form-control"></textarea>          
                                    </div>
                                    <div class="form-group">
                                        <label for="tution_fees">Tution Fees <span class="clsred">*</span></label>       
                                        <input type="text" name="tution_fees" id="tution_fees" class="form-control" value="" required autofocus>
                                        <span id="descval" class="descval" style="display:none;color:red;margin-left:115px;"></span>     
                                    </div>
                                    <div class="form-group">
                                        <label for="tour_desc">Tour Description</label>        
                                        <textarea name="tour_desc" class="form-control"></textarea>     
                                    </div>
                                    <div class="form-group">
                                        <label for="info_apply">Info Apply</label>        
                                        <textarea name="info_apply" class="form-control"></textarea>     
                                    </div>
                                    <div class="form-group">
                                        <label for="ranking">Ranking <span class="clsred">*</span></label>        
                                         <input type="text" name="ranking" id="ranking" class="form-control" value="" required autofocus>     
                                    </div>   

                                    <div class="form-group">
                                        <label for="published" >Published</label>        
                                        <select name="published" class="field">
                                            <option value="1">Published</option>
                                            <option value="0">Unpublished</option>
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
                        <div id="maindv">
                            <table>
                            <tr>                           
                                <td>
                                    <input type="text" name="addmname[]" placeholder="Name" id="cdname"  >  
                                    <textarea name="addmdesc[]" placeholder="Description" ></textarea>
                                    <label class="newlbl"> File :</label> <input type="file" name="addimage[]" >                       
                                    <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this)" value="delete">
                                </td>
                            </tr>
                            </table>
                        </div>        
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
                                    @forelse($programlevel as $value)  
                                        <div class="checkdata">
                                            <label>{{ $value->name }} </label>  
                                            <input type="checkbox"  id="checkAll{{ $value->id  }}" class="checkAll" name="prolevel[]" value="{{ $value->id }}">                                                                        
                                              @php $prolel= App\Programs::getprogramlevel($value->id); @endphp
                                                @forelse($prolel as $valuess)   
                                                    <div class="checkbox">
                                                      <label><input type="checkbox"  class="checkItem{{ $value->id }}"  name="prosublevel[]" value="{{ $valuess->id }}">{{ $valuess->name }}</label>
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
                                    <textarea name="overview" class="form-control"></textarea>          
                                </div>

                                <div class="form-group">
                                    <label for="vision">Vision</label>  
                                    <textarea name="vision" class="form-control"></textarea>          
                                </div> 

                                <div class="form-group">
                                    <label for="mission">Mission</label>  
                                    <textarea name="mission" class="form-control"></textarea>          
                                </div>

                                <div class="form-group">
                                    <label for="philosophy">Philosophy</label>  
                                    <textarea name="philosophy" class="form-control"></textarea>          
                                </div>   

                                <div class="form-group">
                                    <label for="accreditation">Accreditation</label>  
                                    <textarea name="accreditation" class="form-control"></textarea>          
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
                                        <label for="address">Address <span class="clsred">*</span></label>     
                                        <input type="text" placeholder="Select Location" onchange="getLocation(this.value)" size="50" name="address" id="address" value="" class="form-control"  id="autocomplete" autocomplete="off" required autofocus>                                      
                                    </div>

                                    <div class="form-group">
                                        <label for="latitude">latitude <span class="clsred">*</span></label>        
                                        <input type="text" name="latitude" id="latitude" class="form-control" value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="longitude">longitude <span class="clsred">*</span></label>        
                                        <input type="text" name="longitude" id="longitude" class="form-control" value="">
                                    </div>

                                     <div class="form-group">
                                        <label for="email">Email <span class="clsred">*</span></label>        
                                        <input type="email" name="email" id="email" class="form-control" value="" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number">Phone <span class="clsred">*</span></label>        
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <label for="website_url">Website <span class="clsred">*</span></label>        
                                        <input type="text" name="website_url" id="website_url" class="form-control" value="" required autofocus>
                                    </div>

                                     <div class="form-group">
                                        <label for="facebook_url">Facebook Url</label>        
                                        <input type="text" name="facebook_url" class="form-control" value="">
                                    </div>

                                    <div class="form-group">
                                        <label for="twitter_url">Twitter Url</label>        
                                        <input type="text" name="twitter_url" class="form-control" value="">
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
                                    </div>   
                                    <div class="form-group">
                                        <label for="address">Image 2</label>        
                                        <input type="file" name="image2">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Image 3</label>        
                                        <input type="file" name="image3">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Image 4</label>        
                                        <input type="file" name="image4">                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Image 5</label>        
                                        <input type="file" name="image5">                                        
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
                        <div id="maindv">
                            <table>
                            <tr>                           
                                <td>
                                    <input type="text" name="campname[]" id="campname" placeholder="Name"> 
                                    <textarea name="campdesc[]" id="campdesc[]" placeholder="Description"></textarea>  
                                     <label class="newlbl"> File :</label><input type="file" name="campimage[]"  value="">           
                                    <input type="button" class="remove" name="cdDelete" onclick="cdDeleteRow(this')" value="delete">
                                </td>
                            </tr>
                            </table>
                        </div>        
                    </td>
                  </tr>
                </table>
           </div>
           </p> 
        </div> 

    </div>  


        <div class="form-group">
         
            <span id="schltype" style="display:none;color:red;margin-left:310px;"></span> 
            <span id="schlname"  style="display:none;color:red;margin-left:310px;"></span>  
            <span id="schlfee"  style="display:none;color:red;margin-left:310px;"></span>
            <span id="descval1"  style="display:none;color:red;margin-left:310px;"></span>  
            <span id="schlrank"  style="display:none;color:red;margin-left:310px;"></span>  
            <span id="schladd"  style="display:none;color:red;margin-left:310px;"></span> 
            <span id="schlemail"  style="display:none;color:red;margin-left:310px;"></span>  
            <span id="schlphone"  style="display:none;color:red;margin-left:310px;"></span>  
            <span id="schlweb"  style="display:none;color:red;margin-left:310px;"></span> 
              <label class="col-md-4 control-label" for="submit"></label>
              <div class="col-md-8">
                <button id="submit" name="submit" onclick="return check_form()" class="btn btn-primary" value="1">Save</button>
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
            ihtml += '<input type="text" name="addmname[]" placeholder="Name" value="" >';
            ihtml += '<textarea name="addmdesc[]" placeholder="Description"></textarea>';
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
            ihtml += '<input type="text" name="campname[]" placeholder="Name" value="" >';
            ihtml += '<textarea name="campdesc[]" placeholder="Description"></textarea>';
            ihtml += ' <label class="newlbl"> File :</label><input type="file" name="campimage[]"  value="">';
            ihtml += '<input type="button" class="remove" name="cddelete" onclick="cdDeleteRow1(this)" class="button" value="delete">';

            TD1.innerHTML=ihtml;    
            TR1.appendChild (TD1);    
            TD1.setAttribute("id", "row");
            var tableset= document.getElementById("cdsets12");
            tableset.appendChild(TR1)
        }
    }       

    $(document).ready(function(){
        $('#tution_fees').keyup(function () {       
             if(!isNaN(parseFloat(this.value)) && isFinite(this.value))
             {
                document.getElementById('descval').style.display = 'none';
             }
             else
             {
                document.getElementById('descval').innerHTML = 'Please fill out only numeric value .';
                document.getElementById('descval').style.display = 'block';
                return false ;
             }
        });


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
         
        var edu_type = document.getElementById('edu_type').value; 
        var name = document.getElementById('name').value;    
        var ranking = document.getElementById('ranking').value; 
        var address = document.getElementById('address').value; 
        var email = document.getElementById('email').value;     
        var phone_number = document.getElementById('phone_number').value; 
        var website_url = document.getElementById('website_url').value;
        var tution = document.getElementById('tution_fees').value; 

        document.getElementById('schltype').style.display = 'none';  
        document.getElementById('schlname').style.display = 'none'; 
        document.getElementById('schlrank').style.display = 'none'; 
        document.getElementById('descval1').style.display = 'none';
        document.getElementById('schladd').style.display = 'none';
        document.getElementById('schlemail').style.display = 'none';
        document.getElementById('schlphone').style.display = 'none';
        document.getElementById('schlweb').style.display = 'none';

        if(edu_type=='')
        {        
            document.getElementById('schltype').innerHTML = 'Please fill out education type field';
            document.getElementById('schltype').style.display = 'block';            
        }
  
        if(name=='')
        {
            document.getElementById('schlname').innerHTML = 'Please fill out name field';
            document.getElementById('schlname').style.display = 'block';      
        }
       
        if(ranking=='')
        {
            document.getElementById('schlrank').innerHTML = 'Please fill out ranking field';
            document.getElementById('schlrank').style.display = 'block';      
        }

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
        } 

        if(address=='')
        {
            document.getElementById('schladd').innerHTML = 'Please fill out address field';
            document.getElementById('schladd').style.display = 'block';         
        }

        if(email=='')
        {
            document.getElementById('schlemail').innerHTML = 'Please fill out Email field';
            document.getElementById('schlemail').style.display = 'block';            
        }
        else if(! (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('email').value)))
        {
            document.getElementById('schlemail').innerHTML = 'Please fill out valid Email ';
            document.getElementById('schlemail').style.display = 'block';            
        }
        if(phone_number=='')
        {
            document.getElementById('schlphone').innerHTML = 'Please fill out phone field';
            document.getElementById('schlphone').style.display = 'block';           
        }

        if(website_url=='')
        {
            document.getElementById('schlweb').innerHTML = 'Please fill out website field';
            document.getElementById('schlweb').style.display = 'block';
            return false;
        } 
    }


    function initAutocomplete()
    {       
        autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete')),
        { });        
    }
    </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF-6c5rkAINXSEGqnFDfchi_rksY6KJn0&libraries=places&callback=initAutocomplete"
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


