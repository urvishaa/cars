@extends('layout')
@section('content')
<div class="super_container">
	<div class="super_overlay"></div>


	<div class="listing_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<!-- About -->
					<div class="about">
						<div class="row">
							<div class="col-lg-8">
								<div class="property_info det">
									<div class="detail_main">


										<div class="owl-carousel owl-theme detail_slider">
											
											
											<div class="slide">
												<a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('/public/default-image.jpeg')}}" > <img src="{{ URL::to('/public/default-image.jpeg')}}" alt=""> </a>
											</div>
											
										</div>
										<div class="detail-inner">
												<div class="detail_rent">
													<a href="#">{{ trans('labels.forsale') }} </a>
												</div>
												
												<div class="deta_price">$ 777  </div> 
										</div>
										<div class="detail-bottom">
												
												<div class="tag tag_rent detail_rent save">
													<a href="#" ><i class="fab fa-youtube"></i>{{ trans('labels.Vidio') }}</a>
												</div>
												
									
												

												<div class="sharethis-inline-share-buttons" id="myDIV"></div>
												<!-- <div class="tag_price listing_price detail_rent share">	
													<a href="javascript:void(0)" onclick="myFunction()"><i class="fas fa-share"></i>Share</a>
												</div>
 -->										</div>
									</div>
								</div>
							</div>

							
							<div class="col-lg-4">
								<div class="about_text detail-right">
									<div class="listing_content detail-info">
										<div class="listing_info detail_cnt">
												<ul class="d-flex flex-row align-items-center justify-content-start flex-wrap">
													<li class="property_area d-flex flex-row align-items-center detail-items">
														<img src="{{ URL::to('/resources/assets/img/icon_2.png')}}" alt="">
														<span>{{ trans('labels.kilometer') }}</span>
													</li>
													<li class="d-flex flex-row align-items-center detail-items">
														<img src="{{ URL::to('/resources/assets/img/icon_3.png')}}" alt="">
														<span> {{ trans('labels.Bath') }}</span>
													</li>
													<li class="d-flex flex-row align-items-center detail-items">
														<img src="{{ URL::to('/resources/assets/img/icon_4.png')}}" alt="">
														<span>{{ trans('labels.Bedroom') }}</span>
													</li>	
												</ul>
								        </div>
								        <div class="prop_location listing_location det-prop">
								        	<div class="detail-image  d-flex flex-row align-items-center justify-content-start">
												<img src="{{ URL::to('/resources/assets/img/icon_1.png')}}" alt="">
												<a >carsaa</a>
											</div>
											<div class="detail-map">
												<div class="de-map-info" >
													<div id="mapCanvas" style="width: 100%; height: 200px;"></div>
												</div>
											</div>
									   </div>
									   <div class="contact-agent det-prop">
									   	  <div class="contact info">
									   	  	 <a href="#"><i class="fas fa-phone-alt"></i> 2322434  </a>
									   	  </div>
									   	 
									   	  <div class="tag_price listing_price detail_rent agent">
													<a href="javascript:void(0)"><i class="fas fa-comment-dots"></i>{{ trans('labels.contact_agent') }}</a>
										 </div>
										
									   </div>
							        </div>
								</div>
							</div>

							
						</div>		
					</div>
					<!-- <div class="google_map_container">
						<div class="map">
							<div id="google_map" class="google_map">
								<div class="map_container">
									<div id="map"></div>
								</div>
							</div>
						</div>
					</div> -->
					<div class="market">
						
							<div class="marke-desc">
								<h6>cars</h6>
								<p>cgfdgdgdg</p>
							</div>
							<div class="market-sec">
								<div class="mar-inr">
									<h5>{{ trans('labels.Car Type') }}</h5>
									<h6>123
									</h6>
								</div>
								<div class="mar-inr days">
									<h5>{{ trans('labels.Days on Market') }}</h5>
										
									
						               123
								</div>
								<div class="mar-inr days">
									<h5>{{ trans('labels.category') }}</h5>
									<h6> 
										sadsad
									</h6>
								</div>
								

							</div>
							<div class="monthly Charges">
								<div class="mar-inr">
										
												<h5>{{ trans('labels.sale_charges') }}</h5>
												<h6>asd</h6>
										
								</div>
							</div>
						
					</div>
					<div class="featured detail-feat">
						<div class="container">
							<div class="row">
								<div class="col">
									<div class="section_title_container text-center deals">
										<div class="section_subtitle">{{ trans('labels.the best deals') }}</div>
										<div class="section_title"><h1>{{ trans('labels.Featured Properties') }}</h1></div>
									</div>
								</div>
							</div>
							<div class="row featured_row">
					
								
								<div class="col-lg-4">
									<div class="listing">
										<div class="listing_image">
												
												<a href="">
												<div class="listing_image_container">
													<img src="{{ URL::to('/public/default-image.jpeg')}}" alt="">
												</div>
												</a>
												
											<div class="tags">
												
												<div class="tag tag_sale"><a href="#">for sale</a></div>
											</div>
											<div class="listing_price">
												
					                            <div class="tag_price">
					                                $ 123
					                            </div>
					                            
					                        </div>
										</div>
										
										<div class="listing_content">
											<div class="prop_location listing_location d-flex flex-row align-items-start justify-content-start">
												<img src="{{ URL::to('/resources/assets/img/icon_1.png')}}" alt="">
												<a href="{{ URL::to('/property-detail/'.@$related->id) }}">asd</a>
											</div>
											<div class="listing_info detail_cnt">
												<ul class="d-flex flex-row align-items-center justify-content-start flex-wrap">
													<li class="property_area d-flex flex-row align-items-center justify-content-start">
														<img src="{{ URL::to('/resources/assets/img/icon_2.png')}}" alt="">
														<span>{{ trans('labels.kilometer') }}</span>
													</li>
													<li class="d-flex flex-row align-items-center justify-content-start">
														<img src="{{ URL::to('/resources/assets/img/icon_3.png')}}" alt="">
														<span>{{ trans('labels.Bath') }}</span>
													</li>
													<li class="d-flex flex-row align-items-center justify-content-start">
														<img src="{{ URL::to('/resources/assets/img/icon_4.png')}}" alt="">
														<span>{{ trans('labels.Bedroom') }}</span>
													</li>
													
												</ul>
											</div>
										</div>
									</div>
								</div>
								

								

							</div>
						</div>
	               </div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection





