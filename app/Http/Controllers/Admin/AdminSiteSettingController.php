<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Validator;
use App;
use Lang;
use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

//for requesting a value 
use Illuminate\Http\Request;

class AdminSiteSettingController extends Controller
{		
	public function slugify($slug){
		
	  // replace non letter or digits by -
	  $slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
	
	  // transliterate
	  if (function_exists('iconv')){
		$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
	  }
	
	  // remove unwanted characters
	  $slug = preg_replace('~[^-\w]+~', '', $slug);
	
	  // trim
	  $slug = trim($slug, '-');
	
	  // remove duplicate -
	  $slug = preg_replace('~-+~', '-', $slug);
	
	  // lowercase
	  $slug = strtolower($slug);
	
	  if (empty($slug)) {
		return 'n-a';
	  }
	
	  return $slug;
	}
	
	public function imageType(){	
		$extensions = array('gif','jpg','jpeg','png');	
		return $extensions;
	}
	
		
	//getlanguages
	public function getlanguages(){
		$languages = DB::table('languages')->get();
		return $languages;
	}
	
	//getsinglelanguages
	public function getSingleLanguages($language_id){
		$languages = DB::table('languages')->get();
		return $languages;
	}
	
	//languages
	public function languages(Request $request){
		if(session('language_view')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		$title = array('pageTitle' => Lang::get("labels.ListingLanguages"));		
		
		$result = array();
		
		$languages = DB::table('languages')
			->paginate(60);
		
		$result['languages'] = $languages;
		
		return view("admin.languages",$title)->with('result', $result);
		}
	}
	
	//addLanguages
	public function addlanguages(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddLanguage"));		
		return view("admin.addlanguages",$title);
	}
		
	//addNewLanguages	
	public function addnewlanguages(Request $request){
		if(session('language_create')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/language_flags/', $fileName);
			$uploadImage = 'resources/assets/images/language_flags/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		if($request->is_default=='1'){
			$orders_status = DB::table('languages')->where('is_default','=', 1)->update([				
				'is_default'	=>	0
				]);	
		}
		
		DB::table('languages')->insertGetId([
				'name'			=>	$request->name,
				'code'			=>	$request->code,
				'image'			=>	$uploadImage,
				'directory'		=>	$request->directory,
				'direction'		=>	$request->direction,
				'is_default'	=>	$request->is_default
				]);
								
		$message = Lang::get("labels.languageAddedMessage");
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	//editOrderStatus
	public function editlanguages(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditLanguage"));
		
		$languages = DB::table('languages')->where('languages_id','=', $request->id)->get();		
		$result['languages'] = $languages;
		
		return view("admin.editlanguages",$title)->with('result', $result);
	}
	
	//updateOrderStatus	
	public function updatelanguages(Request $request){
		if(session('language_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/language_flags/', $fileName);
			$uploadImage = 'resources/assets/images/language_flags/'.$fileName; 
		}	else{
			$uploadImage = $request->oldImage;
		}	
		
		if($request->is_default=='1'){
			$orders_status = DB::table('languages')->where('is_default','=', 1)->update([				
				'is_default'	=>	0
				]);	
		}
		
		$orders_status = DB::table('languages')->where('languages_id','=', $request->id)->update([
				'name'			=>	$request->name,
				'code'			=>	$request->code,
				'image'			=>	$uploadImage,
				'directory'		=>	$request->directory,
				'direction'		=>	$request->direction,
				'is_default'	=>	$request->is_default
				]);
		
		$message = Lang::get("labels.languageEditMessage");
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	
	//defaultLanguage	
	public function defaultlanguage(Request $request){	
		if(session('language_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$orders_status = DB::table('languages')->where('is_default','=', 1)->update([				
			'is_default'	=>	0
			]);		
		
		$orders_status = DB::table('languages')->where('languages_id','=', $request->languages_id)->update([
				'is_default'	=>	1
				]);		
		}
	}
	
	//deletelanguage
	public function deletelanguage(Request $request){
		if(session('language_delete')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		DB::table('languages')->where('languages_id', $request->id)->delete();		
		DB::table('categories_description')->where('language_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.languageDeleteMessage")]);
		}
	}

	
	//webSettings
	public function webSettings(Request $request){
		if(session('website_setting_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.setting"));		
		
		$result = array();
		
		$settings = DB::table('settings')->get();
		
		$result['settings'] = $settings;
		
		return view("admin.webSettings",$title)->with('result', $result);
		}
	}

	
	//seo
	public function seo(Request $request){
		if(session('general_setting_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		$title = array('pageTitle' => Lang::get("labels.SEO Content"));		
		
		$result = array();
		
		$settings = DB::table('settings')->get();
		
		$result['settings'] = $settings;
		
		return view("admin.seo",$title)->with('result', $result);
		}
	}
	
	//admobSettings
	public function admobSettings(Request $request){
		if(session('application_setting_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		
		$title = array('pageTitle' => Lang::get("labels.admobSettings"));		
		
		$result = array();
		
		$settings = DB::table('settings')->get();
		
		$result['settings'] = $settings;
		
		return view("admin.admobSettings",$title)->with('result', $result);
		}
	}

	
	//setting page
	public function alertSetting(Request $request){
		if(session('general_setting_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		$title = array('pageTitle' => Lang::get("labels.alertSetting"));		
		
		$result = array();
		
		$setting = DB::table('alert_settings')->get();
		
		$result['setting'] = $setting;
		
		return view("admin.alertSetting",$title)->with('result', $result);
		}
	}
	
	//alertSetting
	public function updateAlertSetting(Request $request){
		if(session('general_setting_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		$orders_status = DB::table('alert_settings')->where('alert_id','=', $request->alert_id)->update([
				'create_customer_email'				=>	$request->create_customer_email,
				'create_customer_notification'		=>	$request->create_customer_notification,
				'order_status_email'				=>	$request->order_status_email,
				'order_status_notification'			=>	$request->order_status_notification,
				'new_product_email'					=>	$request->new_product_email,
				'new_product_notification'			=>	$request->new_product_notification,
				'forgot_email'						=>	$request->forgot_email,
				'forgot_notification'				=>  $request->forgot_notification,
				'contact_us_email'					=>	$request->contact_us_email,
				'news_email'						=>	$request->news_email,
				'news_notification'					=>	$request->news_notification,
				'order_email'						=>	$request->order_email,
				'order_notification'				=>	$request->order_notification,
				]);
		
		$message = Lang::get("labels.alertSettingUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		}
	}
		

}
