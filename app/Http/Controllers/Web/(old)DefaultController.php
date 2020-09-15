<?php

namespace App\Http\Controllers\Web;
//use Mail;
//validator is builtin class in laravel
use Validator;

use DB;
//for password encryption or hash protected
use Hash;

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
//for Carbon a value 
use Carbon;
// use Request;
//email
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Request;
use App;
use App\User;
use App\Admin;
use App\Car;
use App\CarBrand;
use App\CarModel;
use App\Ads;
use App\ContactAgent;
use App\UploadId;
use App\DriverLicense;

use Session;

class DefaultController extends Controller
{
		
	//index 
	public function contactstore(Request $request)
    {
       
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');
    
        $data = array('name'=>$name,'email'=>$email,'message'=>$message);
        DB::table('contact_us')->insert($data);
        

        \Mail::send('contactusmail',
       array(
           'name' => $request->input('name'),
           'email' => $request->input('email'),
           'user_message' => $request->input('message')
       ), function($message) use ($request)
       {
          $message->from('harmistest@gmail.com');
          $message->to('harmistest@gmail.com', 'Admin')->subject($request->get('subject'));
       });

        $message = Lang::get("labels.Thanks for contacting us!");
        return back()->with('message', $message);

    }

	public function sellList(Request $request){

		

		if (!empty($_GET['brand'])) {
		  $brand = $_GET['brand']; 
        } else {
			$brand = ''; 
        }
        if(!empty($_GET['city'])){
			$city = $_GET['city'];
        } else {
			$city ="";
        }
        if (!empty($_GET['category'])) {
			$category = $_GET['category'];
        } else {
			$category = "";
        }
        if (!empty($_GET['year'])) {
          $year = $_GET['year']; 
        } else {
          $year = ''; 
        }
        
		$title = array('pageTitle' => Lang::get("website.Home"));
		$city = DB::table('city')->groupBy('name')->get();
		$brand = CarBrand::groupBy('name')->get();
		
		$year = DB::table('car_year')->pluck('year')->toArray();
		

		$min = Car::where('pro_type',1)->min('sale_price');
		$max = Car::where('pro_type',1)->max('sale_price');


		
		$result = array();			
		$result['city'] = $city;	
		$result['brand'] = $brand;	
		$result['year'] = $year;	
		$result['min'] = $min;	
		$result['max'] = $max;	
		$result['selectedCategory'] = $category;

		// echo '<pre>'; print_r($year); die;
			
		return view("sell_list", $title)->with('result', $result); 	
	}

	public function car_Detail($id)
	{ 

		$already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 

		$car_Detail = DB::table('car')
		  ->select('car.*','car_brand.name as carbrandName','city.name as cityname','city.ar as city_ar','city.ku as city_ku','car_model.name as modelName')
		  ->leftjoin('car_brand','car.car_brand','=','car_brand.id')
		  ->leftjoin('car_model','car.prop_category','=','car_model.id')
		  ->leftjoin('city','car.city','=','city.id')
		  ->where('car.id',$id)->first();
		$session = Session::all();


		if(!empty($session['userId']))
		{
			$user= User::where('id', $session['userId'])->first();
		} 
		else
		{
			$user= array();
		}


		$cat_name = DB::table('car_model')->where('id',$car_Detail->prop_category)->first();
		$car_img = DB::table('car_img')->where('car_id',$car_Detail->id)->get(); 

		$type_name = DB::table('car_types')->where('id',$car_Detail->pro_type)->first();

		return view('car_detail',compact('car_Detail','car_img','user','cat_name','type_name'));
	}


	public function carResult(Request $request)
    { 
         if($request->ajax())
		{ 

			$search = $request->get('type');
			// $city = $request->get('city');
			//$category = $request->get('category');
			$totalcount = $request->get('totalcount');
			$ads = Ads::all();

			$session = Session::all();
			$carbrand = $request->input('carbrand');
			$city = $request->input('city');
			$year = $request->input('year');
			$category = $request->input('category');
			$minkm = $request->input('minkm');
			$maxkm = $request->input('maxkm');
			$minprice = $request->input('minprice');
			$maxprice = $request->input('maxprice');

					$result = Car::where('pro_type',1)->where('published',1);
					if($request->id > 0)
					{ //echo 1111; die;

						if($carbrand != '') { $result->where('car_brand',$carbrand); }

						if($city != '')	{ $result->where('city',$city); }

						if($year != '')	{ $result->where('year_of_car',$year); }

						if($category != ''){ $result->where('prop_category',$category); }

						if($minprice !='' || $maxprice !='') { $result->whereBetween('sale_price', array($minprice, $maxprice)); }

						if($minkm !='' && $maxkm !='') { $result->whereBetween('kilometer', array($minkm, $maxkm)); }
						
					} else {

						if($carbrand != '') { $result->where('car_brand',$carbrand); }

						if($city != '')	{ $result->where('city',$city); }

						if($year != '')	{ $result->where('year_of_car',$year); }

						if($category != '') { $result->where('prop_category',$category); }

						if($minprice !='' || $maxprice !='') { $result->whereBetween('sale_price', array($minprice, $maxprice)); }

						if($minkm !='' && $maxkm !='') { $result->whereBetween('kilometer', array($minkm, $maxkm)); }

					}


					$result->orderby('id','DESC');
					if($search != '' && $category !='' && $carbrand !='' && $city !='' && $minkm !='' && $maxkm !='' && $minprice !='' && $maxprice !='')
					{
						$sellList = $result->get();
					}else {
						$sellList = $result->limit(21)->offset($totalcount)->get();
					}

			// if($request->id > 0)
			// { 
			// 	$result = Car::where('pro_type',1)->where('published',1);
			// 	if($carbrand != '')
			// 	{
			// 		$result->where('car_brand',$carbrand);
			// 	}
			// 	if($city != '')
			// 	{
			// 		$result->where('city',$city);
			// 	}
			// 	if($year != '')
			// 	{
			// 		$result->where('year_of_car',$year);
			// 	}
			// 	if($category != '')
			// 	{
			// 		$result->where('prop_category',$category);
			// 	}
			// 	if($minprice !='' || $maxprice !='')
			// 	{
			// 		$result->whereBetween('sale_price', array($minprice, $maxprice));
			// 	}
			// 	if($minkm !='' && $maxkm !='')
			// 	{
			// 		$result->whereBetween('sale_price', array($minkm, $maxkm));
			// 	}
			// 	$result->orderby('car.id','DESC');

			// 	$sellList = $result->limit(21)->offset($totalcount)->get();

			// } 
			// else {
			// 	$result = Car::where('pro_type',1)->where('published',1);
			// 	if($carbrand != '')
			// 	{
			// 		$result->where('car_brand',$carbrand);
			// 	}
			// 	if($city != '')
			// 	{
			// 		$result->where('city',$city);
			// 	}
			// 	if($year != '')
			// 	{
			// 		$result->where('year_of_car',$year);
			// 	}
			// 	if($category != '')
			// 	{
			// 		$result->where('prop_category',$category);
			// 	}
			// 	if($minprice !='' || $maxprice !='')
			// 	{
			// 		$result->whereBetween('sale_price', array($minprice, $maxprice));
			// 	}
			// 	if($minkm !='' && $maxkm !='')
			// 	{
			// 		$result->whereBetween('sale_price', array($minkm, $maxkm));
			// 	}
			// 	$result->orderby('car.id','DESC');

			// 	$sellList = $result->limit(21)->offset($totalcount)->get();

			// }
			$output = '';
				
			if(count($sellList) > 0)
			{ 
					
				foreach($sellList as $key=>$row)
				{ 
					
					$modelName = DB::table('car_model')->where('id',$row->prop_category)->first(); 
					$output .= '<div class="col-lg-4">
								<div class="single-popular-car">
									<div class="p-car-thumbnails">';

										$output .='<a href='.url("/car_Detail/$row->id").'>';
											$image = DB::table('car_img')->where('car_id',$row->id)->first(); 
											if(!empty($image))
											{
							
												if((file_exists(public_path().'/carImage/'.$image->img_name)))
												{ 		
													$imgname =$image->img_name;
													$imagename ='/public/carImage/'.$image->img_name;				                       
													$output .='<img src='.url($imagename).'>';						                       
												} 
												else 
												{ 						                       
													$output .='<img src='.url("/public/default-image.jpeg").'>';						                       
												}
											}  
											else
											{
													
												$output .='<img src='.url("/public/default-image.jpeg").'>';	
											}  
                                         if($row->pro_type != ''){
							$output .= '</a><div class="list-rest">
                                        <a href="javascript:void(0)">';
											if($row->pro_type == '1'){
												$output .= trans('labels.forsale');
											}
											elseif($row->pro_type == '2'){
												$output .= trans('labels.forrent');
											}
										
							$output .='</a>
                                    </div>';
                                }
                                $output .='</div>

									<div class="p-car-content">
										<h3>
											<a href='.url("/car_Detail/$row->id").'>'.$row->car_name.'</a>';
											if($row->sale_price != '')
											{
													$output .=	'<span class="price">$'.$row->sale_price.'</span>';
											}
											$output .= '</h3>

										<h5><i class="fas fa-map-marker-alt"></i>   '.$row->googleLocation.'</h5>

										<div class="p-car-feature">';
											if($row->year_of_car != ''){
												$output .= '<a href="javascript:void(0)">'.$row->year_of_car.'</a>';
											}
											if($row->gear_type != ''){
												$output .= '<a href="javascript:void(0)">'.$row->gear_type.'</a>';
											}
											
											
											if(!isset($session['language']) && $session['language'] == 'en'){
												$output .= '<a href="javascript:void(0)">'.$modelName->name.'</a>';
											} elseif(!isset($session['language']) && $session['language'] == 'ku'){
												$output .= '<a href="javascript:void(0)">'.$modelName->ku.'</a>';
											} elseif(!isset($session['language']) && $session['language'] == 'ar'){
												$output .= '<a href="javascript:void(0)">'.$modelName->ar.'</a>';
											}
											else {
												$output .= '';
											}

											

										$output .= '</div>
									</div>
								</div>
							</div>';

					$totalcount++;      
				
				}
			
				if(count($sellList) > 20){
					$output .= '<span id="hppp" class="col-md-12 >
						<div id="load_more" class="col-md-12 load_more_button">
						<button type="button" name="load_more_button" style="border:1px solid #0d83a9" class="btn btn-defualt form-control" id="load_more_button">Load More...</button></div></span>';
				}
			
			}
			else{ 
				$output .= '
				<div id="load_more" class="col-md-12">
				<button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
				<input type="hidden" name="nodata" id="nodata" value="0"></div>';
			}
			$output; 
			$response = array('result' => $output);
			echo json_encode($response); 
		}
	}

	// public function carResult1(Request $request)
	// {
	// 	$session = Session::all();
	// 	$carbrand = $request->input('carbrand');
	// 	$city = $request->input('city');
	// 	$year = $request->input('year');
	// 	$category = $request->input('category');
	// 	$minkm = $request->input('minkm');
	// 	$maxkm = $request->input('maxkm');
	// 	$minprice = $request->input('minprice');
	// 	$maxprice = $request->input('maxprice');
		

	// 		$result = Car::where('pro_type',1)->where('published',1);
	// 		if($carbrand != '')
	// 		{
	// 			$result->where('car_brand',$carbrand);
	// 		}
	// 		if($city != '')
	// 		{
	// 			$result->where('city',$city);
	// 		}
	// 		if($year != '')
	// 		{
	// 			$result->where('year_of_car',$year);
	// 		}
	// 		if($category != '')
	// 		{
	// 			$result->where('prop_category',$category);
	// 		}
	// 		if($minprice !='' || $maxprice !='')
	// 		{
	// 			$result->whereBetween('sale_price', array($minprice, $maxprice));
	// 		}
	// 		if($minkm !='' || $maxkm !='')
	// 		{
	// 			$result->whereBetween('sale_price', array($minkm, $maxkm));
	// 		}


	// 	 if($city == '' || $carbrand =='' || $category =='' || $year =='' || $maxprice =='' || $minprice == '' || $maxkm == '' || $minkm == "")
	//       {
	//         $result->orderby('car.id','DESC');
	//         $sellList = $result->get();
	//       }
			

	// 	 $output = '';
	// 	 if(count($sellList) > 0)
 //              { 
 //                $re = array();
               
 //               foreach($sellList as $key=>$row)
 //               { 
               		
 //               		$modelName = DB::table('car_model')->where('id',$row->prop_category)->first(); 
 //                	$output .= '<div class="col-lg-6">
	// 						    <div class="single-popular-car">
	// 						        <div class="p-car-thumbnails">';

	// 						            	$image = DB::table('car_img')->where('car_id',$row->id)->first(); 
							            	
	// 						            	if(!empty($image))
	// 						            	{
							
	// 							            	if((file_exists(public_path().'/carImage/'.$image->img_name)))
	// 						                    { 		
	// 						                   	 	$imgname =$image->img_name;
	// 							            		$imagename ='/public/carImage/'.$image->img_name;				                       
	// 						                        $output .='<img src='.url($imagename).'>';						                       
	// 						                    } 
	// 						                    else 
	// 						                    { 						                       
	// 						                        $output .='<img src='.url("/public/default-image.jpeg").'>';						                       
	// 						                    }
	// 						                }  
	// 						                else
	// 						                {
							                		
	// 						                	$output .='<img src='.url("/public/default-image.jpeg").'>';	
	// 						                }  
	// 					 $output .= '</div>

	// 						        <div class="p-car-content">
	// 						            <h3>
	// 						                <a href='.url("/car_Detail/$row->id").'>'.$row->car_name.'</a>';
	// 						                if($row->sale_price != '')
	// 						              	{
	// 						                	 $output .=	'<span class="price">₹'.$row->sale_price.'</span>';
	// 						                }
	// 						             	$output .= '</h3>

	// 						            <h5><i class="fas fa-map-marker-alt"></i>   '.$row->googleLocation.'</h5>

	// 						            <div class="p-car-feature">';
	// 						            	if($row->year_of_car != ''){
	// 						               		$output .= '<a href="javascript:void(0)">'.$row->year_of_car.'</a>';
	// 						            	}
	// 						            	if($row->gear_type != ''){
	// 						                $output .= '<a href="javascript:void(0)">'.$row->gear_type.'</a>';
	// 						            	}
							            	
							            	
	// 						            	if($session['language'] == 'en'){
	// 						                	$output .= '<a href="javascript:void(0)">'.$modelName->name.'</a>';
	// 						            	} elseif ($session['language'] == 'ku') {
	// 						            		$output .= '<a href="javascript:void(0)">'.$modelName->ku.'</a>';
	// 						            	} else {
	// 						            		$output .= '<a href="javascript:void(0)">'.$modelName->ar.'</a>';
	// 						            	}

	// 						         $output .= '</div>
	// 						        </div>
	// 						    </div>
	// 						</div>';
							  
	// 			}
	// 		}
	// 		else{
	// 			$output .= '
 //               <div id="car"  class="col-md-12">
 //                <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
 //                <input type="hidden" name="nodata" id="nodata" value="0" >
 //               </div>';


	// 		}
	// 		$response = array('result' => $output);
 //            echo json_encode($response); 
	// }


	public function rentalcar_detail(Request $request,$id=""){ 

		// echo "<pre>"; print_r($id); die;
		//$car_Detail->id = '';
		$already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 

		 $title = array('pageTitle' => Lang::get("website.Home"));
		 $car_Detail = DB::table('car')->select('car.*','car_brand.name as carbrandName','city.name as cityname','city.ar as city_ar','city.ku as city_ku','car_model.name as modelName')->leftjoin('car_brand','car.car_brand','=','car_brand.id')->leftjoin('car_model','car.prop_category','=','car_model.id')->leftjoin('city','car.city','=','city.id')->where('car.id',$id)->first();

		$car_img = DB::table('car_img')->where('car_id',$car_Detail->id)->get();

		$country = DB::table('countries')->select()->get();
		 return view("rentalcar_detail", $title,compact('car_Detail','car_img','country')); 	
	}


	public function showroomlist(Request $request,$filter=''){
		
		$title = array('pageTitle' => Lang::get("website.Home"));
		$filters = $request->input('filter');
		
		if($filters != "")
        {
        	$showRoomAdmins = DB::table('administrators')->where('issubadmin',2)->where('administrators.city',$filters)->paginate(10);
        }else {
			$showRoomAdmins = DB::table('administrators')->where('issubadmin',2)->Paginate(10);
		}
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['showRoomAdmins'] = $showRoomAdmins;	
		$result['city'] = $city;	
		$result['filters'] = $filters;	
		
		return view("showroomlist", $title)->with('result', $result); 		
	}
	public function showroomCarsList($myid)
	{
		$already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 

		$title = array('pageTitle' => Lang::get("website.Home"));
		$showroomdetail = DB::table('administrators')->where('myid',$myid)->first();
		$showroomCars = Car::where('showRoomId',$myid)->where('userType',2)->orderby('id','DESC')->paginate(6);
		
		$result = array();			
		$result['showroomdetail'] = $showroomdetail;	
		$result['showroomCars'] = $showroomCars;	
		
		
		return view("showroom-cars-list", $title)->with('result', $result); 		
	}
	

	public function storeAdminList(Request $request){
		
		$title = array('pageTitle' => Lang::get("website.Home"));
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['city'] = $city;	
		
		return view("storeadminlist", $title)->with('result', $result); 		
	}
	public function storeResult(Request $request)
	{
		$city = $request->input('searchStore');
			echo $city; die;

			$result = DB::table('administrators')->where('issubadmin',3);
			
			if($city != '')
			{
				$result->where('city',$city)->where('issubadmin',3);
			}
			$result->orderby('myid','DESC');
			$sellList = $result->paginate(4);
		 $output = '';
		 if(count($sellList) > 0)
              { 
                $re = array();
               
               foreach($sellList as $key=>$row)
               { 

                $output .= '<div class="col-md-6 col-lg-3">
							    <div class="store-sec">
							        <div class="store-inr-main">';
							            	
							            
						            	if(file_exists(base_path().'/'.$row->image) && $row->image != '')
					                    { 		
					                   	 				                       
					                        $output .='<img src='.url($row->image).'>';						                       
					                    } 
					                    else 
					                    { 						                       
					                        $output .='<img src='.url("/public/default-image.jpeg").'>';						                       
					                    }
							               
						 $output .= '</div>
           							<div class="str-main">
           								<h4>';
           								if($row->first_name !='' || $row->last_name != '') {
           									$det = route('productlist', ['id' => $row->myid]);
						              		$output .= '<a href="'.$det.'">'.$row->first_name.' '.$row->last_name.'</a>';

						                }
						                $output .= '</h4>
                						<ul>';
                						if($row->phone !=''){ 
					                        $output .='<li class="esta_li telp">
					                            <a href="tel:'.$row->phone.'">
					                                <label><i class="fa fa-mobile-alt"></i></label><span>'.$row->phone.'</span>
					                            </a>
					                            
					                        </li>';
					                    }
					                    if($row->email !=''){ 
                                  
						                    $output .='<li class="esta_li telp">
						                        <a href="mailto:'.$row->email.'"><label><i class="far fa-envelope"></i></label><span>'.$row->email.'</span></a>
						                    </li>';       
						                }
						               $output .=' </ul>
						                <div class="store-btn">
						                    <button type="submit"><a style="color:white" href="'.$det.'">'. trans('labels.storeProduct') .'</a></button>
						                </div>
						            </div>
						        </div>
						    </div>';
				$ban = Ads::where('published',1)->get();
				if($key == 7){
					if(!empty($ban)){
					    	$output .= '<section class="col-md-12 section-padding car-tre">
							        
							            <div class="bant-tre owl-carousel owl-theme property-slider2">';
					    foreach($ban as $bann ){
							                 $output .='<div class="item">';
							                
							                    if(file_exists(public_path("/dsaImage/".$bann->image)) AND $bann->image !='' ){
							                    $output .='<img src="'.url("/public/dsaImage/".$bann->image).'" alt="">';
							                    }
							                $output .='</div>';
					    }
							            $output .='</div>
							     
							    </section>';
					    
					}
				} 
						             
				}
			}else
			{
				$output .= '
               <div id="car" style="justify-content: center;">
                <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
               </div>';

			}
			$response = array('result' => $output);
            echo json_encode($response); 	
	}
	
	public function companyAdminList(Request $request,$filter=null){
		
		$title = array('pageTitle' => Lang::get("website.Home"));

		$filters = $request->input('filter');
		if($filters != "")
        {
		
        $companyAdmins = DB::table('administrators')->where('issubadmin',4)->where('city',$filters)->orderby('myid','DESC')->paginate(10);
		
        }else {
	
		$companyAdmins = DB::table('administrators')->where('issubadmin',4)->orderby('myid','DESC')->paginate(10);
		}
		
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['companyAdmins'] = $companyAdmins;	
		$result['city'] = $city;	
		$result['filters'] = $filters;	
		
		return view("companyadminlist", $title)->with('result', $result); 		
	}
	public function companyCarList($myid)
	{
		$already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 

		$title = array('pageTitle' => Lang::get("website.Home"));
		$companydetail = DB::table('administrators')->where('myid',$myid)->first();
		$companyCars = Car::where('companyId',$myid)->where('userType',3)->orderby('id','DESC')->paginate(6);
		
		$result = array();			
		$result['companydetail'] = $companydetail;	
		$result['companyCars'] = $companyCars;	
		$result['companyId'] = $myid;
		
		return view("company-car-list", $title)->with('result', $result); 		
	}
	
	public function rentalcarImageDelete(Request $request){
        if($request->name == '.upload_id'){
            $request->session()->push('uploadId',
            ['number'=>$request->number]);
                
        }
        elseif($request->name == '.uploadDrivingLicense'){
            $request->session()->push('uploadDrivingLicense',
            ['number'=>$request->number]);
                
		}
		elseif($request->name == 'myCar'){
			$request->session()->push('myCar',
            ['number'=>$request->number]);
		}
    }

    public function contactAgentSave(Request $request){
        // echo '<pre>'; print_r($request->carId); die;
		if(Session::has('userName')){
			$contactAgent = new ContactAgent;
			$contactAgent->carId = $request->carId;
			$contactAgent->userId = session()->get('userId');
			$contactAgent->user_type = '1';
			$contactAgent->firstName = $request->firstName;
			$contactAgent->lastName = $request->lastName;
			$contactAgent->nationality = $request->nationality;
			$contactAgent->email = $request->email;
			$contactAgent->phone = $request->phone;
			$contactAgent->dateFrom = $request->dateFrom;
			$contactAgent->dateTo = $request->dateTo;
			$contactAgent->status = 'Pending';
			$contactAgent->save();
			$lastId = $contactAgent->id;
			if($request->hasfile('upload_id')){
                $uploadIdObj =[];
				$uploadIdDeletes = $request->session()->get('uploadId');
				if($uploadIdDeletes !=  ''){
					foreach($uploadIdDeletes as $key=>$uploadIdDelete){
						$uploadIdObj[] = $uploadIdDelete['number'];    
					}
				}
				foreach($request->file('upload_id') as $key=>$image){
                    if(!in_array($key,$uploadIdObj)){
                        $uploadId = new UploadId();
                        $uploadId->c_agentId = $lastId;
                        $name=$image->getClientOriginalName();
                        $filename = time()."_".$key."_".$name;
                        $image->move('public/uploadId/', $filename);
                        $uploadId->image = $filename;
                        $uploadId->save();
                    }
				}
				if($uploadIdDeletes !=  ''){
	                session()->forget('uploadId');
				}
			}
			if($request->hasfile('driving_license')){
                $drivingLicenseObj = [];
                $drivingLicenseDeletes = $request->session()->get('uploadDrivingLicense');
				if($uploadIdDeletes !=  ''){
					foreach($drivingLicenseDeletes as $drivingLicenseDelete){
						$drivingLicenseObj[] = $drivingLicenseDelete['number'];    
					}
				}
				foreach($request->file('driving_license') as $key=>$image){
                    if(!in_array($key,$drivingLicenseObj)){
                        $driverLicense = new DriverLicense();
                        $driverLicense->c_agentId = $lastId;
                        $name=$image->getClientOriginalName();
                        $filename = time()."_".$key."_".$name;
                        $image->move('public/driverLicense/', $filename);
                        $driverLicense->license = $filename;
                        $driverLicense->save();
                    }
                }
				if($uploadIdDeletes !=  ''){
					session()->forget('uploadDrivingLicense');
				}
            }
			return redirect('/rentalcar_detail/'.$request->carId);
		}
        else{
            return redirect()->route('login');
        }
	}
	

	public function rentalCarList(Request $request){
		
		$title = array('pageTitle' => Lang::get("website.Home"));
		$companyAdmins = DB::table('administrators')->join('car','car.companyId','=','administrators.myid','left')->select('administrators.*')->where('administrators.issubadmin',4)->where('car.pro_type','=',2)->orderby('administrators.myid','DESC')->paginate(10);
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['companyAdmins'] = $companyAdmins;	
		$result['city'] = $city;	
		
		return view("rentalcarlist", $title)->with('result', $result); 		
	}

	public function productList(Request $request){


		$title = array('pageTitle' => Lang::get("website.Home"));
		$products = DB::table('car_accessories')->join('car_accessories_img', 'car_accessories.id', '=', 'car_accessories_img.product_id')->select('car_accessories.*','car_accessories_img.img_name')->where('store_id',$request->id)->where('status',1)->Paginate(9);
		$result = array();			
		$result['products'] = $products;	
		return view("productlist", $title)->with('result', $result); 	
	}

	public function contactus(Request $request){
		$title = array('pageTitle' => Lang::get("website.Home"));

		$result = array();			
		
		return view("contactus", $title)->with('result', $result); 	
	}

	public function carshowroom_detail(Request $request){
		$title = array('pageTitle' => Lang::get("website.Home"));

		$result = array();			
		
		return view("carshowroom_detail", $title)->with('result', $result); 	
	}	
}