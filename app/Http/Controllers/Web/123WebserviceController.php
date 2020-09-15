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
use App\Car;
use App\Pro_feature;
use App\Car_img;
use App\ContactAgent;


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


          $top_car = DB::table('top_car')->select()->pluck('carId'); 

            if(count($top_car) > 0)
            {
                $resultstr = array();
                foreach ($top_car as $result) {
                  $resultstr[] = $result;
                }            

                $data = DB::table('car');
                $data->join('car_model','car_model.id','=','car.prop_category','left');
                $data->join('car_brand','car_brand.id','=','car.car_brand','left');
                $data->join('car_types','car_types.id','=','car.pro_type','left');
                $data->join('fueltype','fueltype.id','=','car.fueltype','left') ;      
                $data->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName')->whereIn('car.id',$resultstr);
                $results4 =$data->get();  
            } 
            else
            {
              $results4=array();
            }
            
            $data = DB::table('car');
            $data->join('car_model','car_model.id','=','car.prop_category','left');
            $data->join('car_brand','car_brand.id','=','car.car_brand','left');
            $data->join('car_types','car_types.id','=','car.pro_type','left');
            $data->join('fueltype','fueltype.id','=','car.fueltype','left') ;      
            $data->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName');

	          if(!empty($post['city']))
	          {
	            $data->where('car.city','=',$post['city']);
	          }

	          // if(!empty($post['type']))
	          // {
	          //   $data->where('car.pro_type',$post['type']);
	          // }

	          if(!empty($post['carBrand']))
	          {
	            $data->where('car.car_brand',$post['carBrand']);
	          }

	          if(!empty($post['year']))
	          {
	            $data->where('car.year_of_car',$post['year']);
	          }
             if(count($top_car) > 0)
             {
               $data->whereNotIn('car.id',$resultstr); 
             }  

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data->where('car.sale_price','>=',$post['minPrice']);
	            $data->where('car.sale_price','<=',$post['maxPrice']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data->where('car.month_rentprice','>=',$post['minPrice']);
	            $data->where('car.month_rentprice','<=',$post['maxPrice']);
	          }          

            $data->where('car.pro_type',1);
            $data->where('car.published',1);
            $data->orderby('car.id','DESC');

            if(count($top_car) > 0)
            {

              if($post['startLimit']=='0')
              {
                $data->offset($post['startLimit']);
                $lim= 10 - (count($top_car));
                $data->limit($lim); 
              }
              else
              {
                $offs= $post['startLimit'] - (count($top_car));
                $data->offset($offs);
                $data->limit(10); 
              }
         
            }
            else
            {
              $data->offset($post['startLimit']);
              $data->limit(10); 
            }
            // $data->offset($post['startLimit']);           
            // $data->limit(10);
            $results = $data->get();

            $data1 = DB::table('car');
            $data1->join('car_model','car_model.id','=','car.prop_category','left');
            $data1->join('car_brand','car_brand.id','=','car.car_brand','left');
            $data1->join('car_types','car_types.id','=','car.pro_type','left');
            $data1->join('fueltype','fueltype.id','=','car.fueltype','left') ;     
            $data1->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName');

	          if(!empty($post['city']))
	          {
	            $data1->where('car.city','=',$post['city']);
	          }

	     /*     if(!empty($post['type']))
	          {
	            $data1->where('car.pro_type',$post['type']);
	          }*/

	          if(!empty($post['carBrand']))
	          {
	            $data1->where('car.car_brand',$post['carBrand']);
	          }

	          if(!empty($post['year']))
	          {
	            $data1->where('car.year_of_car',$post['year']);
	          }

            if(count($top_car) > 0)
             {
               $data1->whereNotIn('car.id',$resultstr); 
             }  

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data1->where('car.sale_price','>=',$post['minPrice']);
	            $data1->where('car.sale_price','<=',$post['maxPrice']);
	          }

	          if(!empty($post['minPrice']) || !empty($post['maxPrice']))
	          {
	            $data1->where('car.month_rentprice','>=',$post['minPrice']);
	            $data1->where('car.month_rentprice','<=',$post['maxPrice']);
	          }          

            $data1->where('car.pro_type',1);
            $data1->where('car.published',1);
            $data1->orderby('car.id','DESC');      
        
            $results1 = $data1->get();
            $countdata = $data1->count();
  			   
            if(!empty($results))
            {
              $re= array();
              $result = array();   
              if($post['startLimit']=='0')
              {
                foreach($results4 as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['name'] = $value->car_name;            
                   

                    if(!empty($value->car_brand)){
                      $result['carBrandId'] = $value->car_brand;
                    }
                    else{
                      $result['carBrandId'] = '0';
                    }

                    if(!empty($value->carBrand)){
                       $result['carBrand'] = $value->carBrand;
                    }
                    else{
                      $result['carBrand'] = '';
                    }

                    if(!empty($value->catid)){
                       $result['modelId'] = (string)$value->catid;
                    }
                    else{
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
                 
                      $images=  DB::table('car_img')->select()->where('car_id',$value->id)->first(); 

                      if(!empty($images))
                      {
                        if(file_exists(public_path('carImage/thumb_'.$images->img_name))){
                            $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;
                        }else{
                            $result['image'] = $new.'/public/carImage/'.$images->img_name;
                        }
                        
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                      
                } 
              }     
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['name'] = $value->car_name;  
                   
                   

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
                

                      if($value->typeid==1){
                        $result['price'] = $value->sale_price;
                      }
                      else{
                        $result['price'] = $value->month_rentprice;
                      }
                 
                      $images=  DB::table('car_img')->select()->where('car_id',$value->id)->first(); 

                      if(!empty($images)){
                        
                            if(file_exists(public_path('carImage/thumb_'.$images->img_name))){
                                $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;
                            }else{
                                $result['image'] = $new.'/public/carImage/'.$images->img_name;
                            }

                      }
                      else{
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                      
                } 

                $response = array('success' => 1, 'message' => trans('labels.carSuccessfully') ,'totalCount' => $countdata + count($top_car) ,'result' => $re);
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
            

            $results = DB::table('car')->join('fueltype','fueltype.id','=','car.fueltype','left')->join('car_model','car_model.id','=','car.prop_category','left')->join('car_brand','car_brand.id','=','car.car_brand','left')->join('car_types','car_types.id','=','car.pro_type','left')->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName','fueltype.id as fueltypeId')->where('car.userType',1)->where('car.userId',$post['userId'])->orderby('car.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
            //echo "<pre>"; print_r($results); die;

            if(count($results)>0)
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['userId'] = $value->userId;

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


                     if(!empty($value->year_of_car))
                    {
                      $result['year'] = $value->year_of_car;
                    }
                    else
                    {
                      $result['year'] = '0';
                    }


                     if(!empty($value->sale_price))
                    {
                      $result['salePrice'] = $value->sale_price;
                    }
                    else
                    {
                      $result['salePrice'] = '0';
                    }

                    if(!empty($value->month_rentprice))
                    {
                      $result['monthRent'] = $value->month_rentprice;
                    }
                    else
                    {
                      $result['monthRent'] = '0';
                    }

                     if(!empty($value->fueltypeName))
                    {
                      $result['fueltypeName'] = $value->fueltypeName;
                    }
                    else
                    {
                      $result['fueltypeName'] = '';
                    }

                      if(!empty($value->fueltypeId))
                    {
                      $result['fueltypeId'] = $value->fueltypeId;
                    }
                    else
                    {
                      $result['fueltypeId'] = '0';
                    }
                    


                    $result['name'] = $value->car_name;
                    $result['address'] = $value->address;
                    $result['kilometer'] = $value->kilometer;                  
                   
                    $result['description'] = $value->description;
                    $result['typeId'] = $value->typeid;
                    $result['modelId'] = $value->catid;
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
                 
                      $images=  DB::table('car_img')->select()->where('car_id',$value->id)->first(); 

                      if($images != "")
                      {
                       // $result['image'] = $new.'/public/carImage/'.$images->img_name;

                         if(file_exists(public_path('carImage/thumb_'.$images->img_name))){

                            $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;

                         }else{
                            $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;                            
                         }

                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.carSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
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
            


            $results = DB::table('car')->join('fueltype','fueltype.id','=','car.fueltype','left')->join('car_model','car_model.id','=','car.prop_category','left')->join('car_brand','car_brand.id','=','car.car_brand','left')->join('car_types','car_types.id','=','car.pro_type','left')->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName')->where('car.userType',2)->where('car.showRoomId',$post['adminId'])->orderby('car.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
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
                    $result['name'] = $value->car_name;
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
                 
                      $images=  DB::table('car_img')->select()->where('car_id',$value->id)->first(); 

                      if(!empty($images))
                      {

                         if(file_exists(public_path('carImage/thumb_'.$images->img_name))){
                              $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;    
                         }else{
                            $result['image'] = $new.'/public/carImage/'.$images->img_name;    
                         }
                        
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                }

                $response = array('success' => 1, 'message' => trans('labels.carSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
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

                        $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $value->image);

                            // echo base_path($value->image);
                        if(file_exists(base_path($newimg)))
                        {
                            $result['image'] = url($newimg);    
                         }else{
                             $result['image'] =url($value->image);
                         }
                      
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
            
            $results = DB::table('car')->select('car.*','car_brand.name as carBrand','car_brand.id as carbrandId','car_types.name as typename','car_model.name as modelName','car_model.id as modelId','fueltype.name as fueltypeName','fueltype.id as fueltypeId','city.name as cityName','city.id as cityId')
              ->join('car_brand','car_brand.id','=','car.car_brand','left')
              ->join('city','city.id','=','car.city','left')
              ->join('fueltype','fueltype.id','=','car.fueltype','left')
              ->join('car_types','car.pro_type','=','car_types.id','left')
              ->join('car_model','car.prop_category','=','car_model.id','left')              
              ->where('car.id',$post['carId'])->orderby('car.id','DESC')->offset($post['startLimit'])->limit(10)->first();
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
                      // $result['yearName'] = $results->year_of_car;                      
                      $result['name'] = $results->car_name;
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


                    $images_name =  DB::table('car_img')->select('*')->where('car_id', $results->id)->first();

                    if(!empty($images_name))
                    {
                        if(file_exists(public_path('carImage/thumb_'.$images_name->img_name))){

                            $proimg = $new.'/public/carImage/thumb_'.$images_name->img_name;
                            $result['carFirstImg'] = $proimg;

                        }else{

                            $proimg = $new.'/public/carImage/'.$images_name->img_name;
                            $result['carFirstImg'] = $proimg;

                        }
                       
                    }
                    else
                    {
                       $result['carFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_img')->select('*')->where('car_id', $results->id)->get();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 

                         if(file_exists(public_path('carImage/thumb_'.$value1->img_name))){

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/thumb_'.$value1->img_name;
                            $img[] =  $img_result;

                        }else{

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/'.$value1->img_name;
                            $img[] =  $img_result; 

                        }

                        
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

                $response = array('success' => 1, 'message' => trans('labels.carSuccessfully'),'result' => $result);
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

  public function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){



         $filename = $source_file;
         $percent = 0.5;

// // Content type
//header('Content-Type: image/jpeg');



// Get new sizes
list($width, $height) = getimagesize($filename);
  $imgsize = getimagesize($source_file);
    $mime = $imgsize['mime'];

     switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
//imagejpeg($thumb);

$image($thumb, $dst_dir, $quality);
 //$imagejpeg($thumb, $dst_dir, $quality);
return;
 // exit;



















        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);

        
}

  public function addCar(Request $request)  // add & edit cars
  { 
        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);
        /*echo "<prE>"; print_r($decode); 
        echo "<prE>"; print_r($request->images); die;*/
        if(empty($post['language'])){
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
              	$car_img = new Car([
                    'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'car_name'=> $car_brand->name,  
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
                $car_img = new Car([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'car_name'=> $car_brand->name, 
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

              $car_img->save();                  
              $proid = DB::getPdo()->lastInsertId();       
              $files = $request->file('images'); 

             // echo "<pre>"   ;print_r( $files);
              if (!empty($files)) {
                foreach($files as $file){
                    $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                    $picture = time() . "." . $image_name;
                    $destinationPath = public_path('carImage/');
                    $file->move($destinationPath, $picture);
    
                    $car_img = new Car_img([
                        'car_id' => $proid,
                        'img_name'=> $picture,
                    ]);
        
                      $car_img->save();

                      $this->resize_crop_image(100, 100, public_path('carImage/'.$picture), public_path('carImage/thumb_'.$picture)); 
                }
              }

              //exit;
               
              $car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
              $car_model = DB::table('car_model')->select('*')->where('id', $decode->model)->first();
              $propr_type = DB::table('car_types')->select('*')->where('id', $decode->type)->first();
              $users = DB::table('users')->select('*')->where('id', $decode->userId)->first();
              $results = DB::table('car')->select('*')->where('id', $proid)->first();
             

            // echo "<pre>";print_r($results);
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
                
                  $images_name =  DB::table('car_img')->select('*')->where('car_id', $proid)->first();

                  if(!empty($images_name))
                  {
                      $proimg = $new.'/public/carImage/'.$images_name->img_name;
                      $result['proImg'] = $proimg;
                  }
                  else
                  {
                     $result['proImg'] = $new.'/public/default-image.jpeg';
                  }
                
                  $allimage =  DB::table('car_img')->select('*')->where('car_id', $proid)->get();

                 // echo "<pre>";print_r( $allimage);
                  foreach ($allimage as $key => $value1)
                  {                    
                    if ($value1->img_name != "") {


                        //echo public_path('carImage/thumb_'.$value1->img_name);
                        //var_dump(file_exists(public_path('carImage/thumb_'.$value1->img_name)));

                       // var_dump(file_exists('http://192.168.1.25/cars/public/carImage/1583399667.tajmahal.jpg'));
                        if(file_exists(public_path('carImage/thumb_'.$value1->img_name))){

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/thumb_'.$value1->img_name;
                            $img[] =  $img_result;

                        }else{

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/'.$value1->img_name;
                            $img[] =  $img_result; 

                        }


                     
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
                
              $success['message'] = trans('labels.addCarSuccessfully');
              $success['success'] = 1;
              $success['result'] = $result;
              echo json_encode($success);exit;
            
            } else { 
            	$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
              if($decode->type==1)  
              {                        
                 $car_img = DB::table('car')->where('id','=',$decode->carId )->update([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'car_name'=> $car_brand->name,
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
                $car_img = DB::table('car')->where('id','=',$decode->carId )->update([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'car_name'=> $car_brand->name,
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
                                
              $files = $request->file('images');
              
                if (!empty($files)) {
                  foreach($files as $file){
                      $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                      $picture = time() . "." . $image_name;
                      $destinationPath = public_path('carImage/');
                      $file->move($destinationPath, $picture);
      
                      $car_img = new Car_img([
                          'car_id' => $decode->carId,
                          'img_name'=> $picture,
                      ]);
          
                        $car_img->save();

                        $this->resize_crop_image(100, 100, public_path('carImage/'.$picture), public_path('carImage/thumb_'.$picture.$image_name)); 
                  }
                }   
                                 
				$car_brand = DB::table('car_brand')->select('*')->where('id', $decode->brand)->first();
	            $car_model = DB::table('car_model')->select('*')->where('id', $decode->model)->first();
	            $propr_type = DB::table('car_types')->select('*')->where('id', $decode->type)->first();
	            $users = DB::table('users')->select('*')->where('id', $decode->userId)->first();
	            $results = DB::table('car')->select('*')->where('id', $decode->carId)->first();
                $image_idArray = DB::table('car_img')->select('*')->where('car_id', $decode->carId)->get();


                //echo "<pre>";print_r($image_idArray);
                //$image_idArray = $request->image_id;

                if(!empty($image_idArray)){

                    foreach($image_idArray as $key=>$carImg){

                         //$carImg = Car_img::findOrFail($value);

                         //echo "<pre>";print_r($carImg);print_r($carImg->img_name);

                        if(file_exists(public_path('/carImage/'.$carImg->img_name))){
                            $this->resize_crop_image(100, 100, public_path('carImage/'.$carImg->img_name), public_path('carImage/thumb_'.$carImg->img_name)); 
                        }
                         //if(!empty($carImg->img_name))
                    }

                }


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
	                
	                  $images_name =  DB::table('car_img')->select('*')->where('car_id', $decode->carId)->first();

	                  if(!empty($images_name))
	                  {
	                      $proimg = $new.'/public/carImage/'.$images_name->img_name;
	                      $result['proImg'] = $proimg;
	                  }
	                  else
	                  {
	                     $result['proImg'] = $new.'/public/default-image.jpeg';
	                  }
	                
	                  $allimage =  DB::table('car_img')->select('*')->where('car_id', $decode->carId)->get();
	                  foreach ($allimage as $key => $value1){    

	                   

                         if ($value1->img_name != "") {

                        if(file_exists(public_path('carImage/thumb_'.$value1->img_name))){

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/thumb_'.$value1->img_name;
                            $img[] =  $img_result;
                             
                        }else{

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/carImage/'.$value1->img_name;
                            $img[] =  $img_result; 

                        }


                     
                    }  

	                  } 

	                  if (!empty($img)) 
	                  { 
	                     $result['carImage'] = $img;
	                  }
	                  else { 
	                    $result['carImage'] = array();
	                  }

	              }

                  $success['message'] = trans('labels.editCarSuccessfully');
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

            $results = DB::table('car')->select()->where('id',$post['carId'])->get();

            if(count($results)>0)
            {     
                $results = DB::table('car')->where('id',$post['carId'])->delete();              
                $response = array('success' => 1, 'message' => trans('labels.carDeleted'));
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

      if((empty($post['brandId'])))
      {
        $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
        echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
      } 
	  
	    App::setLocale($post['language']);  
	    $urlnew = url(''); 
	    $new = str_replace('index.php', '', $urlnew);
	    try
	    {            
	        $results = DB::table('car_model')->select()->where('car_brand_id',$post['brandId'])->where('published',1)->get();          
	        
	        if(count($results) > 0)
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


  public function allYearList(Request $request)  // carList for userType == 1 and only for user
  { 
      $input = file_get_contents('php://input');
      $post = json_decode($input, true);   
      
      if(empty($post['language']))
      {
        $post['language']='en';
      }

      // if((empty($post['modalId'])))
      // {
      //   $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
      //   echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
      // } 
    
      App::setLocale($post['language']);  
      $urlnew = url(''); 
      $new = str_replace('index.php', '', $urlnew);
      try
      {     
           $re= array();  
           $ye =  DB::table('car_year')->get();
           foreach($ye as $val)
           {
              $result['id'] = $val->year;             
              $result['name'] = $val->year;  
              $re[]=$result; 
           }                                                 
          
          if(count($re) > 0)
          {
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
	        $results = DB::table('car_types')->select()->where('published',1)->get();   
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

  public function allCountryList(Request $request)  // typeList for userType == 1 and only for user
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
          $results = DB::table('countries')->select()->get();   
          if(!empty($results))
          {
            $re= array();           
            foreach($results as $value)
            {
              $result['id'] = $value->countries_id;           
              $result['name'] = $value->countries_name; 
           
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

          $results = DB::table('car')->select()->where('id',$post['carId'])->first();
          if(!empty($results))
          {     
              $result = DB::table('car')->where('id','=',$results->id)->update(['published' => $post['published']]);
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

            $user =DB::table('car')->where('id',$post['carId'])->get();           
            if(!empty($user))
            {     
                $result = DB::table('car')->where('id','=',$post['carId'])->update(['isrequested' => 1]);
                $response = array('success' => 1, 'message' => trans('labels.addcarrequest'));
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

                         if(file_exists(public_path('/productImage/thumb_'.$images_name->img_name)))
                         {

                              $proimg = $new.'/public/productImage/thumb_'.$images_name->img_name;
                            $result['proFirstImg'] = $proimg;

                         }else{

                              $proimg = $new.'/public/productImage/'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;

                         }

                      
                    }
                    else
                    {
                       $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                   // echo "<pre>"; print_r($allimage); 
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 

                       

                         if(file_exists(public_path('/productImage/thumb_'.$value1->img_name)))
                         {



                            // $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $value->image);

                           // $result['image'] = url($newimg);  

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/productImage/thumb_'.$value1->img_name;
                            $img[] =  $img_result;

                         }else{
                                $img_result['id'] = $value1->id;
                                $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                                $img[] =  $img_result;
                         }

                         
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
                    // if(!empty($images_name))
                    // {
                    //     $proimg = $new.'/public/productImage/'.$images_name->img_name;
                    //     $result['proFirstImg'] = $proimg;
                    // }
                    // else
                    // {
                    //    $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    // }

                    if(!empty($images_name)){
                    if(file_exists(public_path('/productImage/thumb_'.$images_name->img_name))){


                             $proimg = $new.'/public/productImage/thumb_'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;

                         }else{
                               $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                         }
                    }else{
                         $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                    //echo "<pre>"; print_r($allimage); 
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != "") { 

                        if(file_exists(public_path('/productImage/thumb_'.$value1->img_name))){

                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/productImage/thumb_'.$value1->img_name;
                            $img[] =  $img_result; 



                        }else{


                            $img_result['id'] = $value1->id;
                            $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                            $img[] =  $img_result; 
                        }
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

                   // echo $value->image;
                      if($value->image != '')
                      {


                         $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $value->image);


                        if(file_exists(base_path($newimg)))
                        {
                            $result['image'] =url($newimg);    

                        }else{
                            $result['image'] =url($value->image);    
                        }

                        
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
                          if(file_exists(public_path('/productImage/thumb_'.$images_name->img_name))){

                              $proimg = $new.'/public/productImage/thumb_'.$images_name->img_name;
                                $result['proFirstImg'] = $proimg;    

                          }else{
                            $proimg = $new.'/public/productImage/'.$images_name->img_name;
                        $result['proFirstImg'] = $proimg;    
                          }
                        
                    }
                    else
                    {
                       $result['proFirstImg'] = $new.'/public/default-image.jpeg';
                    }
                  

                    $allimage =  DB::table('car_accessories_img')->select('*')->where('product_id', $value->id)->get();
                    $img = array();
                    foreach ($allimage as $key => $value1)
                    {                    
                      if ($value1->img_name != ""){ 

                            if(file_exists(public_path('/productImage/thumb_'.$value1->img_name))){
                                 $img_result['id'] = $value1->id;
                                $img_result['image'] = $new.'/public/productImage/thumb_'.$value1->img_name;
                                $img[] =  $img_result;  

                            }else{
                                $img_result['id'] = $value1->id;
                                $img_result['image'] = $new.'/public/productImage/'.$value1->img_name;
                                $img[] =  $img_result;     
                            }
                        
                        }else{
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
                    'status'=> 'Pending',  
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
                                     
                 $car_img = DB::table('contact_agent')->where('id','=',$decode->contactId )->update([
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
                    'status'=> 'Pending',  
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
                                     
                 $car_img = DB::table('contact_agent')->where('id','=',$decode->contactId )->update([
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

	        $car_img = DB::table('car_img')->where('id', $id)->where('car_id', $pro_id)->first();
	        
	        if (!empty($car_img)) {

	            $filePath = public_path('carImage/'.$car_img->img_name);
	            unlink($filePath);
	            $car_imgdel = DB::table('car_img')->where('id', $id)->where('car_id', $pro_id)->delete();
	            
	            $response = array('success' => 1, 'message' => trans('labels.carImageDeleteSuccessfully'));
	            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
	            
	            //echo json_encode($success);exit;

	        } else {

	            $response = array('success' => 0, 'message' => trans('labels.carImageNotDelete'));
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
            //$ress->join('car','car.companyId','=','administrators.myid','left');
            //$ress->select('administrators.*');

              if(!empty($post['city']))
              {           
                $ress->where('city',$post['city']);
              }

            $ress->where('issubadmin',4);
            // $ress->where('car.pro_type','=',2);
            $ress->orderby('myid','DESC');
            $ress->offset($post['startLimit']);
            // $ress->distinct('administrators.myid');
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
                    $result['share'] = $new."/companyList/".$value->myid;                

                      if($value->image != '')
                      {
                        $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $value->image);

                        if(file_exists(base_path($newimg)))
                        {
                            $result['image'] =url($newimg);
                        }else{
                            $result['image'] =url($value->image);    
                        }
                        
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
            
             $results = DB::table('administrators')->join('car','car.companyId','=','administrators.myid','inner')->select('administrators.*')->where('administrators.issubadmin',4)->where('car.pro_type','=',1)->orderby('administrators.myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();

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

                        $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $value->image);

                        if(file_exists(base_path($newimg)))
                        {
                            $result['image'] =url($newimg);
                        }else{
                             $result['image'] =url($value->image);
                        }
                       
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


            $results = DB::table('car')->join('car_model','car_model.id','=','car.prop_category','left')->join('car_brand','car_brand.id','=','car.car_brand','left')->join('car_types','car_types.id','=','car.pro_type','left')->join('fueltype','fueltype.id','=','car.fueltype','left')->select('car.*','car_brand.name as carBrand','car_model.name as procategory','car_model.id as catid','car_types.id as typeid','car_types.name as typename','fueltype.name as fueltypeName')->where('car.userType',3)->where('car.companyId',$post['companyId'])->orderby('car.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
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
                    $result['name'] = $value->car_name;
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
                 
                      $images=  DB::table('car_img')->select()->where('car_id',$value->id)->first(); 

                      if(!empty($images))
                      {
                        if(file_exists(public_path('/carImage/thumb_'.$images->img_name)))
                        {
                            $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;     
                        }else{
                            $result['image'] = $new.'/public/carImage/'.$images->img_name;     
                        }
                       
                      }
                      else
                      {
                        $result['image'] = $new.'/public/default-image.jpeg';
                      }            
                      $re[]=$result;
                } 

                $response = array('success' => 1, 'message' => trans('labels.carSuccessfully') ,'totalCount' => count($re) ,'result' => $re);
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

                        $images=  DB::table('car_img')->select()->where('car_id',$add->Product_ID)->first(); 

                      if(!empty($images))
                      {

                        if(file_exists(public_path('/carImage/thumb_'.$images->img_name)))
                        {
                            $result['image'] = $new.'/public/carImage/thumb_'.$images->img_name;     
                        }else{
                             $pla['image'] = $new.'/public/carImage/'.$images->img_name;
                        }
                       
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


  public function RentalorderList(Request $request)  // admin List for userType == 2 and only for adminshowroom
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
             $carBooking1 = ContactAgent::with('hasManyLicense','hasManyUploadId','hasManyCarimage','hasOneCar','hasOneCountry')->where('userId',$post['userId'])->offset($post['startLimit'])->limit(10)->get(); 

            $carBookingcount = ContactAgent::with('hasManyLicense','hasManyUploadId','hasManyCarimage','hasOneCar','hasOneCountry')->where('userId',$post['userId'])->get(); 

          
            if(count($carBooking1)> 0)
            {
             
            $carbook =array();

              foreach($carBooking1 as $carBooking)
              {
                $carbook['licenceImg'] = array();
                $carbook['uploadImg'] = array();
                $carbook['carImg'] = array();
               
                  $firstName = $carBooking->firstName ? $carBooking->firstName : '';
                  $lastName = $carBooking->lastName ? $carBooking->lastName : '';
                  $email = $carBooking->email ? $carBooking->email : '';
                  $phone = $carBooking->phone ? $carBooking->phone : '';
                  $phone = $carBooking->phone ? $carBooking->phone : '';
                  $dateFrom = $carBooking->dateFrom ? $carBooking->dateFrom : '';
                  $status = $carBooking->status ? $carBooking->status : 'Pending';
                  $dateTo = $carBooking->dateTo ? $carBooking->dateTo : '';            
                  $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
                  $carName = $carObj ? $carObj->car_name : ''; 
                  $countryObj = $carBooking->hasOneCountry ? $carBooking->hasOneCountry : '';
                  $countryName = $countryObj ? $countryObj->countries_name : '';
                  $car_name = $carObj ? $carObj->car_name : '' ;
                  $sale_price = $carObj ? $carObj->sale_price : '0' ;
                  $month_rentprice = $carObj ? $carObj->month_rentprice : '0' ;
                  $daily_rentprice = $carObj ? $carObj->daily_rentprice : '0' ; 
                  $carbook['orderId'] =  $carBooking->id;        
                  $carbook['firstName'] = $firstName;
                  $carbookcarbook['lastName'] = $lastName;
                  $carbook['email'] = $email;
                  $carbook['phone'] = $phone;
                  $carbook['dateFrom'] = $dateFrom ? $dateFrom : '0' ;;
                  $carbook['dateTo'] = $dateTo ? $dateTo : '0' ; ;
                  $carbook['carName'] = $carName;
                  $carbook['countryName'] = $countryName;
                  $carbook['status'] = $status;
                  $carbook['car_name'] = $car_name;
                  $carbook['sale_price'] = $sale_price ? $sale_price : '0' ;
                  $carbook['month_rentprice'] = $month_rentprice ? $month_rentprice : '0' ;
                  $carbook['daily_rentprice'] = $daily_rentprice ? $daily_rentprice : '0' ;

                  $licenseObj = $carBooking->hasManyLicense ? $carBooking->hasManyLicense : '';                 
                  if(count($licenseObj))
                  {
                    foreach($licenseObj as $license)
                    {
                      $licenseImage = $license->license ? $license->license : '';
                      $carbook['licenceImg'][]=$new.'/public/driverLicense/'.$licenseImage;
                
                    } 
                  } 
                  else
                  {
                    $carbook['licenceImg'][]=$new.'/public/default-image.jpeg';   
                  }

                  $uploadObj = $carBooking->hasManyUploadId ? $carBooking->hasManyUploadId : '';
                  if(count($uploadObj)){
                    foreach($uploadObj as $uploadImage)
                    { 
                      $uploadImg = $uploadImage->image ? $uploadImage->image : ''; 
                      $carbook['uploadImg'][]=$new.'/public/uploadId/'.$uploadImg;              
                     
                    } 
                  }  
                  else
                  {
                    $carbook['uploadImg'][]=$new.'/public/default-image.jpeg';   
                  }   

                  $carImagedata = $carBooking->hasManyCarimage ? $carBooking->hasManyCarimage : '';

                  if(count($carImagedata)){
                    foreach($carImagedata as $carimg)
                    {                     
                      $carImg = $carimg->img_name ? $carimg->img_name : ''; 

                      if(!empty($carImg)){
                        if(file_exists(public_path('carImage/thumb_'.$carImg))){

                            $carbook['carImg'][]=$new.'/public/carImage/thumb_'.$carImg;
                        } else{

                            $carbook['carImg'][]=$new.'/public/carImage/'.$carImg;

                        } 
                      }
                                           
                    } 
                  }  
                  else
                  {
                    $carbook['carImg'][]=$new.'/public/default-image.jpeg';   
                  }   



                    $carbooknew[]=$carbook;                                        
                }              
            
                // echo "<pre>";
                // print_r($carbooknew); exit;

                $response = array('success' => 1, 'message' => trans('labels.orderlistsucessfully'),'totalCount' => count($carBookingcount),'result' => $carbooknew);
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

  public function Rentalorder(Request $request)  // admin List for userType == 2 and only for adminshowroom
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

        if(empty($post['orderId']))
        {           
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {   
             $carBooking = ContactAgent::with('hasManyLicense','hasManyUploadId','hasOneCar','hasOneCountry')->where('id',$post['orderId'])->first(); 

          
            if(!empty($carBooking))
            {
             

              $firstName = $carBooking->firstName ? $carBooking->firstName : '';
              $lastName = $carBooking->lastName ? $carBooking->lastName : '';
              $email = $carBooking->email ? $carBooking->email : '';
              $phone = $carBooking->phone ? $carBooking->phone : '';
              $dateFrom = $carBooking->dateFrom ? $carBooking->dateFrom : '';
              $dateTo = $carBooking->dateTo ? $carBooking->dateTo : '';
            
              $carObj = $carBooking->hasOneCar ? $carBooking->hasOneCar : '';
              $carName = $carObj ? $carObj->car_name : ''; 
              $countryObj = $carBooking->hasOneCountry ? $carBooking->hasOneCountry : '';
              $countryName = $countryObj ? $countryObj->countries_name : '';

                $carbook =array();
                $carbook['firstName'] = $firstName;
                $carbookcarbook['lastName'] = $lastName;
                $carbook['email'] = $email;
                $carbook['phone'] = $phone;
                $carbook['dateFrom'] = $dateFrom;
                $carbook['dateTo'] = $dateTo;
                $carbook['carName'] = $carName;
                $carbook['countryName'] = $countryName;

                $licenseObj = $carBooking->hasManyLicense ? $carBooking->hasManyLicense : '';                 
                if(count($licenseObj))
                {
                  foreach($licenseObj as $license)
                  {
                    $licenseImage = $license->license ? $license->license : '';
                    $carbook['licenceImg'][]=$new.'/public/driverLicense/'.$licenseImage;
              
                  } 
                } 
                else
                {
                  $carbook['licenceImg'][]=$new.'/public/default-image.jpeg';   
                }

                $uploadObj = $carBooking->hasManyUploadId ? $carBooking->hasManyUploadId : '';
                if(count($uploadObj)){
                  foreach($uploadObj as $uploadImage)
                  { 
                    $uploadImg = $uploadImage->image ? $uploadImage->image : ''; 
                    $carbook['uploadImg'][]=$new.'/public/uploadId/'.$uploadImg;              
                   
                  } 
                }  
                else
                {
                  $carbook['uploadImg'][]=$new.'/public/default-image.jpeg';   
                }                                              
                               
            
                $response = array('success' => 1, 'message' => trans('labels.orderlistsucessfully'),'totalCount' => count($carBooking),'result' => $carbook);
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