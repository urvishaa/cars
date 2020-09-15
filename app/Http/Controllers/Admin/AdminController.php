<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Usergroup;
use App\ShowRoomAdmin;
use App\User;
use App\Car;
use App\Ads;
use Validator;
use App;
use Lang;

use App\Admin;

use DB;
//for password encryption or hash protected
use Hash;
//use App\Administrator;

//for authenitcate login data
use Auth;
use Session;
//for requesting a value 
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function dashboard(Request $request){
		$title 			  = 	array('pageTitle' => Lang::get("labels.title_dashboard"));
		$language_id      = 	'1';
		$result 		  =		array();
		
		// $usergroupCount = Usergroup::count();
		$ShowRoomAdmin = ShowRoomAdmin::where('issubadmin',2)->count();		
		$User =User::select('name')->count();
		$car = Car::count();
		$Ads = Ads::count();
		$AdsDash = Ads::get();
		$userdetail = User::orderBy('id', 'desc')->paginate(8);
		$cardetail = 	DB::table('car')->join('car_img','car_img.car_id','=','car.id','left')->select('car.*','car_img.img_name as image')->orderBy('car.id', 'desc')->groupBy('car.id')->paginate(5);   

		$reportBase		  = 	$request->reportBase;		
		return view("admin.dashboard",compact('User','userdetail','cardetail','car','Ads','AdsDash','ShowRoomAdmin'));
	}
	
	
	public function login(){ 
		if (Auth::check()) { 
		  return redirect('/admin/dashboard');
		}else{ 
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login",$title);
		}
	}
	
	public function admininfo(){
		$administor = administrators::all();		
		return view("admin.login",$title);
	}
	
	//login function
	public function checkLogin(Request $request){ 
		//echo "<pre>"; print_r($request->all()); die;
		$locale = $request->session()->put('locale', $request['language']); 
		$validator = Validator::make(
			array(
					'email'    => $request->email,
					'password' => $request->password
					
				), 
			array(
					'email'    => 'required | email',
					'password' => 'required',
				)
		);
		//check validation
		if($validator->fails()){ 
			return redirect('admin')->withErrors($validator)->withInput();
		}else{ 
			//check authentication of email and password
			$adminInfo = array("email" => $request->email, "password" => $request->password);
				
			if(auth()->guard('admin')->attempt($adminInfo)) { 
				$admin = auth()->guard('admin')->user();
				
				$administrators = DB::table('administrators')->where('myid', $admin->myid)->get();					
				if(!empty(auth()->guard('admin')->user()->adminType)){	
					if(auth()->guard('admin')->user()->adminType != '1'){
					$roles = DB::table('manage_role')->where('admin_type_id', auth()->guard('admin')->user()->adminType)->get();
					
					if(count($roles)>0){		
						$dashboard_view = $roles[0]->dashboard_view;	
				
					
					}else{
						$dashboard_view = '0';
						
						$categories_view = '0';
						$categories_create = '0';
						$categories_update = '0';
						$categories_delete = '0';
	
						}	
					}else{
						$dashboard_view = '1';
						
						$categories_view = '1';
						$categories_create = '1';
						$categories_update = '1';
						$categories_delete = '1';
						
		
					}		
					
				}else{
					$role = '';
				}
				
				session(['dashboard_view' => $dashboard_view]);
				
				session(['categories_view' => $categories_view]);
				session(['categories_create' => $categories_create]);
				session(['categories_update' => $categories_update]);
				session(['categories_delete' => $categories_delete]);

				$categories_id = '';
				//admin category role
				if(auth()->guard('admin')->user()->adminType != '1'){
					$categories_role = DB::table('categories_role')->where('admin_id', auth()->guard('admin')->user()->myid)->get();
					if(!empty($categories_role) and count($categories_role)>0){
						$categories_id = $categories_role[0]->categories_ids;
					}else{
						$categories_id = '';
					}
				}
				
				session(['categories_id' => $categories_id]);
				$admin = auth()->guard('admin')->user(); 

				 if($admin->issubadmin == "2" || $admin->issubadmin == "3" || $admin->issubadmin == "4")
				 {
					return redirect()->intended('admin/profile')->with('administrators', $administrators);
				 }	
				 else
				 {
				 	return redirect()->intended('admin/dashboard')->with('administrators', $administrators);
				 }
				
			}else{ //echo 55555; die;
				return redirect('admin')->with('loginError',Lang::get("labels.EmailPasswordIncorrectText"));
			}
			
		}
		
	}
	
	
	//logout
	public function logout(Request $request){ 
		$locale = $request->session()->put('locale', 'en'); 
		Auth::guard('admin')->logout();
		return redirect()->intended('admin');
	}
	
	//admin profile
	public function adminProfile(Request $request){ 
		
		$title = array('pageTitle' => Lang::get("labels.Profile"));		
		
		$result = array();

		$setCar = array();
		
		$countries = DB::table('countries')->get();
		$city = DB::table('city')->get();
		$zones = DB::table('zones')->where('zone_country_id', '=', auth()->guard('admin')->user()->country)->get();
		
		$cityid = DB::table('showroom_city')->where('admin_id',auth()->guard('admin')->user()->myid)->get();
        foreach ($cityid as $value) {
            $setCar[] = $value->city_id;
        }

		$result['countries'] = $countries;
		$result['zones'] = $zones;
		$result['city'] = $city;

		
		return view("admin.adminProfile",$title,compact('setCar'))->with('result', $result);
	}
	
	//updateProfile
	public function updateProfile(Request $request){
		
			
		$updated_at	= date('y-m-d h:i:s');
		
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/views/admin/images/admin_profile/', $fileName);
			$uploadImage = 'resources/views/admin/images/admin_profile/'.$fileName; 
		}	else{
			$uploadImage = $request->oldImage;
		}	
		
		$orders_status = DB::table('administrators')->where('myid','=', auth()->guard('admin')->user()->myid)->update([
				'first_name'	=>	$request->first_name,
				'last_name'		=>	$request->last_name,
				'email'			=>	$request->email,
				'address'		=>	$request->address,
				/*'state'			=>	$request->state,*/
				'zip'			=>	$request->zip,
				'country'		=>	$request->country,
				'phone'			=>	$request->phone,
				'image'			=>	$uploadImage,
				'updated_at'	=>	$updated_at
				]);
		
		foreach ($request->city as $value) {
            $cityid = DB::table('showroom_city')->insertGetId([
                'admin_id' => auth()->guard('admin')->user()->myid,
                'city_id' => $value
            ]);
        } 


		$message = Lang::get("labels.ProfileUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		//}
	}
	
	//updateProfile
	public function updateAdminPassword(Request $request){ 
		/*if(session('profile_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{*/ 
		$orders_status = DB::table('administrators')->where('myid','=', auth()->guard('admin')->user()->myid)->update([
				'password'		=>	Hash::make($request->password)
				]);
		
		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		//}
	}
	
	//admins
	public function admins(Request $request){
		if(session('manage_admins_view')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
		$language_id            				=   '1';			
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		$admins = DB::table('administrators')
			->leftJoin('countries','countries.countries_id','=', 'administrators.country')
			->leftJoin('zones','zones.zone_id','=', 'administrators.state')
			->leftJoin('admin_types','admin_types.admin_type_id','=','administrators.adminType')
			->select('administrators.*', 'countries.*', 'zones.*','admin_types.*')
			->where('email','!=','vectorcoder@gmail.com')
			->where('adminType','!=','1')
			->paginate(50);
			
				
		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['admins'] = $admins;
		
		return view("admin.admins",$title)->with('result', $result);
		}
	}

	public function downloads(){

		$android = 0;
		$ios = 0;
		
		$android = DB::table('userdevicetoken')->where('device',1)->count();

		$ios = DB::table('userdevicetoken')->where('device',2)->count();

		return view("admin.downloads",compact('android','ios'));
	}
	
	//add admins
	public function addadmins(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.addadmin"));	
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();
		
		$adminTypes = DB::table('admin_types')->where('isActive', 1)->where('admin_type_id','!=','1')->get();
		$result['adminTypes'] = $adminTypes;
		
		return view("admin.addadmins",$title)->with('result', $result);
		
	}

	//addnewadmin
	public function addnewadmin(Request $request){ 
		if(session('manage_admins_create')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		//get function from other controller
		$myVar = new AdminSiteSettingController();	
		$extensions = $myVar->imageType();			
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		//check email already exists
		$existEmail = DB::table('administrators')->where('email', '=', $request->email)->get();
		if(count($existEmail)>0){
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		}else{
			if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
				$image = $request->newImage;
				$fileName = time().'.'.$image->getClientOriginalName();
				$image->move('resources/views/admin/images/admin_profile/', $fileName);
				$uploadImage = 'resources/views/admin/images/admin_profile/'.$fileName; 
			}	else{
				$uploadImage = '';
			}		
			
			$customers_id = DB::table('administrators')->insertGetId([
						'user_name'		 		    =>   $request->first_name.'_'.$request->last_name.time(),
						'first_name'		 		=>   $request->first_name,
						'last_name'			 		=>   $request->last_name,
						'phone'	 					=>	 $request->phone,
						'address'   				=>   $request->address,
						/*'state'		   				=>   $request->state,*/
						'address'   				=>   $request->address,
						'country'		   			=>   $request->country,
						'zip'   					=>   $request->zip,
						'email'	 					=>   $request->email,
						'password'		 			=>   Hash::make($request->password),
						'isActive'		 	 		=>   $request->isActive,
						'image'	 					=>	 $uploadImage,
						'adminType'					=>	 $request->adminType
						]);
					
			
			$message = Lang::get("labels.New admin has been added successfully");
			return redirect()->back()->with('message', $message);
		}
		}
	}
	
	//editadmin
	public function editadmin(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditAdmin"));
		$myid        	 =   $request->id;			
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		//get function from other controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();
		
		$adminTypes = DB::table('admin_types')->where('isActive', 1)->where('admin_type_id','!=','1')->get();
		$result['adminTypes'] = $adminTypes;
		
		$result['myid'] = $myid;
		
		$admins = DB::table('administrators')->where('myid','=', $myid)->get();
		$zones = DB::table('zones')->where('zone_country_id','=', $admins[0]->country)->get();
		
		if(count($zones)>0){
			$result['zones'] = $zones;
		}else{
			$zones = new \stdClass;
			$zones->zone_id = "others";
			$zones->zone_name = "Others";
			$result['zones'][0] = $zones;
		}
		
		
		$result['admins'] = $admins;
		return view("admin.editadmin",$title)->with('result', $result);
	}
	
	//update admin
	public function updateadmin(Request $request){
		if(session('manage_admins_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		//get function from other controller
		$myVar = new AdminSiteSettingController();	
		$extensions = $myVar->imageType();			
		$myid = $request->myid;
		$result = array();
		$message = array();
		$errorMessage = array();
		
		//check email already exists
		$existEmail = DB::table('administrators')->where([['email','=',$request->email],['myid','!=',$myid]])->get();
		if(count($existEmail)>0){
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		}else{
			
			if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
				$image = $request->newImage;
				$fileName = time().'.'.$image->getClientOriginalName();
				$image->move('resources/views/admin/images/admin_profile/', $fileName);
				$uploadImage = 'resources/views/admin/images/admin_profile/'.$fileName; 
			}	else{
				$uploadImage = $request->oldImage;
			}		
			
			$admin_data = array(
				'first_name'		 		=>   $request->first_name,
				'last_name'			 		=>   $request->last_name,
				'phone'	 					=>	 $request->phone,
				'address'   				=>   $request->address,
				'city'		   				=>   $request->city,
				/*'state'		   				=>   $request->state,*/
				'address'   				=>   $request->address,
				'country'		   			=>   $request->country,
				'zip'   					=>   $request->zip,
				'email'	 					=>   $request->email,
				'isActive'		 	 		=>   $request->isActive,
				'image'	 					=>	 $uploadImage,
				'adminType'	 				=>	 $request->adminType,
			);
			
			if($request->changePassword == 'yes'){
				$admin_data['password'] = Hash::make($request->password);
			}
			
			$customers_id = DB::table('administrators')->where('myid', '=', $myid)->update($admin_data);
					
			
			$message = Lang::get("labels.Admin has been updated successfully");
			return redirect()->back()->with('message', $message);
		}
		}
	}
	
	//deleteProduct
	public function deleteadmin(Request $request){
		if(session('manage_admins_delete')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		$myid = $request->myid;
		
		DB::table('administrators')->where('myid','=', $myid)->delete();
		
		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminMessage")]);
		}
	}
	
	//manageroles
	public function manageroles(Request $request){
		if(session('admintype_view')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.manageroles"));
		$language_id            				=   '1';			
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		$adminTypes = DB::table('admin_types')->where('admin_type_id','!=',1)->paginate(50);			
				
		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['adminTypes'] = $adminTypes;
		
		return view("admin.manageroles",$title)->with('result', $result);
		}
	}
	
	
	//add admins type
	public function addadmintype(Request $request){
		$title = array('pageTitle' => Lang::get("labels.addadmintype"));	
		
		$result = array();
		$message = array();
		$errorMessage = array();
		
		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();
		
		$adminTypes = DB::table('admin_types')->where('isActive', 1)->get();
		$result['adminTypes'] = $adminTypes;
		
		return view("admin.addadmintype",$title)->with('result', $result);
	}
	
	//addnewtype
	public function addnewtype(Request $request){
		if(session('admintype_create')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{				
		$result = array();
		$message = array();
		$errorMessage = array();
		
		$customers_id = DB::table('admin_types')->insertGetId([
						'admin_type_name'	 		=>   $request->admin_type_name,
						'created_at'			 	=>   time(),
						'isActive'		 	 		=>   $request->isActive,
						]);
								
		$message = Lang::get("labels.Admin type has been added successfully");
		return redirect()->back()->with('message', $message);	
		}
	}

	public function setting(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.setting"));
		$result = array();		
		// $result['message'] = array();
		
		// //get function from other controller
		// $myVar = new AdminSiteSettingController();
		// $result['languages'] = $myVar->getLanguages();
		
		$settingall = DB::table('settings')->select('*')->get();

		if(count($settingall > 0))
		{
				$description = DB::table('settings')->where([
					['id', '=', $languages_data->languages_id],
					['online_url', '=', $request->id],
					['id', '=', $languages_data->languages_id],
					['online_url', '=', $request->id],
					['id', '=', $languages_data->languages_id],
				])->get();
		}
		// 	id	
			
		// online_url	
		// access_code	
		// merchantTxnref	
		// merchantId
		else
		{
				$customers_id = DB::table('settings')->insertGetId([
					'admin_type_name'	 		=>   $request->admin_type_name,
					'created_at'			 	=>   time(),
					'isActive'		 	 		=>   $request->isActive,
					'admin_type_name'	 	=>   $request->admin_type_name,
					'created_at'			 	=>   time(),
					'isActive'		 	 		=>   $request->isActive,
					]);
		}
		
		// $description_data = array();		
		// foreach($result['languages'] as $languages_data){

		
			
			
	
		// $result['description'] = $description_data;	
		// $result['editCategory'] = $editCategory;		
		
		return view("admin.setting", $title)->with('result', $result);
	}

	public function updatesetting(Request $request){

	
		// echo "<pre>";
		// print_r($_POST);
		// $request->merchant_txn_ref; exit;
		// if(session('admintype_update')==0){
		// 	print Lang::get("labels.You do not have to access this route");
		// }else{					
		// $result = array();
		// $message = array();
		// $errorMessage = array();
		
		// $customers_id = DB::table('admin_types')->where('admin_type_id',$request->admin_type_id)->update([
		// 				'admin_type_name'	 		=>   $request->admin_type_name,
		// 				'updated_at'			 	=>   time(),
		// 				'isActive'		 	 		=>   $request->isActive,
		// 				]);
					
			
		// $message = Lang::get("labels.Admin type has been updated successfully");
		// return redirect()->back()->with('message', $message);
		// }
	}
	
	
	//editadmintype
	public function editadmintype(Request $request){
		$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
		$admin_type_id        	 =   $request->id;			
		
		$result = array();
		
		$result['admin_type_id'] = $admin_type_id;
		
		$admin_types = DB::table('admin_types')->where('admin_type_id','=', $admin_type_id)->get();
		
		$result['admin_types'] = $admin_types;
		return view("admin.editadmintype",$title)->with('result', $result);
	}

	//updatetype
	public function updatetype(Request $request){
		if(session('admintype_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{					
		$result = array();
		$message = array();
		$errorMessage = array();
		
		$customers_id = DB::table('admin_types')->where('admin_type_id',$request->admin_type_id)->update([
						'admin_type_name'	 		=>   $request->admin_type_name,
						'updated_at'			 	=>   time(),
						'isActive'		 	 		=>   $request->isActive,
						]);
					
			
		$message = Lang::get("labels.Admin type has been updated successfully");
		return redirect()->back()->with('message', $message);
		}
	}
	
	
	//deleteProduct
	public function deleteadmintype(Request $request){
		if(session('admintype_delete')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{	
		$admin_type_id = $request->admin_type_id;
		
		DB::table('admin_types')->where('admin_type_id','=', $admin_type_id)->delete();
		
		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminTypeMessage")]);
		}
	}

	
	
	
}
