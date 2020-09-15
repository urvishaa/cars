@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();

  
?>



    <section class="section-padding rent-car-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title  text-center sthowroom-detail">
                       <div class="show-ret"> 
                          <h2>{{ trans('labels.showroomList') }}</h2>
                       </div>
                       <div >
                            <p style="font-weight: 600; color: red; margin-top: 10px; margin-bottom: 15px;">{{ trans('labels.registrationContact') }}</p>
                        </div>
                       <?php // echo '<pre>'; print_r($session); die; ?>
                       <div class="show-select">
                             
                            <select  onchange="ddfilter()" id="filter" name="filter">
                              <option value="">{{ trans('labels.selectCity') }}</option>

                                @forelse($result['city'] as $city) 

                                      <option value="{{ $city->id }}" @if(isset($result['filters']) AND $result['filters'] == @$city->id) selected @endif> @if(isset($session['language']) AND $session['language']=='ar') {{ $city->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
                                @empty    
                                @endforelse
                            </select>
                          
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                   
                    @if(count($result['showRoomAdmins']))
                        @foreach($result['showRoomAdmins'] as $showRoomAdmin)
                            <div class="col-md-6">
                        
                                <div class="img_real_home Car-rent form-group">
                                    <div class="img_real">
                                      <a href="{{ URL::to('/showroomList/'.$showRoomAdmin->myid) }}">
                                        <img src="{{ $showRoomAdmin->image ? $new.'/'.$showRoomAdmin->image : url('/public/default-image.jpeg' )}}">
                                        </a>
                                    </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            @if($showRoomAdmin->first_name !='' || $showRoomAdmin->last_name != '')                                                 
                                                <li class="esta_li">
                                                    <a href="{{ URL::to('/showroomList/'.$showRoomAdmin->myid) }}">{{$showRoomAdmin->first_name}} {{$showRoomAdmin->last_name}}</a>
                                                    
                                                </li>
                                            @endif
                                            @if($showRoomAdmin->phone !='') 

                                                <li class="esta_li telp">
                                                    <a href="tel:{{$showRoomAdmin->phone}}">
                                                        <label><i class="fa fa-mobile-alt"></i></label><span>{{$showRoomAdmin->phone}}</span>
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            @if($showRoomAdmin->email !='') 

                                                <li class="esta_li telp">
                                                    <a href="mailto:{{$showRoomAdmin->email}}"><label><i class="far fa-envelope"></i></label><span>{{$showRoomAdmin->email}}</span></a>
                                                </li> 
                                            @endif    
                                            @if($showRoomAdmin->city !='') 

                                                <li class="esta_li telp">
                                                    <a><label><i class="fas fa-map-marker-alt"></i></label><span>
                                                       @forelse($result['city'] as $city1) 
                                                            @if(isset($showRoomAdmin->city) AND $showRoomAdmin->city == @$city1->id)  @if(isset($session['language']) AND $session['language']=='ar') {{ $city1->ar }} @elseif(isset($session['language']) AND $session['language']=='ku') {{ $city1->ku }} @else {{ $city1->name }} @endif @endif
                                                      @empty    
                                                      @endforelse
                                                    </span></a>
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
                    <div style="margin-top: 25px;">{{ $result['showRoomAdmins']->links('vendor.pagination.default') }}</div>
                    <div class="col-xs-12 text-right">
                    </div>
                </div>
   
    </section>
<script type="text/javascript">
 function ddfilter(){
  var fil = document.getElementById("filter").value;
  var url='{{ URL::to("/showroomlist") }}';

 var urls=url+'?filter='+fil;
  window.location.href=urls;
}
</script>
@endsection