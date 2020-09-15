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

use App\User;
use App\Admin;
use App\Property;
use App\CarBrand;
use App\property_category;
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
        // echo $year; die;

		$title = array('pageTitle' => Lang::get("website.Home"));
		$city = DB::table('city')->groupBy('name')->get();
		$brand = CarBrand::groupBy('name')->get();
		$category = property_category::where('published',1)->get();
		$year = Property::where('year_of_car','!=','')->where('pro_type',1)->groupBy('year_of_car')->pluck('year_of_car')->toArray();


		
		$result = array();			
		$result['city'] = $city;	
		$result['brand'] = $brand;	
		$result['year'] = $year;	
		$result['category'] = $category;	

		// echo '<pre>'; print_r($year); die;
			
		return view("sell_list", $title)->with('result', $result); 	
	}

	public function car_Detail($id)
	{ //echo 111111; die;

		//$car_Detail= Property::where('id', $id)->first();

		$car_Detail = DB::table('properties')->select('properties.*','car_brand.name as carbrandName','city.name as cityname','city.ar as city_ar','city.ku as city_ku','property_category.name as modelName')->leftjoin('car_brand','properties.car_brand','=','car_brand.id')->leftjoin('property_category','properties.prop_category','=','property_category.id')->leftjoin('city','properties.city','=','city.id')->where('properties.id',$id)->first();
		//echo "<prE>"; print_r($car_Detail); die;
		$session = Session::all();


		if(!empty($session['userId']))
		{
			$user= User::where('id', $session['userId'])->first();
		} 
		else
		{
			$user= array();
		}


			$cat_name = DB::table('property_category')->where('id',$car_Detail->prop_category)->first();
			$car_img = DB::table('property_img')->where('property_id',$car_Detail->id)->get(); 

			$type_name = DB::table('property_types')->where('id',$car_Detail->pro_type)->first();

		return view('car_detail',compact('car_Detail','car_img','user','cat_name','type_name'));
	}

	public function carResult(Request $request)
	{
		// $url_segment = \Request::segment(1);
		$session = Session::all();
		//print_r($_GET['myid']); die;
		$carbrand = $request->input('carbrand');
		$city = $request->input('city');
		$year = $request->input('year');
		$category = $request->input('category');
		$minkm = $request->input('minkm');
		$maxkm = $request->input('maxkm');
		$minprice = $request->input('minprice');
		$maxprice = $request->input('maxprice');
			// DB::enableQueryLog(); 

			$result = Property::where('pro_type',1)->where('published',1);
			if($carbrand != '')
			{
				$result->where('car_brand',$carbrand);
			}
			if($city != '')
			{
				$result->where('city',$city);
			}
			if($year != '')
			{
				$result->where('year_of_car',$year);
			}
			if($category != '')
			{
				$result->where('prop_category',$category);
			}
			if($minprice !='' || $maxprice !='')
			{
				$result->whereBetween('sale_price', array($minprice, $maxprice));
				// $result->selectRaw(min($minkm), max($maxkm));
			}
			if($minkm !='' && $maxkm !='')
			{
				$result->whereBetween('sale_price', array($minkm, $maxkm));
			}
			$result->orderby('properties.id','DESC');

			$sellList = $result->paginate(10);
			// dd(DB::getQueryLog());
		// echo '<pre>'; print_r($sellList); die;

		 $output = '';
		 if(count($sellList) > 0)
              { 
                $re = array();
               
               foreach($sellList as $key=>$row)
               { 
               		
               		$modelName = DB::table('property_category')->where('id',$row->prop_category)->first(); 
                $output .= '<div class="col-lg-6">
							    <div class="single-popular-car">
							        <div class="p-car-thumbnails">';

							            	$image = DB::table('property_img')->where('property_id',$row->id)->first(); 
							            	
							            	if(!empty($image))
							            	{
							
								            	if((file_exists(public_path().'/propertyImage/'.$image->img_name)))
							                    { 		
							                   	 	$imgname =$image->img_name;
								            		$imagename ='/public/propertyImage/'.$image->img_name;				                       
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
						 $output .= '</div>

							        <div class="p-car-content">
							            <h3>
							                <a href='.url("/car_Detail/$row->id").'>'.$row->property_name.'</a>';
							                if($row->sale_price != '')
							              	{
							                	 $output .=	'<span class="price">₹'.$row->sale_price.'</span>';
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
							            	
							            	
							            	if($session['language'] == 'en'){
							                	$output .= '<a href="javascript:void(0)">'.$modelName->name.'</a>';
							            	} elseif ($session['language'] == 'ku') {
							            		$output .= '<a href="javascript:void(0)">'.$modelName->ku.'</a>';
							            	} else {
							            		$output .= '<a href="javascript:void(0)">'.$modelName->ar.'</a>';
							            	}

							         $output .= '</div>
							        </div>
							    </div>
							</div>';

				}
			}else
			{
				$output .= '
               <div id="car">
                <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
               </div>';

			}
			$response = array('result' => $output);
            echo json_encode($response); 
	}

	public function sellDetail(Request $request){
		// $title = array('pageTitle' => Lang::get("website.Home"));
		// $sellDetail = DB::table('properties')->where('id',$id)->first();

		// $result = array();			
		// $result['sellDetail'] = $sellDetail;	

		// // echo '<pre>'; print_r($result); die;
		
		// return view("sellDetail", $title)->with('result', $result); 	
	}


	public function rentalcar_detail(Request $request,$id=""){ 
		//echo "<pre>"; print_r($id); die;
		 $title = array('pageTitle' => Lang::get("website.Home"));
		 $car_Detail = DB::table('properties')->select('properties.*','car_brand.name as carbrandName','city.name as cityname','city.ar as city_ar','city.ku as city_ku','property_category.name as modelName')->leftjoin('car_brand','properties.car_brand','=','car_brand.id')->leftjoin('property_category','properties.prop_category','=','property_category.id')->leftjoin('city','properties.city','=','city.id')->where('properties.id',$id)->first();

		$car_img = DB::table('property_img')->where('property_id',$car_Detail->id)->get();
		//echo "<pre>"; print_r($car_Detail); die;
		//// $result = array();			
		 //$result['car_Detail'] = $car_Detail;	

		 //echo '<pre>'; print_r($result); die;
		
		 return view("rentalcar_detail", $title,compact('car_Detail','car_img')); 	
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
	public function showroomPropertyList($myid)
	{
		$title = array('pageTitle' => Lang::get("website.Home"));
		$showroomdetail = DB::table('administrators')->where('myid',$myid)->first();
		$showroomProperty = Property::where('showRoomId',$myid)->where('userType',2)->orderby('id','DESC')->paginate(6);
		
		$result = array();			
		$result['showroomdetail'] = $showroomdetail;	
		$result['showroomProperty'] = $showroomProperty;	
		
		return view("showroompropertylist", $title)->with('result', $result); 		
	}
	

	public function storeAdminList(Request $request){
		
		//echo Session::get('userId');
		$title = array('pageTitle' => Lang::get("website.Home"));
		// $storeAdmins = DB::table('car_accessories')->join('administrators','car_accessories.store_id','administrators.myid','inner')->where('administrators.issubadmin',3)->Paginate(12);
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		// $result['storeAdmins'] = $storeAdmins;	
		$result['city'] = $city;	
		
		return view("storeadminlist", $title)->with('result', $result); 		
	}
	public function storeResult(Request $request)
	{
		$productname = $request->input('productname');
		$storename = $request->input('storename');
		$city = $request->input('city');
			
			// DB::enableQueryLog(); 

			$result = DB::table('administrators')->join('car_accessories','administrators.myid','=','car_accessories.store_id','inner')->where('administrators.issubadmin',3)->groupBy('administrators.myid');
			if($storename != '')
			{
				$result->where('administrators.first_name','LIKE','%'.$storename)->orwhere('administrators.last_name','LIKE','%'.$storename.'%')->where('administrators.issubadmin',3);
			}
			if($city != '')
			{
				$result->where('administrators.city',$city)->where('administrators.issubadmin',3);
			}
			if($productname != '')
			{
				$result->where('car_accessories.name','LIKE','%'.$productname.'%')->where('administrators.issubadmin',3);
			}
		
			$result->orderby('administrators.myid','DESC');

			$sellList = $result->paginate(10);
			// dd(DB::getQueryLog());
		//echo '<pre>'; print_r($sellList); die;

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
		//echo $filters; die;
		if($filters != "")
        {
		
        $companyAdmins = DB::table('administrators')->join('properties','properties.companyId','=','administrators.myid','left')->select('administrators.*')->where('administrators.issubadmin',4)->where('properties.pro_type','=',2)->where('administrators.city',$filters)->orderby('administrators.myid','DESC')->groupBy('administrators.myid')->paginate(10);
		
        }else {
	
		$companyAdmins = DB::table('administrators')->join('properties','properties.companyId','=','administrators.myid','left')->select('administrators.*')->where('administrators.issubadmin',4)->where('properties.pro_type','=',2)->orderby('administrators.myid','DESC')->groupBy('administrators.myid')->paginate(10);
		}
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['companyAdmins'] = $companyAdmins;	
		$result['city'] = $city;	
		$result['filters'] = $filters;	
		
		return view("companyadminlist", $title)->with('result', $result); 		
	}
	public function companyPropertyList($myid)
	{
		$title = array('pageTitle' => Lang::get("website.Home"));
		$companydetail = DB::table('administrators')->where('myid',$myid)->first();
		$companyProperty = Property::where('companyId',$myid)->where('userType',3)->orderby('id','DESC')->paginate(6);
		
		$result = array();			
		$result['companydetail'] = $companydetail;	
		$result['companyProperty'] = $companyProperty;	
		$result['companyId'] = $myid;
		
		return view("companypropertylist", $title)->with('result', $result); 		
	}
	
	public function contactAgentSave(Request $request){
		if(Session::has('userName')){
			$contactAgent = new ContactAgent;
			$contactAgent->carId = $request->carId;
			$contactAgent->userId = session()->get('userId');
			$contactAgent->user_type = '3';
			$contactAgent->firstName = $request->firstName;
			$contactAgent->lastName = $request->lastName;
			$contactAgent->nationality = $request->nationality;
			$contactAgent->email = $request->email;
			$contactAgent->phone = $request->phone;
			$contactAgent->dateFrom = $request->dateFrom;
			$contactAgent->dateTo = $request->dateTo;
			$contactAgent->save();
			$lastId = $contactAgent->id;
			if($request->hasfile('upload_id')){
				foreach($request->file('upload_id') as $key=>$image){
					
					$uploadId = new UploadId();
					$uploadId->c_agentId = $lastId;
					$name=$image->getClientOriginalName();
					$filename = time()."_".$key."_".$name;
					$image->move('public/uploadId/', $filename);
					$uploadId->image = $filename;
					$uploadId->save();
				}
			}
			if($request->hasfile('driving_license')){
				foreach($request->file('driving_license') as $key=>$image){
					
					$driverLicense = new DriverLicense();
					$driverLicense->c_agentId = $lastId;
					$name=$image->getClientOriginalName();
					$filename = time()."_".$key."_".$name;
					$image->move('public/driverLicense/', $filename);
					$driverLicense->license = $filename;
					$driverLicense->save();
				}
			}
			return redirect('/rentalcar_detail/'.$request->carId);
		}
        else{
            return redirect()->route('login');
        }
	}
	public function showroomCarList(Request $request){ 
		
		$title = array('pageTitle' => Lang::get("website.Home"));
		$companyAdmins = DB::table('administrators')->join('properties','properties.companyId','=','administrators.myid','left')->select('administrators.*')->where('administrators.issubadmin',4)->where('properties.pro_type','=',2)->orderby('administrators.myid','DESC')->paginate(10);
		$city = DB::table('city')->groupBy('name')->get();

		$result = array();			
		$result['companyAdmins'] = $companyAdmins;	
		$result['city'] = $city;	
		
		return view("showroomcarlist", $title)->with('result', $result); 		
	}

	public function rentalCarList(Request $request){
		
		$title = array('pageTitle' => Lang::get("website.Home"));
		$companyAdmins = DB::table('administrators')->join('properties','properties.companyId','=','administrators.myid','left')->select('administrators.*')->where('administrators.issubadmin',4)->where('properties.pro_type','=',2)->orderby('administrators.myid','DESC')->paginate(10);
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
		// $products = DB::table('car_accessories')->join('car_accessories_img', 'car_accessories.id', '=', 'car_accessories_img.product_id')->select('car_accessories.*','car_accessories_img.img_name')->where('store_id',$request->id)->where('status',1)->Paginate(10);

		$result = array();			
		// $result['products'] = $products;	
		
		return view("contactus", $title)->with('result', $result); 	
	}

	public function carshowroom_detail(Request $request){
		$title = array('pageTitle' => Lang::get("website.Home"));
		// $products = DB::table('car_accessories')->join('car_accessories_img', 'car_accessories.id', '=', 'car_accessories_img.product_id')->select('car_accessories.*','car_accessories_img.img_name')->where('store_id',$request->id)->where('status',1)->Paginate(10);

		$result = array();			
		// $result['products'] = $products;	
		
		return view("carshowroom_detail", $title)->with('result', $result); 	
	}
	




	
	
}