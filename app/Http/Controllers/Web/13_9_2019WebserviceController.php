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
                'gender'=> ""
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

        /*if(empty($post['latitude']))
        {           
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }

        if(empty($post['longitude']))
        {           
          $response = array('success' => 0, 'message' => trans('labels.pleasefillallrequired'));
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;  
        }*/

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        try
        {
            
            $results = DB::table('properties')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename')->where('properties.published',1)->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
  			   //echo "<pre>"; print_r($results); die;
            if(!empty($results))
            {
              $re= array();
              $result = array();       
               
                foreach($results as $value)
                {                           
             
                    $result['id'] = $value->id;
                    $result['name'] = $value->property_name;
                    $result['carBrandId'] = $value->car_brand;
                    $result['carBrand'] = $value->carBrand;
                    $result['modelId'] = $value->catid;
                    $result['carModel'] = $value->procategory;
                    $result['address'] = $value->address;
                    $result['specification'] = $value->specification;
                    $result['kilometer'] = $value->kilometer;
                    $result['salePrice'] = $value->sale_price;
                    $result['monthRent'] = $value->month_rentprice;
                    $result['description'] = $value->description;
                    $result['userId'] = $value->userId;
                    $result['showRoomId'] = $value->showRoomId;
                    $result['typeId'] = $value->typeid;
                    $result['carType'] = $value->typename;
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
            
            $results = DB::table('properties')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename')->where('properties.userType',1)->where('properties.userId',$post['userId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
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
                    $result['specification'] = $value->specification;
                    $result['kilometer'] = $value->kilometer;
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
            


            $results = DB::table('properties')->join('property_category','property_category.id','=','properties.prop_category','left')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','property_types.id','=','properties.pro_type','left')->select('properties.*','car_brand.name as carBrand','property_category.name as procategory','property_category.id as catid','property_types.id as typeid','property_types.name as typename')->where('properties.userType',2)->where('properties.showRoomId',$post['adminId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->paginate();
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

                      if(count($images) > 0)
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
            
            $results = DB::table('administrators')->where('issubadmin',2)->orderby('myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();

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
            
            $results = DB::table('properties')->select('properties.*','car_brand.name as carBrand','property_types.name as typename','property_category.name as modelName')->join('car_brand','car_brand.id','=','properties.car_brand','left')->join('property_types','properties.pro_type','=','property_types.id','left')->join('property_category','properties.prop_category','=','property_category.id','left')->where('properties.id',$post['carId'])->orderby('properties.id','DESC')->offset($post['startLimit'])->limit(10)->first();
            //echo "<pre>"; print_r($results); die;
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
                      $result['carBrand'] = $results->carBrand;
                      $result['name'] = $results->property_name;
                      $result['address'] = $results->address;      
                      $result['specification'] = $results->specification;      
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
                      $result['model'] = $results->modelName;
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
            if((empty($post)) || (empty($decode->brand)) ||  (empty($decode->type)) || (empty($decode->userId)) || (empty($decode->model)) || (empty($decode->kilometer)) || (empty($decode->specification)) || (empty($decode->description))  || (empty($decode->location)) || (empty($decode->price))  || (empty($decode->email))  || (empty($decode->phone)) || (!isset($decode->carId)) )
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
                    'specification'=> $decode->specification ? $decode->specification : '' ,  
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
                $property_img = new Property([
                  	'userId' => $decode->userId,                           
                    'pro_type'=> $decode->type ? $decode->type : '' ,  
                    'property_name'=> $car_brand->name, 
                    'car_brand'=> $decode->brand,  
                    'prop_category'=> $decode->model ? $decode->model : '' ,  
                    'kilometer'=> $decode->kilometer ? $decode->kilometer : '' ,  
                    'specification'=> $decode->specification ? $decode->specification : '' ,  
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
                    'specification'=> $decode->specification ? $decode->specification : '' ,  
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
                    'specification'=> $decode->specification ? $decode->specification : '' ,  
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

	                  if(count($images_name) > 0)
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
	              $result['name'] = $value->name; 
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
	            $result['name'] = $value->name; 
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
	            $result['specification'] = $value->specification;  

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
	    //echo "<pre>"; print_r($post); die;
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

	    	$results = DB::table('car_accessories')->select()->where('status',1)->where('store_id',$post['storeId'])->orderby('id','DESC')->offset($post['startLimit'])->limit(10)->paginate();   
	        
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
              $result['storePhone'] = $storeName->phone;
	            $result['storeEmail'] = $storeName->email;
	            $result['categoryId'] = $value->category_id;
	            $result['categoryName'] = $procategory->name;
	            $result['name'] = $value->name;  
	            $result['description'] = $value->description;  
	            $result['price'] = $value->price;  
	            $result['size'] = $value->size;  
	            $result['model'] = $value->model;  
	            $result['color'] = $value->color;  
	            $result['specification'] = $value->specification;  


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


          $user = User::select("users.*","items.id as itemId","jobs.id as jobId")
                  ->join("items","items.user_id","=","users.id")
                  ->join("jobs",function($join){
                      $join->on("jobs.user_id","=","users.id")
                          ->on("jobs.item_id","=","items.id");
                  })
                  ->get();
          print_r($user);



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
	            $result['specification'] = $value->specification;  


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
            
            $results = DB::table('administrators')->where('issubadmin',4)->orderby('myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();

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
            
            $results = DB::table('administrators')->where('issubadmin',4)->orderby('myid','DESC')->offset($post['startLimit'])->limit(10)->paginate();

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





}