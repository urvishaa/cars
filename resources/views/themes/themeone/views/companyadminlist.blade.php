@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
?>

<?php //echo '<pre>'; print_r($result); die; ?>
    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2>{{ trans('labels.companyAdminList') }}</h2>
                       </div>
                        <div >
                            <p style="font-weight: 600; margin-bottom: 15px; color: red; margin-top: 0px;">{{ trans('labels.registrationContact') }}</p>
                        </div>
                       <div class="show-select">
                             
                              <select onchange="ddfilter()" id="filter" name="filter">
                              <option value="" >{{ trans('labels.selectCity') }}</option>
                                @forelse($result['city'] as $city) 
                                      <option value="{{ $city->id }}"  @if(isset($result['filters']) AND $result['filters'] == @$city->id) selected @endif > @if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                                @empty    
                                @endforelse
                            </select>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                   
                        @if(count($result['companyAdmins']))
                            @foreach($result['companyAdmins'] as $companyAdmin)
                            <div class="col-md-6">
                            
                                <div class="img_real_home Car-rent form-group">
                                    <div class="img_real">
                                       <a href="{{ URL::to('/companyList/'.$companyAdmin->myid) }}">
                                        <img src="{{ $companyAdmin->image ? $new.'/'.$companyAdmin->image : url('/public/default-image.jpeg' )}}">
                                      </a>
                                    </div>
                                        <div class="real_content">
                                    
                                            <div class="estate_real">
                                                <ul class="esta_ul">
                                                @if($companyAdmin->first_name !='' || $companyAdmin->last_name != '')                                                 
                                                    <li class="esta_li">
                                                        <a href="{{ URL::to('/companyList/'.$companyAdmin->myid) }}">{{$companyAdmin->first_name}} {{$companyAdmin->last_name}}</a>
                                                        
                                                    </li>
                                                @endif
                                                @if($companyAdmin->phone !='') 

                                                    <li class="esta_li telp">
                                                        <a href="tel:{{$companyAdmin->phone}}">
                                                            <label><i class="fa fa-mobile-alt"></i></label><span>{{$companyAdmin->phone}}</span>
                                                        </a>
                                                        
                                                    </li>
                                                @endif
                                                @if($companyAdmin->email !='') 

                                                    <li class="esta_li telp">
                                                        <a href="mailto:{{$companyAdmin->email}}"><label><i class="far fa-envelope"></i></label><span>{{$companyAdmin->email}}</span></a>
                                                    </li> 
                                                @endif  

                                                @if($companyAdmin->city !='') 

                                                    <li class="esta_li telp">
                                                        <a><label><i class="fas fa-map-marker-alt"></i></label>
                                                          <span>@forelse($result['city'] as $city1) 
                                                                @if(isset($companyAdmin->city) AND $companyAdmin->city == @$city1->id)  @if(isset($session['language']) AND $session['language']=='ar') {{ $city1->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city1->ku }} @else {{ $city1->name }} @endif @endif
                                                          @empty    
                                                          @endforelse</span>
                                                        </a>
                                                    </li> 
                                                @endif                           
                                                </ul>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                       
                         
                        <p style=" width: 100%;display: flex;justify-content: center;align-content: center;">{{ trans('labels.noResultFound') }}</p>
                     
                        @endif
                        
                    </div>
                    <div style="margin-top: 15px;">{{ @$result['companyAdmins']->links('vendor.pagination.default') }}</div> 
                    <div class="col-xs-12 text-right">
                      
                    </div>
                </div>
    </section>
<script type="text/javascript">
     function ddfilter(){
      var fil = document.getElementById("filter").value;
      var url='{{ URL::to("/companyadminlist") }}';

     var urls=url+'?filter='+fil;
      window.location.href=urls;
    }
</script>
@endsection