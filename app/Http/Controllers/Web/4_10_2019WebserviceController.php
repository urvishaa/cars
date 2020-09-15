<?php 

namespace App\Http\Controllers\Web;

use Validator;
use DB;
use Hash;
use Auth;
use Carbon;
use Session;
use Lang;
use App;

use App\User;
use App\Property;
use App\Pro_feature;
use App\Property_img;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class WebserviceController extends Controller
{

  public function registration(Request $request)  //api registration
  { 
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);    

        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        try
        {           
            $device=$post['device'];
            $deviceToken=$post['deviceToken'];
            $username=$post['username'];
            $email=$post['email'];
            $password=$post['password'];
            $confirmPassword=$post['confirmPassword'];
           
            if ($password != $confirmPassword) {
                $response = array('success' => 0, 'message' => trans('labels.passwordAndConfirmPasswordSame') );
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            
            if((!isset($device)) || (!isset($deviceToken)) || (!isset($email)) || (!isset($password)) || (!isset($confirmPassword)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            if((empty($device)) || (empty($deviceToken)) || (empty($email)) || (empty($password)) || (empty($confirmPassword)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            $checkusername = DB::table('users')->select('*')->where('username','=',$username)->first();
            if (!empty($checkusername)) {
                $response = array('success' => 0, 'message' => trans('labels.usernameAlreadyExisting'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            $checkemail = DB::table('users')->select('*')->where('email','=',$email)->first();     
            if (!empty($checkemail)) {
                $response = array('success' => 0, 'message' => trans('labels.emailAlreadyExisting'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }            
              
            $user_id = DB::table('users')->insertGetId([
                'name' => $username,
                'username' => $username,
                'email'=> $email,
                'password'=> md5($password),
                'gender'=> "",
                'device'=> $device,
                'deviceToken'=> $deviceToken
            ]);          
                   
            $results = DB::table('users')->select('*')->where('id','=',$user_id)->first();        

              if(!empty($results))
              {
                $result = array();
                $result['userId'] = $results->id;
                $result['firstname'] = $results->name;
                $result['lastName'] = $results->lname;
                $result['phone'] = $results->phone;
                $result['username'] = $results->username;
                $result['email'] = $results->email;
                
                  if ($results->image != "") {
                      $result['profileImage']=$new.'/public/profileImage/'.$results->image;  
                  } else {
                      $result['profileImage']= $new.'/public/default-image.jpeg';  
                  }               
                  
                  $result['gender'] = "";                   
                  $result['dob'] = $results->dob;             
               
                  $result['address'] = $results->address;

                  $response = array('success' => 1, 'message' => trans('labels.userRegisteredSucceessfully'),'result' => $result );
                  echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

              }
                      
        }
        catch(Exception $e){

          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   

  }

   public function deviceToken(Request $request)
  {
      $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);    
        // echo "<pre>"; print_r($post); die;
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        try
        {           
            $userId=$post['userId'];
            $device=$post['device'];
            $deviceToken=$post['deviceToken'];
            
            
            if((!isset($device)) || (!isset($deviceToken)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            if((empty($device)) || (empty($deviceToken)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            $check_deviceToken = DB::table('userdevicetoken')->select('*')->where('deviceToken','=',$deviceToken)->first();      
                  //echo "<pre>"; print_r($check_deviceToken); die;
              if (isset($check_deviceToken->deviceToken) != $deviceToken) {       
                if ($userId != "") {
                  
                  $device_id = DB::table('userdevicetoken')->where('userId',$userId)->update([
                    //'userId'=> $userId ? $userId : '',
                      'device'=> $device,
                      'deviceToken'=> $deviceToken
                  ]);   
                } else {
                

                  $device_id = DB::table('userdevicetoken')->insertGetId([
                    'userId'=> $userId ? $userId : '',
                    'device'=> $device,
                    'deviceToken'=> $deviceToken
                ]);             
                  } 
              }
            
                  $response = array('success' => 1, 'message' => trans('labels.addDeviceTokenSucceessfully') );
                  echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }
        catch(Exception $e){

          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
  
  } 

  public function applogin(Request $request)   //for login user with username and email
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
          if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        try
        {           
            if((!isset($post['device'])) || (!isset($post['deviceToken'])) || (!isset($post['email'])) || (!isset($post['password'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }
            
            if($post['device'] == '' || $post['device'] == '0' || $post['email'] == '' || $post['email'] == '0' || $post['password'] == '')
            {
              $response = array('success' => 0, 'message' => trans('labels.errorPostData'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            
            $email = $post['email'];
            $password=  md5($post['password']);

            $results = DB::table('users')->select('*')->where('email','=',$email)->where('password','=',$password)->first();        
          
            if(!empty($results))
            {

                $result = array();
                $userID = $results->id;
                $result['userId'] = "$userID";
                $result['firstname'] = $results->name;
                $result['lastName'] = $results->lname;
                $result['phone'] = $results->phone;
                $result['username'] = $results->username;
                $result['email'] = $results->email;
                
                  if ($results->image != "") {
                      $result['profileImage']=$new.'/public/profileImage/'.$results->image;  
                  } else {
                      $result['profileImage']= $new.'/public/default-image.jpeg';  
                  }
                
                  if($results->gender == 1){
                    $result['gender'] = "Male";
                  } else {
                    $result['gender'] = "Female";
                  }                
                  $result['dob'] = $results->dob;
                  $result['address'] = $results->address;

                  $cafeteria = DB::table('users')->where('id','=',$userID)->update([
                    'device'=> $post['device'],
                    'deviceToken'=> $post['deviceToken']
                ]);
                  
                $response = array('success' => 1, 'message' => trans('labels.successfullyLoggedIn') ,'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.invalidEmailOrPassword'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function editProfile(Request $request)   // edit user profile
  {

        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);

        if(empty($decode->language))
        {
          $post['language']='en';
        }


      
        App::setLocale($decode->language);  
        try
        {           
            if((empty($decode->userId)) || (empty($decode->firstName)) || (empty($decode->lastName)) || (empty($decode->phone)) || (empty($decode->address)) || (empty($decode->birthDate)))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }
            
            $results = DB::table('users')->select('*')->where('id','=',$decode->userId)->first();        
          
            if(!empty($results))
            {
                
                if(!empty($post['image']))
                {   
                    $file = $request->file('image'); 
                    $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                    $picture = time() . "." . $image_name;
                    $destinationPath = public_path('profileImage/');
                    $file->move($destinationPath, $picture); 

                    $user =DB::table('users')->where('id',$results->id)->update([
                        'image'     =>   $picture
                    ]);
                }

                $cafeteria = DB::table('users')->where('id','=',$decode->userId)->update([
                  'name'    =>  $decode->firstName,
                  'lname'     =>   $decode->lastName,
                  'dob'    =>  $decode->birthDate,
                  'phone'     =>   $decode->phone,
                  'address'    =>  $decode->address           
                ]);  

                   $results = DB::table('users')->select('*')->where('id','=',$decode->userId)->first();        
          
                  if(!empty($results))
                  {
                      $result = array();
                      $userID = $results->id;
                      $result['userId'] = "$userID";
                      $result['firstname'] = $results->name;
                      $result['lastName'] = $results->lname;
                      $result['phone'] = $results->phone;
                      $result['username'] = $results->username;
                      $result['email'] = $results->email;
                      
                        if ($results->image != "") {
                            $result['profileImage']=$new.'/public/profileImage/'.$results->image;  
                        } else {
                            $result['profileImage']= $new.'/public/default-image.jpeg';  
                        }
                      
                        if($results->gender == 1){
                          $result['gender'] = "Male";
                        } else {
                          $result['gender'] = "Female";
                        }                
                        $result['dob'] = $results->dob;
                        $result['address'] = $results->address;                   
                   
                  
                      $response = array('success' => 1, 'message' => trans('labels.profileUpdateSuccessfully') , 'result' => $result);
                      echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
                  } 
                  else
                  {
                    $response = array('success' => 0, 'message' => trans('labels.profileNotUpdateSuccessfully'));
                    echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
                  }
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.profileNotUpdateSuccessfully'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function passwordForgot(Request $request) // api forget password
  { 

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);        
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        try
        {      
            if((!isset($post['email'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
            }  

            $email = $post['email'];
            $results = DB::table('users')->select('*')->where('email','=',$email)->first();            
            if(!empty($results))
            {             
                $sendmail=array();                
                $sendmail['userId'] = $results->id;
                $id= $sendmail['userId'];
                $sendmail['name'] = $results->name;
                $sendmail['email'] = $results->email;
                $subject = "Forgot Password";
                $header="";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html\r\n";
                $message ="";
                $message .= "Hello ".$results->name."<br>";
                $message .= "You are requested to change password Click bellow link to reset that password<br>";
                $message .= '<a href='.$new.'ForgotPassword/'.$id.'>click here</a>';
               
                mail($sendmail['email'],$subject,$message,$header);                 
            
                $response = array('success' => 1, 'message' => trans('labels.youWillShortlyReceiveLinkToResetPassword'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit; 
            
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.emailNotRegisteredWithSystem'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }
    
  }

  public function chnagePassword(Request $request) // api change password
  { 

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);        
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        try
        {      

            if((empty($post['userId'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
            } 
            if((empty($post['password'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
            }  

            if((empty($post['confirmPassword'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
            } 

            if($post['confirmPassword'] != $post['password']) 
            {
              $response = array('success' => 0, 'message' => trans('labels.passwordAndConfirmPasswordSame'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
            } 
            
            $results = DB::table('users')->select('*')->where('id','=',$post['userId'])->first();            
            if(!empty($results))
            {   
                $results = DB::table('users')->where('id','=',$post['userId'])->update([
                    'password'    =>  md5($post['password']) 
                ]); 
                $response = array('success' => 1, 'message' => trans('labels.passwordUpdateSuccessfully'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;            
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.passwordNotUpdate'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }
    
  }

  public function allCarList(Request $request)  // All Car List for userType == 1 and only for user
  {
      
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);  


        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);          

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $data = DB::table('properties');
            $data->join('property_category','property_category.id','=','properties.prop_category','left');
            $data->join('car_brand','car_brand.id','=','properties.car_brand','left');
            $data->join('property_types','property_types.id','=','properties.pro_type','left');
            $data->join('fueltype','fueltype.id','=','properties.fueltype','left') ;      
            $data->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename','fueltype.name as fueltypeName');

	          if(!empty($post['city']))
	          {
	            $data->where('properties.city','=',$post['city']);
	          }

	          if(!empty($post['type']))
	          {
	            $data->where('properties.pro_type',$post['type']);
	          }

	          if(!empty($post['carBrand']))
	          {
	            $data->where('properties.car_brand',$post['carBrand']);
	          }

	          if(!empty($post['year']))
	          {
	            $data->where('properties.year_of_car',$post['year']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data->where('properties.sale_price','>=',$post['minPrice']);
	            $data->where('properties.sale_price','<=',$post['maxPrice']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data->where('properties.month_rentprice','>=',$post['minPrice']);
	            $data->where('properties.month_rentprice','<=',$post['maxPrice']);
	          }          


            $data->where('properties.published',1);
            $data->orderby('properties.id','DESC');
            $data->offset($post['startLimit']);           
            $data->limit(10);
            $results = $data->get();

            $data1 = DB::table('properties');
            $data1->join('property_category','property_category.id','=','properties.prop_category','left');
            $data1->join('car_brand','car_brand.id','=','properties.car_brand','left');
            $data1->join('property_types','property_types.id','=','properties.pro_type','left');
            $data1->join('fueltype','fueltype.id','=','properties.fueltype','left') ;     
            $data1->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename','fueltype.name as fueltypeName');

	          if(!empty($post['city']))
	          {
	            $data1->where('properties.city','=',$post['city']);
	          }

	          if(!empty($post['type']))
	          {
	            $data1->where('properties.pro_type',$post['type']);
	          }

	          if(!empty($post['carBrand']))
	          {
	            $data1->where('properties.car_brand',$post['carBrand']);
	          }

	          if(!empty($post['year']))
	          {
	            $data1->where('properties.year_of_car',$post['year']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data1->where('properties.sale_price','>=',$post['minPrice']);
	            $data1->where('properties.sale_price','<=',$post['maxPrice']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data1->where('properties.month_rentprice','>=',$post['minPrice']);
	            $data1->where('properties.month_rentprice','<=',$post['maxPrice']);
	          }          


            $data1->where('properties.published',1);
            $data1->orderby('properties.id','DESC');      
        
            $results1 = $data1->get();
            $countdata = $data1->count();
  			   
            if(!empty($results))
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['name'] = $value->property_name;
                   
                   
                   

                    if(!empty($value->car_brand))
                    {
                      $result['carBrandId'] = $value->car_brand;
                    }
                    else
                    {
                      $result['carBrandId'] = '0';
                    }

                    if(!empty($value->carBrand))
                    {
                       $result['carBrand'] = $value->carBrand;
                    }
                    else
                    {
                      $result['carBrand'] = '';
                    }

                    if(!empty($value->catid))
                    {
                       $result['modelId'] = (string)$value->catid;
                    }
                    else
                    {
                       $result['modelId'] = '0';
                    }



                    $result['carModel'] = $value->procategory;
                    $result['address'] = $value->address;                   
                    $result['kilometer'] = $value->kilometer;
                    $result['salePrice'] = $value->sale_price;
                    $result['monthRent'] = $value->month_rentprice;
                    $result['description'] = $value->description;
                    $result['userId'] = $value->userId;
                    $result['showRoomId'] = $value->showRoomId;
                    $result['typeId'] = $value->typeid;
                    $result['carType'] = $value->typename;                    
                    $result['fueltypeName'] = $value->fueltypeName;           

                    $result['location'] = $value->googleLocation;
                    $result['lat'] = $value->lat;
                    $result['long'] = $value->lng;
                    $result['isrequested'] = $value->isrequested;
                    $result['published'] = $value->published;
                    $result['distance'] = "50";
                

                      if($value->typeid==1)
                      {
                        $result['price'] = $value->sale_price;
                      }
                      else
                      {
                        $result['price'] = $value->month_rentprice;
                      }
                 
                      $images=  DB::table('property_img')->select()->where('property_id',$value->id)->first(); 

                      if(!empty($images))
                      {
                        $result['image'] = $new.'/public/propertyImage/'.$images->img_name;
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                      
                } 

                $response = array('success' => 1, 'message' => trans('labels.propertySuccessfully') ,'totalCount' => $countdata ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function userCarList(Request $request)  // user Car List for userType == 1 and only for user //login user
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  

        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        if(empty($post['userId']))
        {           
            $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        // if(empty($post['latitude']))
        // {           
        //   $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
        //   echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        // }

        // if(empty($post['longitude']))
        // {           
        //   $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
        //   echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        // }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $results = DB::table('properties')->join('fueltype','fueltype.id','=','properties.fueltype','left')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename','fueltype.name as fueltypeName')->where('properties.userType',1)->where('properties.userId',$post['userId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
            //echo "<pre>"; print_r($results); die;

            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['userId'] = $value->userId;
                    $result['carBrandId'] = $value->car_brand;
                    $result['carBrand'] = $value->carBrand;
                    $result['name'] = $value->property_name;
                    $result['address'] = $value->address;
                    $result['kilometer'] = $value->kilometer;
                    $result['fueltypeName'] = $value->fueltypeName;   
                    $result['salePrice'] = $value->sale_price;
                    $result['monthRent'] = $value->month_rentprice;
                    $result['description'] = $value->description;
                    $result['typeId'] = $value->typeid;
                    $result['categoryId'] = $value->catid;
                    $result['carType'] = $value->typename;
                    $result['carModel'] = $value->procategory;
                    $result['location'] = $value->googleLocation;
                    $result['lat'] = $value->lat;
                    $result['long'] = $value->lng;
                    $result['location'] = $value->googleLocation;
                    $result['isrequested'] = $value->isrequested;
                    $result['published'] = $value->published;
                

                      if($value->typeid==1)
                      {
                        $result['price'] = $value->sale_price;
                       
                      }
                      else
                      {
                        $result['price'] = $value->month_rentprice;
                      }
                 
                      $images=  DB::table('property_img')->select()->where('property_id',$value->id)->first(); 

                      if($images != "")
                      {
                        $result['image'] = $new.'/public/propertyImage/'.$images->img_name;
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.propertySuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function adminCarList(Request $request)  // admin car List for userType == 2 and only for adminshowroom
  {
   
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

         if(empty($post['adminId']))
        {           
            $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        // if(empty($post['latitude']))
        // {           
        //   $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
        //   echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        // }

        // if(empty($post['longitude']))
        // {           
        //   $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
        //   echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        // }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            


            $results = DB::table('properties')->join('fueltype','fueltype.id','=','properties.fueltype','left')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename','fueltype.name as fueltypeName')->where('properties.userType',2)->where('properties.showRoomId',$post['adminId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
              //echo "<pre>"; print_r($results); die;
            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['showRoomId'] = $value->showRoomId;
                    $result['carBrandId'] = $value->car_brand;
                    $result['carBrand'] = $value->carBrand;
                    $result['name'] = $value->property_name;
                    $result['fueltypeName'] = $value->fueltypeName;  
                    $result['address'] = $value->address;
                    $result['salePrice'] = $value->sale_price;
                    $result['monthRent'] = $value->month_rentprice;
                    $result['description'] = $value->description;
                    $result['typeId'] = $value->typeid;
                    $result['carType'] = $value->typename;
                    $result['categoryId'] = $value->catid;
                    $result['carModel'] = $value->procategory;
                    $result['location'] = $value->googleLocation;
                    $result['lat'] = $value->lat;
                    $result['long'] = $value->lng;
                    $result['location'] = $value->googleLocation;
                    $result['published'] = $value->published;
                

                      if($value->typeid==1)
                      {
                        $result['price'] = $value->sale_price;
                       
                      }
                      else
                      {
                        $result['price'] = $value->month_rentprice;
                      }
                 
                      $images=  DB::table('property_img')->select()->where('property_id',$value->id)->first(); 

                      if(!empty($images))
                      {
                        $result['image'] = $new.'/public/propertyImage/'.$images->img_name;
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.propertySuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function adminShowroomList(Request $request)  // admin List for userType == 2 and only for adminshowroom
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
      
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            $ress = DB::table('administrators');
            $ress->where('issubadmin',2);
              if(!empty($post['city']))
              {           
                $ress->where('city',$post['city']);
              }
            $ress->orderby('myid','DESC');
            $ress->offset($post['startLimit']);
            $ress->limit(10);
            $results = $ress->get();

            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {  
                    $result['id'] = $value->myid;
                    $result['firstName'] = $value->first_name;
                    $result['lastName'] = $value->last_name;
                    $result['email'] = $value->email;
                    $result['phone'] = $value->phone;
                    $result['image'] = $value->image;
                     $result['share'] = $new."/showroomList/".$value->myid;                 

                      if($value->image != '')
                      {
                        $result['image'] =url($value->image);
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.adminSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }
  
  public function carDetail(Request $request) //car Deatil
  {
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);        
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        try
        {   
            if(empty($post['startLimit']))
            {
              $post['startLimit']='0';
            }
            if( (empty($post['carId'])) )
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            
            $results = DB::table('properties')->select('properties.*','car_brand.name as carBrand','car_brand.id as carbrandId','property_types.name as typename','property_category.name as modelName','property_category.id as modelId','fueltype.name as fueltypeName','fueltype.id as fueltypeId','city.name as cityName','city.id as cityId')
              ->join('car_brand','car_brand.id','=','properties.car_brand','left')
              ->join('city','city.id','=','properties.city','left')
              ->join('fueltype','fueltype.id','=','properties.fueltype','left')
              ->join('property_types','properties.pro_type','=','property_types.id','left')
              ->join('property_category','properties.prop_category','=','property_category.id','left')
              ->where('properties.id',$post['carId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->first();
            // echo "<pre>"; print_r($results); die;
            if(!empty($results))
            { 
              $re= array();
              $result = array();        
               
                //foreach($results as $value)
                //{ 
                    $users = DB::table('users')->select('*')->where('id', $results->userId)->first();
                    $showRoomAdmin = DB::table('administrators')->select('*')->where('myid', $results->showRoomId)->first();
                                                       
                      if (!empty($users)) { 
                        $user['userName'] = $users->name;  
                        $user['userEmail'] = $users->email;
                        $user['userAddress'] = $users->address;
                        if (!empty($users->image)) {
                          $user['profileImage'] = $new.'/public/profileImage/'.$users->image;  
                        } else {
                          $user['profileImage'] = $new.'/public/default-image.jpeg';  
                        }

                      } 
                      if(!empty($showRoomAdmin)) {

                        $user['userName'] = $showRoomAdmin->first_name.' '.$showRoomAdmin->last_name;  
                        $user['userEmail'] = $showRoomAdmin->email;
                        $user['userAddress'] = $showRoomAdmin->address;
                        if (!empty($showRoomAdmin->image)) {
                          $user['profileImage'] = $new.'/'.$showRoomAdmin->image;  
                        } else {
                          $user['profileImage'] = $new.'/public/default-image.jpeg';  
                        }
                      }                      

                      $result['id'] = (string)$results->id;
                      $result['share'] = $new."/car_Detail/".$results->id;                     
                      $result['carbrandId'] = $results->carbrandId;
                      $result['carBrand'] = $results->carBrand;
                      $result['cityId'] = $results->cityId;
                      $result['city'] = $results->cityName;
                      $result['fueltypeId'] = $results->fueltypeId;
                      $result['fueltype'] = $results->fueltypeName;
                      $result['modelId'] = $results->modelId; 
                      $result['model'] = $results->modelName;                    
                      $result['year'] = $results->year_of_car;                      
                      $result['name'] = $results->property_name;
                      $result['address'] = $results->address;      
                      $result['kilometer'] = $results->kilometer;      
                      if($results->pro_type ==1)
                      {
                        $result['price'] = $results->sale_price;
                      } 
                      else
                      {
                        $result['price'] = $results->month_rentprice;
                      }                             
                      $result['description'] = $results->description;
                      $result['typeId'] = $results->pro_type;
                      $result['type'] = $results->typename;
                   
                      $result['location'] = $results->googleLocation;
                      $result['address'] = $results->address;
                      $result['latitude'] = $results->lat;
                      $result['longitude'] = $results->lng;
                      $result['userId'] = $results->userId;
                      $result['showRoomId'] = $results->showRoomId;
                      $result['email'] = $results->email;
                      $result['phone'] = $results->phone;   
                      $result['isrequested'] = $results->isrequested;
                      $result['published'] = $results->published;          


                    $images_name =  DB::table('property_img')->select('*')->where('property_id', $results->id)->first();

                    if(!empty($images_name))
                    {
                        $proimg = $new.'/public/propertyImage/'.$images_name->img_name;
                        $result['carFirstImg'] = $proimg;
                    }
                    else
                    {
                       $result['carFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('property_img')->select('*')->where('property_id', $results->id)->get();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/propertyImage/'.$value1->img_name;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['carImage'] = $img;
                    }
                    else 
                    { 
                      $result['carImage'] = array();
                    }         
                    $re[]=$result;
                //}

                $response = array('success' => 1, 'message' => trans('labels.propertySuccessfully'),'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {

              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
  
        }
        catch(Exception $e)
        {

            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function addCar(Request $request)  // add & edit cars
  { 
        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);
        /*echo "<prE>"; print_r($decode); 
        echo "<prE>"; print_r($request->images); die;*/
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        try
        {    
            if((empty($post)) || (empty($decode->brand)) ||  (empty($decode->type)) || (empty($decode->userId)) || (empty($decode->model)) || (empty($decode->kilometer)) || (empty($decode->description))  || (empty($decode->location)) || (empty($decode->price)) ||  (empty($decode->fueltype)) || (empty($decode->city)) || (empty($decode->email))  || (empty($decode->phone)) || (!isset($decode->carId)) || (!isset($decode->year)) )
            { 
                $response = array();
                $response['success'] = 0;
                $response['message'] = trans('labels.pleasefillallrequired');
                echo json_encode($response);exit;
            } 

            if (empty($decode->carId)) {  
            	$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
              if($decode->type==1)  
              {                
              	$property_img = new Property([
                    'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'property_name'=> $car_brand->name,  
                    'car_brand'=> $decode->brand,  
                    'prop_category'=> $decode->model ? $decode->model : '' ,  
                    'kilometer'=> $decode->kilometer ? $decode->kilometer : '' ,  
                    'fueltype' =>$decode->fueltype ? $decode->fueltype : '' ,
                    'city' =>$decode->city ? $decode->city : '' ,
                    'description'=> $decode->description ? $decode->description : '' ,  
                    'address' => $decode->location ?  $decode->location :'',  
                    'googleLocation' => $decode->location ?  $decode->location :'', 
                    'sale_price'=> $decode->price ? $decode->price : '',                       
                    'email'=> $decode->email ? $decode->email : '',
                    'phone'=> $decode->phone ?  $decode->phone : '' ,
                    'published'=> $decode->published ?  $decode->published : '', 
                    'userType' => '1', 
                    'year_of_car'=>$decode->year,
				]);
              }                        
              else
              {    
                $property_img = new Property([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'property_name'=> $car_brand->name, 
                    'car_brand'=> $decode->brand,  
                    'prop_category'=> $decode->model ? $decode->model : '' ,  
                    'kilometer'=> $decode->kilometer ? $decode->kilometer : '' ,  
                    'fueltype' =>$decode->fueltype ? $decode->fueltype : '' ,  
                    'city' =>$decode->city ? $decode->city : '' ,
                    'description'=> $decode->description ? $decode->description : '' ,  
                    'address' => $decode->location ?  $decode->location :'',  
                    'googleLocation' => $decode->location ?  $decode->location :'', 
                    'month_rentprice'=> $decode->price ? $decode->price : '',                       
                    'email'=> $decode->email ? $decode->email : '',
                    'phone'=> $decode->phone ?  $decode->phone : '' ,
                    'published'=> $decode->published ?  $decode->published : '', 
                    'userType' => '1', 
                    'year_of_car'=>$decode->year,
                ]);                      
              }   

              $property_img->save();                  
              $proid = DB::getPdo()->lastInsertId();       
              $files = $request->file('images');    
              if (!empty($files)) {
                foreach($files as $file){
                    $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                    $picture = time() . "." . $image_name;
                    $destinationPath = public_path('propertyImage/');
                    $file->move($destinationPath, $picture);
    
                    $property_img = new Property_img([
                        'property_id' => $proid,
                        'img_name'=> $picture,
                    ]);
        
                      $property_img->save();
                }
              }
               
              $car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
              $car_model = DB::table('property_category')->select('*')->where('id', $decode->model)->first();
              $propr_type = DB::table('property_types')->select('*')->where('id', $decode->type)->first();
              $users = DB::table('users')->select('*')->where('id', $decode->userId)->first();
              $results = DB::table('properties')->select('*')->where('id', $proid)->first();
             
              if (isset($results)) {
                  
                  $result['Id'] = (string)$results->id;
                  $result['carBrand'] = $car_brand->name;
                  $result['carModel'] = $car_model->name;
                  $result['location'] = $results->googleLocation;   
                  $result['address'] = $results->address;   
                  if($results->pro_type=="1")
                  {
                    $result['price'] = $results->sale_price;
                  } 
                  else
                  {
                     $result['price'] = $results->month_rentprice;
                  }                  
          
                  $result['year'] = $results->year_of_car;
                  $result['description'] = $results->description;
                  $result['pro_type'] = $results->pro_type;
                  $result['proper_type'] = $propr_type->name;
                       
                  if (!empty($users->image)) {
                    $result['profileImage'] = $new.'/public/profileImage/'.$users->image;  
                  } else {
                    $result['profileImage'] = $new.'/public/default-image.jpeg';  
                  }
                
                  $images_name =  DB::table('property_img')->select('*')->where('property_id', $proid)->first();

                  if(!empty($images_name))
                  {
                      $proimg = $new.'/public/propertyImage/'.$images_name->img_name;
                      $result['proImg'] = $proimg;
                  }
                  else
                  {
                     $result['proImg'] = $new.'/public/default-image.jpeg';
                  }
                
                  $allimage =  DB::table('property_img')->select('*')->where('property_id', $proid)->get();
                  foreach ($allimage as $key => $value1)
                  {                    
                    if ($value1->img_name != "") { 
                      $img_result['id'] = $value1->id;
                      $img_result['image'] = $new.'/public/propertyImage/'.$value1->img_name;
                      $img[] =  $img_result; 
                    }  
                  } 

                  if (!empty($img)) 
                  { 
                     $result['carImage'] = $img;
                  }
                  else 
                  { 
                    $result['carImage'] = array();
                  }

              }
                
              $success['message'] = trans('labels.addPropertySuccessfully');
              $success['success'] = 1;
              $success['result'] = $result;
              echo json_encode($success);exit;
            
            } else { 
            	$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
              if($decode->type==1)  
              {                        
                 $property_img = DB::table('properties')->where('id','=',$decode->carId )->update([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'property_name'=> $car_brand->name,
                    'car_brand'=> $decode->brand,  
                    'prop_category'=> $decode->model ? $decode->model : '' ,  
                    'kilometer'=> $decode->kilometer ? $decode->kilometer : '' ,  
                    'fueltype' =>$decode->fueltype ? $decode->fueltype : '' ,
                    'city' =>$decode->city ? $decode->city : '' ,
                    'description'=> $decode->description ? $decode->description : '' ,  
                    'address' => $decode->location ?  $decode->location :'',  
                    'googleLocation' => $decode->location ?  $decode->location :'', 
                    'sale_price'=> $decode->price ? $decode->price : '',                       
                    'email'=> $decode->email ? $decode->email : '',
                    'phone'=> $decode->phone ?  $decode->phone : '' ,
                    'published'=> $decode->published ?  $decode->published : '', 
                    'userType' => '1',                        
                                         
                  ]);
                }                        
              else
              {    
                $property_img = DB::table('properties')->where('id','=',$decode->carId )->update([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'property_name'=> $car_brand->name,
                    'car_brand'=> $decode->brand,  
                    'prop_category'=> $decode->model ? $decode->model : '' ,  
                    'kilometer'=> $decode->kilometer ? $decode->kilometer : '' ,  
                    'fueltype' =>$decode->fueltype ? $decode->fueltype : '' ,
                    'city' =>$decode->city ? $decode->city : '' ,
                    'description'=> $decode->description ? $decode->description : '' ,  
                    'address' => $decode->location ?  $decode->location :'',  
                    'googleLocation' => $decode->location ?  $decode->location :'', 
                    'month_rentprice'=> $decode->price ? $decode->price : '',                       
                    'email'=> $decode->email ? $decode->email : '',
                    'phone'=> $decode->phone ?  $decode->phone : '' ,
                    'published'=> $decode->published ?  $decode->published : '', 
                    'userType' => '1',                         
                                           
                 ]);                      
              }   
                                
              $files = $request->file('images');
              
                if (!empty($files)) {
                  foreach($files as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('propertyImage/');
                      $file->move($destinationPath, $picture);
      
                      $property_img = new Property_img([
                          'property_id' => $decode->carId,
                          'img_name'=> $picture,
                      ]);
          
                        $property_img->save();
                  }
                }   
                                 
				$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
	            $car_model = DB::table('property_category')->select('*')->where('id', $decode->model)->first();
	            $propr_type = DB::table('property_types')->select('*')->where('id', $decode->type)->first();
	            $users = DB::table('users')->select('*')->where('id', $decode->userId)->first();
	            $results = DB::table('properties')->select('*')->where('id', $decode->carId)->first();


                  $result=array();
                  
                  if (isset($results)) {
                  
	                  $result['Id'] = (string)$results->id;
	                  $result['carBrand'] = $car_brand->name;
	                  $result['carModel'] = $car_model->name;
	                  $result['location'] = $results->googleLocation;   
	                  $result['address'] = $results->address;   
	                  if($results->pro_type=="1")
	                  {
	                    $result['price'] = $results->sale_price;
	                  } 
	                  else
	                  {
	                     $result['price'] = $results->month_rentprice;
	                  }                  
	                 
	                  $result['description'] = $results->description;
	                  $result['pro_type'] = $results->pro_type;
	                  $result['proper_type'] = $propr_type->name;
	                       
	                  if (!empty($users->image)) {
	                    $result['profileImage'] = $new.'/public/profileImage/'.$users->image;  
	                  } else {
	                    $result['profileImage'] = $new.'/public/default-image.jpeg';  
	                  }
	                
	                  $images_name =  DB::table('property_img')->select('*')->where('property_id', $decode->carId)->first();

	                  if(!empty($images_name))
	                  {
	                      $proimg = $new.'/public/propertyImage/'.$images_name->img_name;
	                      $result['proImg'] = $proimg;
	                  }
	                  else
	                  {
	                     $result['proImg'] = $new.'/public/default-image.jpeg';
	                  }
	                
	                  $allimage =  DB::table('property_img')->select('*')->where('property_id', $decode->carId)->get();
	                  foreach ($allimage as $key => $value1)
	                  {                    
	                    if ($value1->img_name != "") { 
	                      $img_result['id'] = $value1->id;
	                      $img_result['image'] = $new.'/public/propertyImage/'.$value1->img_name;
	                      $img[] =  $img_result; 
	                    }  
	                  } 

	                  if (!empty($img)) 
	                  { 
	                     $result['carImage'] = $img;
	                  }
	                  else 
	                  { 
	                    $result['carImage'] = array();
	                  }

	              }

                  $success['message'] = trans('labels.editPropertySuccessfully');
                  $success['success'] = 1;
                  $success['result'] = $result;
                  echo json_encode($success);exit;
            
            }

        }
        catch(Exception $e)
        {
            $response = array();
            $response['success'] = 0;
            $response['message'] = $e->getMessage();
            echo json_encode($response);exit;
        } 
  } 

  public function carDelete(Request $request) //car Deleted 
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);        
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);

        if(empty($post['language']))
        {
            $post['language']='en';
        }      
        App::setLocale($post['language']);
        try
        {   
            if(empty($post['startLimit']))
            {
              $post['startLimit']='0';
            }

            if((empty($post['carId'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }     

            $results = DB::table('properties')->select()->where('id',$post['carId'])->get();

            if(count($results)>0)
            {     
                $results = DB::table('properties')->where('id',$post['carId'])->delete();              
                $response = array('success' => 1, 'message' => trans('labels.propertyDeleted'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }  
        }
        catch(Exception $e)
        {

            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function allModelList(Request $request)  // carList for userType == 1 and only for user
  { 
	    $input = file_get_contents('php://input');
	    $post = json_decode($input, true);   
	    
	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);
	    try
	    {            
	        $results = DB::table('property_category')->select()->where('published',1)->get();          
	        
	        if(!empty($results))
	        {
	            $re= array();           
	            foreach($results as $value)
	            {
	              $result['id'] = $value->id;
	              if($post['language']=='ar')
                {
                  $result['name'] = $value->ar; 
                }
                elseif($post['language']=='ku')
                {
                  $result['name'] = $value->ku; 
                }
                else
                {
                  $result['name'] = $value->name; 
                } 
  	              $re[]=$result; 
  	          } 
	            
	            $response = array('success' => 1, 'count'=> count($re), 'result' => $re);
	            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	        }
	        else
	        {
	          $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

	        }  
	    }
	    catch(Exception $e)
	    {
	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	    }      
  
  }

  public function allTypeList(Request $request)  // typeList for userType == 1 and only for user
  {
	    $input = file_get_contents('php://input');
	    $post = json_decode($input, true);   
	    
	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);
	    try
	    {            
	        $results = DB::table('property_types')->select()->where('published',1)->get();   
	        if(!empty($results))
	        {
	          $re= array();           
	          foreach($results as $value)
	          {
	            $result['id'] = $value->id;
	            if($post['language']=='ar')
              {
                $result['name'] = $value->ar; 
              }
              elseif($post['language']=='ku')
              {
                $result['name'] = $value->ku; 
              }
              else
              {
                $result['name'] = $value->name; 
              }
	            $re[]=$result; 
	          } 
	          $response = array('success' => 1, 'result' => $re);
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	        }
	        else
	        {
	          $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

	        }  
	    }
	    catch(Exception $e)
	    {
	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	    }      
  }

  // public function allSpecificationList(Request $request)  // typeList for userType == 1 and only for user
  // {
  //     $input = file_get_contents('php://input');
  //     $post = json_decode($input, true);   
      
  //     if(empty($post['language']))
  //     {
  //       $post['language']='en';
  //     }
    
  //     App::setLocale($post['language']);  
  //     $urlnew = url(''); 
  //     $new = str_replace('index.php', '', $urlnew);
  //     try
  //     {            
  //         $results = DB::table('specification')->select()->where('published',1)->get();   
  //         if(!empty($results))
  //         {
  //           $re= array();           
  //           foreach($results as $value)
  //           {

  //             $result['id'] = $value->id;
  //             if($post['language']=='ar')
  //             {
  //               $result['name'] = $value->ar; 
  //             }
  //             elseif($post['language']=='ku')
  //             {
  //               $result['name'] = $value->ku; 
  //             }
  //             else
  //             {
  //               $result['name'] = $value->name; 
  //             }
              
  //             $re[]=$result; 
  //           } 
  //           $response = array('success' => 1, 'result' => $re);
  //           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
  //         }
  //         else
  //         {
  //           $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
  //           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

  //         }  
  //     }
  //     catch(Exception $e)
  //     {
  //         $response = array('success' => 0, 'message' => $e->getMessage());
  //         echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

  //     }      
  // }

  public function allfuelList(Request $request)  // typeList for userType == 1 and only for user
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);   
      
      if(empty($post['language']))
      {
        $post['language']='en';
      }
    
      App::setLocale($post['language']);  
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
      try
      {            
          $results = DB::table('fueltype')->select()->where('published',1)->get();   
          if(!empty($results))
          {
            $re= array();           
            foreach($results as $value)
            {
              $result['id'] = $value->id;
              if($post['language']=='ar')
              {
                $result['name'] = $value->ar; 
              }
              elseif($post['language']=='ku')
              {
                $result['name'] = $value->ku; 
              }
              else
              {
                $result['name'] = $value->name; 
              }
              
              $re[]=$result; 
            } 
            $response = array('success' => 1, 'result' => $re);
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }
          else
          {
            $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

          }  
      }
      catch(Exception $e)
      {
          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

      }      
  }

  public function allBrandList(Request $request)  // typeList for userType == 1 and only for user
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);   
      
      if(empty($post['language']))
      {
        $post['language']='en';
      }
    
      App::setLocale($post['language']);  
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
      try
      {            
          $results = DB::table('car_brand')->select()->where('status',1)->get();   
          if(!empty($results))
          {
            $re= array();           
            foreach($results as $value)
            {
              $result['id'] = $value->id;
              if($post['language']=='ar')
              {
                $result['name'] = $value->ar; 
              }
              elseif($post['language']=='ku')
              {
                $result['name'] = $value->ku; 
              }
              else
              {
                $result['name'] = $value->name; 
              }
              
              $re[]=$result; 
            } 
            $response = array('success' => 1, 'result' => $re);
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }
          else
          {
            $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

          }  
      }
      catch(Exception $e)
      {
          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

      }      
  }
	
  public function carPublished(Request $request) //car published 
  { 
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);   

      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);

      if(empty($post['language']))
      {
          $post['language']='en';
      }      
      App::setLocale($post['language']);
      try
      {   
          if((empty($post['carId'])))
          {
            $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }     

          if((!isset($post['published'])))
          {
            $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }     

          $results = DB::table('properties')->select()->where('id',$post['carId'])->first();
          if(!empty($results))
          {     
              $result = DB::table('properties')->where('id','=',$results->id)->update(['published' => $post['published']]);
              $response = array('success' => 1, 'message' => trans('labels.carPublished'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }
          else
          {
            $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
          }  
      }
      catch(Exception $e)
      {

          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }   
  } 

  public function requestCar(Request $request) //request car
  { 
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);   

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);

        if(empty($post['language']))
        {
          $post['language']='en';
        }   

        App::setLocale($post['language']);
        try
        {   
            if((empty($post['carId'])))
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }     

            $user =DB::table('properties')->where('id',$post['carId'])->get();           
            if(!empty($user))
            {     
                $result = DB::table('properties')->where('id','=',$post['carId'])->update(['isrequested' => 1]);
                $response = array('success' => 1, 'message' => trans('labels.addpropertyrequest'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }  
        }
        catch(Exception $e)
        {

            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function allProductList(Request $request)  // all product List 
  {

  		$input = file_get_contents('php://input');
	    $post = json_decode($input, true);   
	    
	    if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);
	    try
	    {     
         	$results = DB::table('car_accessories')->select()->where('status',1)->orderby('id','DESC')->offset($post['startLimit'])->limit(10)->paginate();   
	        //echo "<pre>"; print_r($results); die;
	        if(!empty($results))
	        {
	          $re= array();           
	          foreach($results as $value)
	          {
	          	
	          	$storeName = DB::table('administrators')->select()->where('myid',$value->store_id)->first();   
	          	$procategory = DB::table('procategory')->select()->where('id',$value->category_id)->first();  
	         

	            $result['id'] = $value->id;
	            $result['storeId'] = $value->store_id;
	           


	            if(!empty($storeName))
	          	{
	          		$result['storeName'] = $storeName->first_name.' '.$storeName->last_name;
	            	$result['storeImg'] = $new.'/'.$storeName->image;
	          	} 
	          	else
	          	{
	          		$result['storeName'] = '';
	            	$result['storeImg'] = $new.'/public/default-image.jpeg';
	          	}

	            $result['categoryId'] = $value->category_id;
	           

	            if(!empty($procategory))
	          	{
	          		 $result['categoryName'] = $procategory->name;
	          	} 
	          	else
	          	{
	          		$result['categoryName'] ='';
	          	}
	          	


	            $result['name'] = $value->name;  
	            $result['description'] = $value->description;  
	            $result['price'] = $value->price;  
	            $result['size'] = $value->size;  
	            $result['model'] = $value->model;  
	            $result['color'] = $value->color;  
	       

	            $images_name =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->first();
	            //echo "<pre>"; print_r($images_name); 
                    if(count($images_name) > 0)
                    {
                        $proimg = $new.'/public/productImage/'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;
                    }
                    else
                    {
                       $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                    //echo "<pre>"; print_r($allimage); 
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                        $img[] =  $img_result; 
                      }  
                    } 

	                    if (!empty($img)) 
	                    { 
	                       $result['proImage'] = $img;
	                    }
	                    else 
	                    { 
	                      $result['proImage'] = array();
	                    }

                    //echo "<pre>"; print_r($img);
                    

                    //echo "<pre>"; print_r($result); 
	            $re[]=$result; 
	          } 
	          //echo "<pre>"; print_r($re); die;
	          $response = array('success' => 1, 'message' => trans('labels.productListSuccessfully'), 'total' => count($re), 'result' => $re );
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	        }
	        else
	        {
	          $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

	        }  
	    }
	    catch(Exception $e)
	    {
	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	    }      
  }

  public function storeProductList(Request $request)  // Store Product List 
  {

  		$input = file_get_contents('php://input');
	    $post = json_decode($input, true);   

	    if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);

	    if(!isset($post['storeId']))
        {
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
        }
            
	    try
	    {           

	    	$results = DB::table('car_accessories')->select()->where('status',1)->where('store_id',$post['storeId'])->orderby('id','DESC')->offset($post['startLimit'])->limit(10)->paginate();  

	        
	        if(!empty($results))
	        {
	          $re= array();           
	          foreach($results as $value)
	          {


	          	$storeName = DB::table('administrators')->select()->where('myid',$value->store_id)->first();   
	          	$procategory = DB::table('procategory')->select()->where('id',$value->category_id)->first();  
	          	$place_order = DB::table('Place_Order')->select(DB::raw("SUM(Quantity) as total"))->where('Product_ID',$value->id)->first();    
	          	


	            $result['id'] = $value->id;
	            $result['storeId'] = $value->store_id;
	            $result['storeName'] = $storeName->first_name.' '.$storeName->last_name;
              	$result['storeImg'] = $new.'/'.$storeName->image;
              	$result['storePhone'] = $storeName->phone;
	            $result['storeEmail'] = $storeName->email;
	            $result['categoryId'] = $value->category_id;

	             if(!empty($procategory))
                {
                   $result['categoryName'] = $procategory->name;
                }
                else
                {
                   $result['categoryName'] = '0';
                } 

	            $result['name'] = $value->name;  
	            $result['description'] = $value->description;  
	            $result['price'] = $value->price;  
	            $result['size'] = $value->size;  
	            $result['model'] = $value->model;  
	            $result['color'] = $value->color; 
	            $result['quantity'] = $value->quantity; 

	            if(!empty($place_order))
                {
                   $result['available'] =$value->quantity - $place_order->total ;
                }
                else
                {
                   $result['available'] = '0';
                } 
 


	            $images_name =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->first();
	            //echo "<pre>"; print_r($images_name); 
                    if(!empty($images_name))
                    {
                        $proimg = $new.'/public/productImage/'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;
                    }
                    else
                    {
                       $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                    //echo "<pre>"; print_r($allimage); 
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                        $img[] =  $img_result; 
                      }  
                    } 

	                    if (!empty($img)) 
	                    { 
	                       $result['proImage'] = $img;
	                    }
	                    else 
	                    { 
	                      $result['proImage'] = array();
	                    }


	            $re[]=$result; 
	          } 
	          
	          $response = array('success' => 1, 'message' => trans('labels.productListSuccessfully'), 'total' => count($re), 'result' => $re );
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	        }
	        else
	        {
	          $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

	        }  
	    }
	    catch(Exception $e)
	    {
	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	    }      
  }

  public function storeList(Request $request)  // Store List 
  {

  		$input = file_get_contents('php://input');
      $post = json_decode($input, true);  
      
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $results = DB::table('administrators')->where('issubadmin',3)->orderby('myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();
            //echo "<pre>"; print_r($results); die;
            if(!empty($results))
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->myid;
                    $result['firstName'] = $value->first_name;
                    $result['lastName'] = $value->last_name;
                    $result['email'] = $value->email;
                    $result['phone'] = $value->phone;
                    $result['image'] = $value->image;    
                    $result['share'] = $new."/productlist/".$value->myid;              

                      if($value->image != '')
                      {
                        $result['image'] =url($value->image);
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.storeAdminSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
  }

  public function productDetail(Request $request)  // Product Detail 
  {

  		$input = file_get_contents('php://input');
	    $post = json_decode($input, true);   
	    
	    if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);
	    try
	    {           

	    	if( (empty($post['proId'])) )
            {
              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }


          /*$user = User::select("users.*","items.id as itemId","jobs.id as jobId")
                  ->join("items","items.user_id","=","users.id")
                  ->join("jobs",function($join){
                      $join->on("jobs.user_id","=","users.id")
                          ->on("jobs.item_id","=","items.id");
                  })
                  ->get();
          print_r($user);*/



	    	  $results = DB::table('car_accessories')->select()->where('status',1)->where('id',$post['proId'])->orderby('id','DESC')->offset($post['startLimit'])->limit(10)->paginate();   

	        if(!empty($results))
	        {
	          $re= array();           
	          foreach($results as $value)
	          {

	          	$storeName = DB::table('administrators')->select()->where('myid',$value->store_id)->first();   
	          	$procategory = DB::table('procategory')->select()->where('id',$value->category_id)->first();   
	          	
	            $result['id'] = $value->id;
	            $result['storeId'] = $value->store_id;
	            $result['storeName'] = $storeName->first_name.' '.$storeName->last_name;
	            $result['storeImg'] = $new.'/'.$storeName->image;
	            $result['categoryId'] = $value->category_id;
	            $result['categoryName'] = $procategory->name;
	            $result['name'] = $value->name;  
	            $result['description'] = $value->description;  
	            $result['price'] = $value->price;  
	            $result['size'] = $value->size;  
	            $result['model'] = $value->model;  
	            $result['color'] = $value->color;  
	         
	            	$images_name =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->first();
	            
                    if(!empty($images_name))
                    {
                        $proimg = $new.'/public/productImage/'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;
                    }
                    else
                    {
                       $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['proImage'] = $img;
                    }
                    else 
                    { 
                      $result['proImage'] = array();
                    }         
				
				            $re=$result; 
	          } 
  	          $response = array('success' => 1, 'message' => trans('labels.productListSuccessfully'), 'total' => count($re), 'result' => $result );
  	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	        }
	        else
	        {
	          $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
	          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

	        }  
	    }
	    catch(Exception $e)
	    {
	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

	    }      
  }


  public function contactAgent(Request $request) //Contact Agent Deleted  1 = show room admin , 2 = store admin
  {
        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);
        /*echo "<prE>"; print_r($decode); 
        echo "<prE>"; print_r($request->uploadId);
        echo "<prE>"; print_r($request->driverLicense); die;*/
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        try
        {    
            if((empty($post)) || (empty($decode->userId)) || (empty($decode->userType)) || (empty($decode->firstName)) ||  (empty($decode->lastName)) || (empty($decode->nationality)) || (empty($decode->email)) || (empty($decode->phone)) || (empty($decode->dateFrom)) || (empty($decode->dateTo)) || (empty($request->uploadId)) || (empty($request->driverLicense)) || (!isset($decode->contactId)) )
            { 
                $response = array();
                $response['success'] = 0;
                $response['message'] = trans('labels.pleasefillallrequired');
                echo json_encode($response);exit;
            } 
            
            if (empty($decode->contactId)) {
                
                
                $contactId = DB::table('contact_agent')->insertGetId([
                    'userId' => $decode->userId,                           
                    'user_type' => $decode->userType,                           
                    'firstName' => $decode->firstName,                           
                    'lastName'=> $decode->lastName ? $decode->lastName : '' ,  
                    'nationality'=> $decode->nationality ? $decode->nationality : '',  
                    'email'=> $decode->email,  
                    'phone'=> $decode->phone,  
                    'dateFrom'=> $decode->dateFrom,  
                    'dateTo'=> $decode->dateTo,  
                ]);

                $uploadId = $request->file('uploadId');    
                if (!empty($uploadId)) {
                  foreach($uploadId as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('uploadId/');
                      $file->move($destinationPath, $picture);
      
                      $upload_id = DB::table('upload_id')->insertGetId([
                          'c_agentId' => $contactId,
                          'image'=> $picture,
                      ]);
                  }
                }

                $driverLicense = $request->file('driverLicense');    
                if (!empty($driverLicense)) {
                  foreach($driverLicense as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('driverLicense/');
                      $file->move($destinationPath, $picture);
      
                      $driverLicense = DB::table('driverLicense')->insertGetId([
                          'c_agentId' => $contactId,
                          'license'=> $picture,
                      ]);
                  }
                }

                $results = DB::table('contact_agent')->select('*')->where('id', $contactId)->first();
                $user_name = DB::table('administrators')->select('first_name','last_name')->where('myid', $decode->userId)->first();
                //$userType = DB::table('contact_agent')->select('*')->where('id', $contactId)->first();
                $uploadId = DB::table('upload_id')->select('*')->where('c_agentId', $contactId)->get();
                $driverLicense = DB::table('driverLicense')->select('*')->where('c_agentId', $contactId)->get();
                
             
                if (isset($results)) {
                    
                    $result['Id'] = (string)$results->id;
                    $result['userId'] = $results->userId;
                    $result['userName'] = $user_name->first_name.' '.$user_name->first_name;
                    $result['userTypeId'] = $results->user_type;
                    if ($results->user_type == '1') {
                      $result['userType'] = "Show Room Admin";
                    } elseif ($results->user_type == '2') {
                      $result['userType'] = "Store Admin";
                    }
                    $result['firstName'] = $results->firstName;
                    $result['lastName'] = (string)$results->lastName;
                    $result['nationality'] = (string)$results->nationality;
                    $result['email'] = (string)$results->email;
                    $result['phone'] = (string)$results->phone;
                    $result['dateFrom'] = (string)$results->dateFrom;
                    $result['dateTo'] = (string)$results->dateTo;
                    
                    foreach ($uploadId as $key => $value1)
                    {                    
                      if ($value1->image != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/uploadId/'.$value1->image;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['uploadId'] = $img;
                    }
                    else 
                    { 
                      $result['uploadId'] = array();
                    }

                    foreach ($driverLicense as $key => $value1)
                    {                    
                      if ($value1->license != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['license'] = $new.'/public/driverLicense/'.$value1->license;
                        $license[] =  $img_result; 
                      }  
                    } 

                    if (!empty($license)) 
                    { 
                       $result['driverLicense'] = $license;
                    }
                    else 
                    { 
                      $result['driverLicense'] = array();
                    }
                }
                
                $success['message'] = trans('labels.addContactAgentSuccessfully');
                $success['success'] = 1;
                $success['result'] = $result;
                echo json_encode($success);exit;
            
            } else { //echo 2222; die;
              //$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
                                     
                 $property_img = DB::table('contact_agent')->where('id','=',$decode->contactId )->update([
                    'firstName' => $decode->firstName,                           
                    'lastName'=> $decode->lastName ? $decode->lastName : '' ,  
                    'nationality'=> $decode->nationality ? $decode->nationality : '',  
                    'email'=> $decode->email,  
                    'phone'=> $decode->phone,  
                    'dateFrom'=> $decode->dateFrom,  
                    'dateTo'=> $decode->dateTo,
                  ]);
                                
              
              $uploadId = $request->file('uploadId');   
              
                if (!empty($uploadId)) {
                  foreach($uploadId as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('uploadId/');
                      $file->move($destinationPath, $picture);
      
                      $upload_id = DB::table('upload_id')->insertGetId([
                          'c_agentId' => $decode->contactId,
                          'image'=> $picture,
                      ]);
                  }
                }


                $driverLicense = $request->file('driverLicense');    
                if (!empty($driverLicense)) {
                  foreach($driverLicense as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('driverLicense/');
                      $file->move($destinationPath, $picture);
      
                      $driverLicense = DB::table('driverLicense')->insertGetId([
                          'c_agentId' => $decode->contactId,
                          'license'=> $picture,
                      ]);
                  }
                }

                                 
                $results = DB::table('contact_agent')->select('*')->where('id', $decode->contactId)->first();
                $uploadId = DB::table('upload_id')->select('*')->where('c_agentId', $decode->contactId)->get();
                $driverLicense = DB::table('driverLicense')->select('*')->where('c_agentId', $decode->contactId)->get();


                  $result=array();
                  
                  if (isset($results)) {
                    
                    $result['Id'] = (string)$results->id;
                    $result['firstName'] = $results->firstName;
                    $result['lastName'] = (string)$results->lastName;
                    $result['nationality'] = (string)$results->nationality;
                    $result['email'] = (string)$results->email;
                    $result['phone'] = (string)$results->phone;
                    $result['dateFrom'] = (string)$results->dateFrom;
                    $result['dateTo'] = (string)$results->dateTo;
                    
                    foreach ($uploadId as $key => $value1)
                    {                    
                      if ($value1->image != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/uploadId/'.$value1->image;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['uploadId'] = $img;
                    }
                    else 
                    { 
                      $result['uploadId'] = array();
                    }

                    foreach ($driverLicense as $key => $value1)
                    {                    
                      if ($value1->license != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['license'] = $new.'/public/driverLicense/'.$value1->license;
                        $license[] =  $img_result; 
                      }  
                    } 

                    if (!empty($license)) 
                    { 
                       $result['driverLicense'] = $license;
                    }
                    else 
                    { 
                      $result['driverLicense'] = array();
                    }
                }

                  $success['message'] = trans('labels.editContactAgentSuccessfully');
                  $success['success'] = 1;
                  $success['result'] = $result;
                  echo json_encode($success);exit;
            
            }

        }
        catch(Exception $e)
        {
            $response = array();
            $response['success'] = 0;
            $response['message'] = $e->getMessage();
            echo json_encode($response);exit;
        } 
    
  }

  public function carBooking(Request $request) //Contact Agent Deleted  1 = show room admin , 2 = store admin
  {

        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);
        /*echo "<prE>"; print_r($decode); 
        echo "<prE>"; print_r($request->uploadId);
        echo "<prE>"; print_r($request->driverLicense); die;*/
        if(empty($decode->language))
        {
          $decode->language='en';
        }
      
        App::setLocale($decode->language);  
        try
        {    
            if((empty($post)) || (empty($decode->userId)) || (empty($decode->carId)) || (empty($decode->firstName)) ||  (empty($decode->lastName)) || (empty($decode->nationality)) || (empty($decode->email)) || (empty($decode->phone)) || (empty($decode->dateFrom)) || (empty($decode->dateTo)))
            { 
                $response = array();
                $response['success'] = 0;
                $response['message'] = trans('labels.pleasefillallrequired');
                echo json_encode($response);exit;
            } 
            
            if (empty($decode->contactId)) {                
                
                $contactId = DB::table('contact_agent')->insertGetId([
                	'carId' => $decode->carId,  
                    'userId' => $decode->userId,                           
                    'user_type' => 1,                           
                    'firstName' => $decode->firstName,                           
                    'lastName'=> $decode->lastName ? $decode->lastName : '' ,  
                    'nationality'=> $decode->nationality ? $decode->nationality : '',  
                    'email'=> $decode->email,  
                    'phone'=> $decode->phone,  
                    'dateFrom'=> $decode->dateFrom,  
                    'dateTo'=> $decode->dateTo,  
                ]);

                $uploadId = $request->file('uploadId');    
                if (!empty($uploadId)) {
                  foreach($uploadId as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('uploadId/');
                      $file->move($destinationPath, $picture);
      
                      $upload_id = DB::table('upload_id')->insertGetId([
                          'c_agentId' => $contactId,
                          'image'=> $picture,
                      ]);
                  }
                }

                $driverLicense = $request->file('driverLicense');    
                if (!empty($driverLicense)) {
                  foreach($driverLicense as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('driverLicense/');
                      $file->move($destinationPath, $picture);
      
                      $driverLicense = DB::table('driverLicense')->insertGetId([
                          'c_agentId' => $contactId,
                          'license'=> $picture,
                      ]);
                  }
                }

                $results = DB::table('contact_agent')->select('*')->where('id', $contactId)->first();
                $user_name = DB::table('users')->select('name','lname')->where('id', $decode->userId)->first();
                //$userType = DB::table('contact_agent')->select('*')->where('id', $contactId)->first();
                $uploadId = DB::table('upload_id')->select('*')->where('c_agentId', $contactId)->get();
                $driverLicense = DB::table('driverLicense')->select('*')->where('c_agentId', $contactId)->get();
                
             
                if (isset($results)) {
                    
                    $result['Id'] = (string)$results->id;
                    $result['userId'] = $results->userId;
                    $result['userName'] = $user_name->name.' '.$user_name->lname;
                    $result['userTypeId'] = $results->user_type;
                    if ($results->user_type == '1') {
                      $result['userType'] = "User";
                    } 
                    $result['firstName'] = $results->firstName;
                    $result['lastName'] = (string)$results->lastName;
                    $result['nationality'] = (string)$results->nationality;
                    $result['email'] = (string)$results->email;
                    $result['phone'] = (string)$results->phone;
                    $result['dateFrom'] = (string)$results->dateFrom;
                    $result['dateTo'] = (string)$results->dateTo;
                    
                    foreach ($uploadId as $key => $value1)
                    {                    
                      if ($value1->image != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/uploadId/'.$value1->image;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['uploadId'] = $img;
                    }
                    else 
                    { 
                      $result['uploadId'] = array();
                    }

                    foreach ($driverLicense as $key => $value1)
                    {                    
                      if ($value1->license != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['license'] = $new.'/public/driverLicense/'.$value1->license;
                        $license[] =  $img_result; 
                      }  
                    } 

                    if (!empty($license)) 
                    { 
                       $result['driverLicense'] = $license;
                    }
                    else 
                    { 
                      $result['driverLicense'] = array();
                    }
                }
                
                $success['message'] = trans('labels.carbokingsucessfully');
                $success['success'] = 1;
                $success['result'] = $result;
                echo json_encode($success);exit;
            
            } else { //echo 2222; die;
              //$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
                                     
                 $property_img = DB::table('contact_agent')->where('id','=',$decode->contactId )->update([
                    'firstName' => $decode->firstName,                           
                    'lastName'=> $decode->lastName ? $decode->lastName : '' ,  
                    'nationality'=> $decode->nationality ? $decode->nationality : '',  
                    'email'=> $decode->email,  
                    'phone'=> $decode->phone,  
                    'dateFrom'=> $decode->dateFrom,  
                    'dateTo'=> $decode->dateTo,
                  ]);
                                
              
              $uploadId = $request->file('uploadId');   
              
                if (!empty($uploadId)) {
                  foreach($uploadId as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('uploadId/');
                      $file->move($destinationPath, $picture);
      
                      $upload_id = DB::table('upload_id')->insertGetId([
                          'c_agentId' => $decode->contactId,
                          'image'=> $picture,
                      ]);
                  }
                }


                $driverLicense = $request->file('driverLicense');    
                if (!empty($driverLicense)) {
                  foreach($driverLicense as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('driverLicense/');
                      $file->move($destinationPath, $picture);
      
                      $driverLicense = DB::table('driverLicense')->insertGetId([
                          'c_agentId' => $decode->contactId,
                          'license'=> $picture,
                      ]);
                  }
                }

                                 
                $results = DB::table('contact_agent')->select('*')->where('id', $decode->contactId)->first();
                $uploadId = DB::table('upload_id')->select('*')->where('c_agentId', $decode->contactId)->get();
                $driverLicense = DB::table('driverLicense')->select('*')->where('c_agentId', $decode->contactId)->get();


                  $result=array();
                  
                  if (isset($results)) {
                    
                    $result['Id'] = (string)$results->id;
                    $result['firstName'] = $results->firstName;
                    $result['lastName'] = (string)$results->lastName;
                    $result['nationality'] = (string)$results->nationality;
                    $result['email'] = (string)$results->email;
                    $result['phone'] = (string)$results->phone;
                    $result['dateFrom'] = (string)$results->dateFrom;
                    $result['dateTo'] = (string)$results->dateTo;
                    
                    foreach ($uploadId as $key => $value1)
                    {                    
                      if ($value1->image != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['image'] = $new.'/public/uploadId/'.$value1->image;
                        $img[] =  $img_result; 
                      }  
                    } 

                    if (!empty($img)) 
                    { 
                       $result['uploadId'] = $img;
                    }
                    else 
                    { 
                      $result['uploadId'] = array();
                    }

                    foreach ($driverLicense as $key => $value1)
                    {                    
                      if ($value1->license != "") { 
                        $img_result['id'] = $value1->id;
                        $img_result['license'] = $new.'/public/driverLicense/'.$value1->license;
                        $license[] =  $img_result; 
                      }  
                    } 

                    if (!empty($license)) 
                    { 
                       $result['driverLicense'] = $license;
                    }
                    else 
                    { 
                      $result['driverLicense'] = array();
                    }
                }

                  $success['message'] = trans('labels.editContactAgentSuccessfully');
                  $success['success'] = 1;
                  $success['result'] = $result;
                  echo json_encode($success);exit;
            
            }

        }
        catch(Exception $e)
        {
            $response = array();
            $response['success'] = 0;
            $response['message'] = $e->getMessage();
            echo json_encode($response);exit;
        } 
    
  }
  
  public function getCity(Request $request)  // "language":"en"
  {

    
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
      
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $results = DB::table('city')->groupby('name')->get();

            if(!empty($results))
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['name'] = $value->name;
                    $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.citylistsuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

	public function appdeleteCarImage(Request $request)
	{   
	    $input = file_get_contents('php://input');
	    $post = json_decode($input, true);

	    //echo "<pre>"; print_r($post); die;

	    if(empty($post['language']))
	    {
	      $post['language']='en';
	    }   

	    App::setLocale($post['language']);

	    try
	    {
	        $id = $post['id']; 
	        $pro_id = $post['carId']; 

	        if((empty($id)) || (empty($pro_id)) )
	          {
	              $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
	              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	          }

	        $Property_img = DB::table('property_img')->where('id', $id)->where('property_id', $pro_id)->first();
	        
	        if (!empty($Property_img)) {

	            $filePath = public_path('propertyImage/'.$Property_img->img_name);
	            unlink($filePath);
	            $Property_imgdel = DB::table('property_img')->where('id', $id)->where('property_id', $pro_id)->delete();
	            
	            $response = array('success' => 1, 'message' => trans('labels.propertyImageDeleteSuccessfully'));
	            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	            
	            //echo json_encode($success);exit;

	        } else {

	            $response = array('success' => 0, 'message' => trans('labels.propertyImageNotDelete'));
	            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	        }
	        
	    }
	    catch(Exception $e)
	    {

	        $response = array('success' => 0, 'message' => $e->getMessage());
	        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	    }
	}

  public function getCompanyRental(Request $request)  // admin List for userType == 2 and only for adminshowroom
  { 
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
      
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $ress = DB::table('administrators');
            $ress->join('properties','properties.companyId','=','administrators.myid','inner');
            $ress->select('administrators.*');

              if(!empty($post['city']))
              {           
                $ress->where('administrators.city',$post['city']);
              }

            $ress->where('administrators.issubadmin',4);
            $ress->where('properties.pro_type','=',2);
            $ress->orderby('administrators.myid','DESC');
            $ress->offset($post['startLimit']);
            // $ress->distinct('administrators.myid');
            $ress->limit(10);
            $results = $ress->get();
              // echo  "<pre>";
              // print_r($results); exit;

            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->myid;
                    $result['firstName'] = $value->first_name;
                    $result['lastName'] = $value->last_name;
                    $result['email'] = $value->email;
                    $result['phone'] = $value->phone;
                    $result['image'] = $value->image;  
                    $result['share'] = $new."/companyList/".$value->myid;                

                      if($value->image != '')
                      {
                        $result['image'] =url($value->image);
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.comapniesSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function getCompanySell(Request $request)  // admin List for userType == 2 and only for adminshowroom
  { 
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
      
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
             $results = DB::table('administrators')->join('properties','properties.companyId','=','administrators.myid','inner')->select('administrators.*')->where('administrators.issubadmin',4)->where('properties.pro_type','=',1)->orderby('administrators.myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();

            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->myid;
                    $result['firstName'] = $value->first_name;
                    $result['lastName'] = $value->last_name;
                    $result['email'] = $value->email;
                    $result['phone'] = $value->phone;
                    $result['image'] = $value->image;               

                      if($value->image != '')
                      {
                        $result['image'] =url($value->image);
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.comapniesSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function getcompanyCity(Request $request)  // admin List for userType == 2 and only for adminshowroom
   {
   
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

         if(empty($post['companyId']))
        {           
            $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

   
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {           


            $results = DB::table('properties')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->join('fueltype','fueltype.id','=','properties.fueltype','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename','fueltype.name as fueltypeName')->where('properties.userType',3)->where('properties.companyId',$post['companyId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
              //echo "<pre>"; print_r($results); die;
            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
                  //echo "<pre>"; print_r($value);   
                    $result['id'] = $value->id;
                    $result['showRoomId'] = $value->showRoomId;
                    $result['carBrandId'] = $value->car_brand;
                    $result['carBrand'] = $value->carBrand;
                    $result['name'] = $value->property_name;
                    $result['address'] = $value->address;
                    $result['salePrice'] = $value->sale_price;
                    $result['monthRent'] = $value->month_rentprice;
                    $result['description'] = $value->description;
                    $result['typeId'] = $value->typeid;
                    $result['carType'] = $value->typename;
                    $result['categoryId'] = $value->catid;
                    $result['carModel'] = $value->procategory;
                    $result['location'] = $value->googleLocation;
                    $result['lat'] = $value->lat;
                    $result['long'] = $value->lng;
                    $result['location'] = $value->googleLocation;
                    $result['published'] = $value->published;
                    
                    if ($value->fueltypeName == "") {
                      $result['fueltypeName'] = "";  
                    } else {
                      $result['fueltypeName'] = $value->fueltypeName;  
                    }

                    if ($value->kilometer == "") {
                      $result['kilometer'] = "";
                    } else {
                      $result['kilometer'] = $value->kilometer;
                    }
                    
                    if ($value->kilometer == "") {
                      $result['kilometer'] = "";
                    } else {
                      $result['kilometer'] = $value->kilometer;  
                    }
                    
                      if($value->typeid==1)
                      {
                        $result['price'] = $value->sale_price;
                       
                      }
                      else
                      {
                        $result['price'] = $value->month_rentprice;
                      }
                 
                      $images=  DB::table('property_img')->select()->where('property_id',$value->id)->first(); 

                      if(!empty($images))
                      {
                        $result['image'] = $new.'/public/propertyImage/'.$images->img_name;
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                } 

                $response = array('success' => 1, 'message' => trans('labels.propertySuccessfully') ,'totalCount' => count($re) ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function placeOrder(Request $request)  // admin List for userType == 2 and only for adminshowroom
  {
   
      $input = file_get_contents('php://input');
      $post = json_decode($input, true); 

        if(empty($post['language']))
        {
          $post['language']='en';
        }      
        App::setLocale($post['language']);  

        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        if(empty($post['city']))
        {
           $post['city']='iraq';
        }

        if(empty($post['pincode']))
        {           
            $post['pincode']='28';
        }

        if((empty($post['name'])) || (empty($post['address'])) || (empty($post['city'])) || (empty($post['pincode'])) || (empty($post['mobile'])) || (empty($post['totalPrice'])) || (empty($post['userId'])) || (empty($post['Product'])))
        {           
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {          
                
            $order_id = DB::table('orders')->insertGetId([
                'Name' => $post['name'],
                'address' => $post['address'],
                'city'=> $post['address'],
                'pincode'=> $post['address'],
                'Mobile'=> $post['mobile'],
                'User_ID' => $post['userId'],
                'TotalCount' => $post['totalPrice'],
                'Status' => 'Pending',
            ]);      
   
                   
            if($order_id)
            {                 
                foreach($post['Product'] as $value)
                {            
                    $d_id = DB::table('Place_Order')->insertGetId([
                    'Order_ID' => $order_id,                 
                    'Product_ID'=> $value['productId'],
                    'Name'=> $value['name'],
                    'Price'=> $value['price'],
                    'Quantity' => $value['quantity'],
                  ]);            
            
                }
                $response = array('success' => 1, 'message' => trans('labels.oredrplacesucessfully'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function orderListing(Request $request)  // admin List for userType == 2 and only for adminshowroom
  {
   
      $input = file_get_contents('php://input');
      $post = json_decode($input, true); 
  
        if(empty($post['language']))
        {
          $post['language']='en';
        }      
        App::setLocale($post['language']);  

        if(empty($post['startLimit']))
        {           
            $post['startLimit']=0;
        }

        if(empty($post['userId']))
        {           
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {   
            $order = DB::table('orders')->select('*')->where('User_ID','=',$post['userId'])->get();
            if(count($order)> 0)
            {
              $re= array();
              $result = array();       
               
                foreach($order as $value)
                {    
                    $result['orderId'] = $value->Order_ID;
                    $result['status'] = $value->Status;
                    $result['name'] = $value->Name;
                    $result['mobile'] = $value->Mobile;
                    $result['pincode'] = $value->pincode;
                    $result['address'] = $value->address;
                    $result['city'] = $value->city;  
                    $result['date'] = $value->datetime;  
                    $result['totalPrice']=$value->TotalCount;  

                    $place = DB::table('Place_Order')->select('*')->where('Order_ID','=',$value->Order_ID)->get();
              
                    $placess= array();
                    foreach($place as $add)
                    { 
                      $pla['productId']=$add->Product_ID; 

                        $images=  DB::table('property_img')->select()->where('property_id',$add->Product_ID)->first(); 

                      if(!empty($images))
                      {
                        $pla['image'] = $new.'/public/propertyImage/'.$images->img_name;
                      }
                      else
                      {
                        $pla['image'] = $new.'/public/default-image.jpeg';
                      }  
                      $pla['Name']=$add->Name; 
                      $pla['Price']=$add->Price; 
                      $pla['Quantity']=$add->Quantity; 
                      $placess[]=$pla;
                    }
                    $result['product']=$placess;        
                    $re[]=$result;
                }                  
            
                $response = array('success' => 1, 'message' => trans('labels.orderlistsucessfully'),'totalCount' => count($re),'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function readNotification(Request $request)
  { 
      $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);    
        //echo "<pre>"; print_r($post); die;
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  

        try
        {           
            $userId=$post['deviceToken'];
            $notificationId=$post['notificationId'];
            
            
            if((!isset($userId)) || (!isset($notificationId)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            if((empty($userId)) || (empty($notificationId)) ){
                $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            $read_notification = DB::table('notification')->select('*')->where('id','=',$notificationId)->where('deviceToken','=',$userId)->first();        
                  //echo "<pre>"; print_r($read_notification); die;
              if (isset($read_notification)) {       
                if ($userId != "") {
                  $device_id = DB::table('notification')->where('id','=',$notificationId)->where('deviceToken','=',$userId)->update([
                      'status'=> 1
                  ]);   
                } else {

                  $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
                  echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
                  } 
              }
            
                  $response = array('success' => 1, 'message' => trans('labels.notificationReadSucceessfully') );
                  echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }
        catch(Exception $e){

          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
  
  } 

  public function notificationList(Request $request)  // "language":"en"
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      // echo 111;die;
        App::setLocale($post['language']);  
      
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {            
            $results = DB::table('notification')->where('deviceToken',$post['deviceToken'])->get();            
            if(count($results) >  0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
                    $user_name = DB::table('users')->where('deviceToken',$post['deviceToken'])->first();
                    if(!empty($user_name))
                    {
                        $result['id'] = $value->id;
                        $result['userName'] = $user_name->username;
                        $result['notification'] = str_replace("\r\n", '', $value->notification);
                        $result['status'] = $value->status;
                        $re[]=$result;
                    }
                    else
                    {
                        $result['id'] = $value->id;
                        $result['userName'] = '';
                        $result['notification'] = str_replace("\r\n", '', $value->notification);
                        $result['status'] = $value->status;
                        $re[]=$result;
                    }
                  
                }

                $read_notification = DB::table('notification')->where('deviceToken',$post['deviceToken'])->where('status',1)->count();
                $unread_notification = DB::table('notification')->where('deviceToken',$post['deviceToken'])->where('status',0)->count();


                $response = array('success' => 1, 'message' => trans('labels.notificationlistsuccessfully') ,'unreadNotification' => $unread_notification, 'readNotification' => $read_notification ,'result' => $re);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }

  public function notificationCount(Request $request)  // "language":"en"
  {
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);  
        if(empty($post['language']))
        {
          $post['language']='en';
        }
      
        App::setLocale($post['language']);  
      
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {            
            $results = DB::table('notification')->where('deviceToken',$post['deviceToken'])->get();            
            if(!empty($results))
            {
              $re= array();
              $result = array();  
              $read_notification = DB::table('notification')->where('deviceToken',$post['deviceToken'])->where('status',1)->count();
              $unread_notification = DB::table('notification')->where('deviceToken',$post['deviceToken'])->where('status',0)->count();

              $response = array('success' => 1, 'message' => trans('labels.notificationlistsuccessfully') ,'unreadNotification' => $unread_notification, 'readNotification' => $read_notification );
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

            }
            else
            {
              $response = array('success' => 0, 'message' => trans('labels.noResultFound'));
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     

            }
  
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   
    
  }






}