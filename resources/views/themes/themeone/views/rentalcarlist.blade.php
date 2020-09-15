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
                          <h2>{{ trans('labels.companyAdminList') }}</h2>
                       </div>
                       <div class="show-select">
                             
                              <select>
                              <option value="">{{ trans('labels.selectCity') }}</option>
                                @forelse($result['city'] as $city) 
                                      <option value="{{ $city->id }}"> @if($session['language']=='ar') {{ $city->ar }} @elseif($session['language']=='ku') {{ $city->ku }} @else {{ $city->name }} @endif</option>
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
                        
                            <div class="img_real_home Car-rent">
                                <div class="img_real">
                                    <img src="{{ $companyAdmin->image ? $new.'/'.$companyAdmin->image : url('/public/default-image.jpeg' )}}">
                                </div>
                                    <div class="real_content">
                                
                                        <div class="estate_real">
                                            <ul class="esta_ul">
                                            @if($companyAdmin->first_name !='' || $companyAdmin->last_name != '')                                                 
                                                <li class="esta_li">
                                                    <a href="#">{{$companyAdmin->first_name}} {{$companyAdmin->last_name}}</a>
                                                    
                                                </li>
                                                @endif
                                            @if($companyAdmin->phone !='') 

                                                <li class="esta_li telp">
                                                    <a href="tel:{{$companyAdmin->phone}}">
                                                        <i class="fas fa-phone-alt"></i>{{$companyAdmin->phone}}
                                                    </a>
                                                    
                                                </li>
                                            @endif
                                            @if($companyAdmin->email !='') 

                                                <li class="esta_li telp">
                                                    <a href="mailto:{{$companyAdmin->email}}"><i class="fas fa-envelope"></i>{{$companyAdmin->email}}</a>
                                                </li> 
                                            @endif                          
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        @endif                   
                    </div>
                    <div class="col-xs-12 text-right">
                        {{$result['companyAdmins']->links('vendor.pagination.default')}}
                    </div>
                </div>
    </section>
@endsection