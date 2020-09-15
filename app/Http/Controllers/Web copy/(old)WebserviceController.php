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

// use App\User;
// use App\Property;
// use App\Pro_feature;
// use App\Property_img;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class WebserviceController extends Controller
{

  public function applogin()   //for login customer with phone and password
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        
        try
        {           
            if((!isset($post['Device'])) || (!isset($post['Device_Token'])) || (!isset($post['Phone_No'])) || (!isset($post['Password'])))
            {
              $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }
            
            if((empty($post['Device'])) || (empty($post['Device_Token'])) || (empty($post['Phone_No'])) || (empty($post['Password'])))
            {
              $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            
            $phone = $post['Phone_No'];
            $password= md5($post['Password']);

            $results = DB::table('Customer')->select('*')->where('Phone_No','=',$phone)->where('Password','=',$password)->first();  
      
            if(!empty($results))
            {

              $length = '16';
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
   

                $user =DB::table('Customer')->where('Customer_ID',$results->Customer_ID)->update([
                      'Device'     =>   $post['Device'],
                      'Device_Token'     =>   $post['Device_Token'],
                      'Random_Token'     =>   $randomString,
                ]);

                $result = array();
                $result['Customer_ID'] = $results->Customer_ID;
                $result['Name'] = $results->Name;
                $result['Phone_No'] = $results->Phone_No;
                $result['Email_ID'] = $results->Email_ID;
                $result['Random_Token'] = $randomString;
                $result['OTP'] = $results->OTP;
                $result['Phone_Activation'] = $results->Phone_Activation;
                $result['State'] = $results->State;
                $result['Gender'] = $results->Gender;               
                $result['idcard'] = $new.'/public/CustomerImage/'.$results->idcard;               
                $result['licence'] = $new.'/public/CustomerImage/'.$results->licence;               
                
                if ($results->Picture != "") {
                    $result['Picture']=$new.'/public/profileImage/'.$results->Picture;  
                } else {
                    $result['Picture']= $new.'/public/default-image.jpeg';  
                }               
                        
                  
                $response = array('success' => 1, 'message' => 'العميل مسجل بنجاح' ,'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'الهاتف وكلمة المرور غير صالحين');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function registration()  //api registration
  { 
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);  
       

        try
        {           
            $device=$post['Device'];
            $deviceToken=$post['Device_Token'];
            $username=$post['Name'];
            $email=$post['Email_ID'];
            $password=md5($post['Password']);
            $phone=$post['Phone_No'];            
           

            if((!isset($device)) || (!isset($deviceToken)) || (!isset($email)) || (!isset($password)) || (!isset($phone)) || (!isset($username))){
                $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            if((empty($device)) || (empty($deviceToken)) || (empty($email)) || (empty($password)) || (empty($phone)) || (!isset($username))){
                $response = array('success' => 0, 'message' =>'يرجى ملء جميع المطلوبة');
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }

            $checkusername = DB::table('Customer')->select('*')->where('Phone_No','=',$phone)->first();
            if (!empty($checkusername)) {
                $response = array('success' => 0, 'message' => 'الهاتف موجود بالفعل');
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }


            //$sixotp = mt_rand(100000, 999999);
            $sixotp = '0000';


            $Customer_ID = DB::table('Customer')->insertGetId([
                'Name' => $username,
                'Email_ID' => $email,
                'password'=> $password,
                'Device'=>$device,
                'Device_Token'=>$deviceToken,
                'Phone_No'=>$phone,
                'OTP'=>$sixotp,
                'Phone_Activation'=>0,
                'State'=>'1'
            ]);         

     
                   
            $results = DB::table('Customer')->select('*')->where('Customer_ID','=',$Customer_ID)->first();        

              if(!empty($results))
              {
                $result = array();
                $result['Customer_ID'] = $results->Customer_ID;
                $result['Name'] = $results->Name;
                $result['Phone_No'] = $results->Phone_No;
                $result['Email_ID'] = $results->Email_ID;
                $result['OTP'] = $results->OTP;
                $result['Phone_Activation'] = $results->Phone_Activation;
                $result['State'] = $results->State;
                $result['idcard'] = $new.'/public/CustomerImage/'.$results->idcard;
                $result['licence'] = $new.'/public/CustomerImage/'.$results->licence;

                
                if ($results->Picture != "") {
                    $result['Picture']=$new.'/public/profileImage/'.$results->Picture;  
                } else {
                    $result['Picture']= $new.'/public/default-image.jpeg';  
                }     


                // $string = "Dear ".$username.", Welcome to yakfeek, Here is your verification code: ".$code;
                // $smsurl =file_get_contents("https://www.hisms.ws/api.php?send_sms&username=966598531634&password=M7md1634&numbers=9537779595&sender=966598531634&message=".$string."&date=2019-10-05&time=24:01");

                //  if($smsurl=="3")   // SMS has been sent
                //  {
                //     $msg = "SMS has been sent";
                //  }
                //  else  // SMS has not been sent.
                //  {
                //     $msg = "SMS has not been sent";
                //  }         
          
                        
                  $response = array('success' => 1, 'message' => 'تم إرسال رمز التحقق بنجاح','result' => $result );
                  echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

              }
                      
        }
        catch(Exception $e){

          $response = array('success' => 0, 'message' => $e->getMessage());
          echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

        }   

  }

  function checkrandomToken($id,$randomToken)
  {
    return  DB::table('Customer')->select('*')->where('Customer_ID','=',$id)->where('Random_Token','=',$randomToken)->first();  
  }


  public function customerDetail()   //for customer detail
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        $headers = apache_request_headers();

        
        try
        {           
            if(!isset($post['Customer_ID']))
            {
              $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }     
           // echo $headers['Authorization']; exit;
            $tokenCount = $this->checkrandomToken($post['Customer_ID'],$headers['Authorization']);
               
            if(empty($tokenCount))
            {
              $response = array('success' => 0, 'message' => 'مستخدم غير صالح');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            $results = DB::table('Customer')->select('*')->where('Customer_ID','=',$post['Customer_ID'])->first();  
      
            if(!empty($results))
            {
                  $result = array();
                  $result['Customer_ID'] = $results->Customer_ID;
                  $result['Name'] = $results->Name;
                  $result['Phone_No'] = $results->Phone_No;
                  $result['Email_ID'] = $results->Email_ID;
                  $result['State'] = $results->State;
                  $result['idcard'] = $new.'/public/CustomerImage/'.$results->idcard;
                  $result['licence'] = $new.'/public/CustomerImage/'.$results->licence;
                  
                  if ($results->Picture != "") {
                      $result['Picture']=$new.'/public/profileImage/'.$results->Picture;  
                  } else {
                      $result['Picture']= $new.'/public/default-image.jpeg';  
                  }               
              
                  $result['Gender'] = $results->Gender;
                  $result['Phone_Activation'] = $results->Phone_Activation;                         
                  $result['BirthDate'] = $results->BirthDate;                  
                $response = array('success' => 1, 'message' => 'العميل مسجل بنجاح' ,'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'الهاتف وكلمة المرور غير صالحين');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function serviceList()   //for service List
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        
        try
        {    $results = DB::table('Services')->select('*')->where('State','=',"1")->get();            
            if(!empty($results))
            {
              $all = array();
              foreach($results as $val)
              {

                $result['Service_ID'] = $val->Service_ID;
                $result['Name'] = $val->Name;
           
                
                if ($val->Picture != "") {
                    $result['Picture']=$new.'/public/ServiceImage/'.$val->Picture;  
                } else {
                    $result['Picture']= $new.'/public/default-image.jpeg';  
                } 
                $all[]=$result;            
              }                           
                  
                $response = array('success' => 1,'totalCount'=>count($results), 'message' => 'الحصول على قائمة الخدمة بنجاح' ,'result' => $all);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'البيانات غير متوفرة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function requestService(Request $request)  // edit student image
  {
    try
    {

      $post = $request->all();        
      if(empty($post['json_content']))
      {
        $arr = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }
      $decode = json_decode($post['json_content']);
 
      if(empty($decode->userId))
      {
        $arr = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة'); 
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }


      if(empty($decode->serviceId))
      {
        $arr = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة'); 
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }  

      if(empty($decode->description))
      {
        $arr = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة'); 
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      } 

      if(empty($post['image']))
      {
        $arr = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }
          $files = $request->file('image'); 
          if(!empty($post['image']))
          {                      
              $image_name = str_replace(' ', '-', $files->getClientOriginalName());
              $picture = time() . "." . $image_name;
              $destinationPath = public_path('RequestImage/'); // upload path
              $files->move($destinationPath, $picture);
              $image =$picture;
          }

          $service_id = DB::table('Request_Service')->insertGetId([
              'Description'=>   $decode->description,
              'Image'      =>   $image,
              'User_ID'    =>   $decode->userId,
              'Service_ID' =>$decode->serviceId

          ]);   

      if($service_id)
      {              
          $arr = array('success' => 1, 'message' => 'إضافة طلب خدمة بنجاح');
          echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }        
      else 
      {
        $arr = array('success' => 0, 'message' => 'البيانات غير متوفرة');
        echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
      }  
    }
    catch (Exception $e) 
    {
      $arr = array('success' => 0, 'message' => $e->getMessage());
      echo json_encode($arr,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;

    }
  }


  public function updateProfile(Request $request)   // edit user profile
  {

        $post = $request->all();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);

          $userId=$decode->Customer_ID;
          $username=$decode->Name;
          $email=$decode->Email;
          $phone=$decode->Phone_No;  
          $gender=$decode->Gender;  
          $birthDate=$decode->BirthDate; 
        
        try
        {           
            if((empty($userId)) || (empty($username)) || (empty($email)) || (empty($phone)) || (empty($gender)) || (empty($birthDate)))
            {
              $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }     

            $phoneexist = DB::table('Customer')->select('*')->where('Phone_No','=',$phone)->where('Customer_ID','!=',$userId)->first();  
            if(!empty($phoneexist))
            {
              $response = array('success' => 0, 'message' => 'رقم الهاتف موجود بالفعل');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }   
              

            $results = DB::table('Customer')->select('*')->where('Customer_ID','=',$userId)->first();        
          
            if(!empty($results))
            {
                
                if(!empty($post['image']))
                {   
                    $file = $request->file('image'); 
                    $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                    $picture = time() . "." . $image_name;
                    $destinationPath = public_path('CustomerImage/');
                    $file->move($destinationPath, $picture); 

                    $user =DB::table('Customer')->where('Customer_ID',$userId)->update([
                        'Picture'     =>   $picture
                    ]);
                }

                $newcust = DB::table('Customer')->where('Customer_ID','=',$userId)->update([
                  'Name' => $username,
                  'Email_ID' => $email,
                  'Phone_No'=>$phone,
                  'Gender'=>$gender,
                  'BirthDate'=>$birthDate

                ]);  

                   $results = DB::table('Customer')->select('*')->where('Customer_ID','=',$userId)->first();        
          
                  if(!empty($results))
                  {
                    $result = array();
                    $result['Customer_ID'] = $results->Customer_ID;
                    $result['Name'] = $results->Name;
                    $result['Phone_No'] = $results->Phone_No;
                    $result['Email_ID'] = $results->Email_ID;
                    
                    if ($results->Picture != "") {
                        $result['Picture']=$new.'/public/CustomerImage/'.$results->Picture;  
                    } else {
                        $result['Picture']= $new.'/public/default-image.jpeg';  
                    }             
                    
                    $result['Gender'] = $results->Gender;             
                    $result['BirthDate'] = $results->BirthDate;
                    $result['State'] = $results->State;                                    
                    $result['licence'] = $new.'/public/CustomerImage/'.$results->licence;                                    
                    $result['idcard'] = $new.'/public/CustomerImage/'.$results->idcard;                                    
                   
                  
                    $response = array('success' => 1, 'message' => 'تم تحديث الملف الشخصي بنجاح' , 'result' => $result);
                    echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
                  } 
                  else
                  {
                    $response = array('success' => 0, 'message' =>'لم يتم تحديث الملف الشخصي بنجاح');
                    echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
                  }
            }
            else
            {
              $response = array('success' => 0, 'message' => 'لم يتم تحديث الملف الشخصي بنجاح');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function verifyOtp(Request $request)   // edit user profile
  {   
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);       
        
        try
        {           
            if((empty($post['OTP'])))
            {
              $response = array('success' => 0, 'message' =>'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }    

            if((empty($post['Phone_No'])))
            {
              $response = array('success' => 0, 'message' =>'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }     
               
            $results = DB::table('Customer')->select('*')->where('Phone_No','=',$post['Phone_No'])->where('OTP','=',$post['OTP'])->first();        
          
            if(!empty($results))
            {

  

              $length = '16';
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
   
                $cafeteria = DB::table('Customer')->where('Phone_No','=',$post['Phone_No'])->update([
                  'Phone_Activation' => '1',
                  'Random_Token'     =>   $randomString,
                ]); 


                $result = array();
                $result['Customer_ID'] = $results->Customer_ID;
                $result['Name'] = $results->Name;
                $result['Phone_No'] = $results->Phone_No;
                $result['Email_ID'] = $results->Email_ID;
                $result['Random_Token'] = $randomString;
                $result['OTP'] = $results->OTP;
                $result['Phone_Activation'] = $results->Phone_Activation;
                $result['State'] = $results->State;
                $result['Gender'] = $results->Gender;               
                
                if ($results->Picture != "") {
                    $result['Picture']=$new.'/public/profileImage/'.$results->Picture;  
                } else {
                    $result['Picture']= $new.'/public/default-image.jpeg';  
                }               
                                 
                     
                $response = array('success' => 1, 'message' => 'الحصول على رمز التحقق بنجاح', 'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;               
            }
            else
            {
              $response = array('success' => 0, 'message' => 'رمز التحقق غير صحيح');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function resentOtp(Request $request)   // edit user profile
  {   
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);       
        
        try
        {           
            if((empty($post['Phone_No'])))
            {
              $response = array('success' => 0, 'message' =>'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }     
               
            $results = DB::table('Customer')->select('*')->where('Phone_No','=',$post['Phone_No'])->first();        
          
            if(!empty($results))
            {

               $cafeteria = DB::table('Customer')->where('Phone_No','=',$post['Phone_No'])->update([
                  'OTP' => '0000'
                ]); 

                $result = array();
                $result['Phone_No'] = $results->Phone_No;
                $result['OTP'] = $results->OTP;
                $result['Phone_Activation'] = $results->Phone_Activation;
                      
                     
                $response = array('success' => 1, 'message' => 'الحصول على رمز التحقق بنجاح', 'result' => $result);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;               
            }
            else
            {
              $response = array('success' => 0, 'message' => 'رمز التحقق غير صحيح');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function offerList()   //for offer List
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        
        try
        {    $results = DB::table('Offer')->select('*')->get();            
            if(!empty($results))
            {
              $all = array();
              foreach($results as $val)
              {

                $result['Offer_ID'] = $val->Offer_ID;
                $result['Title'] = $val->Title;
                if($val->Type=='1')
                {
                  $result['Type'] ='عام';
                }
                else
                {
                  $result['Type'] = 'خاص'; 
                }
                
                $result['Discount'] = $val->Discount;
                $result['Description'] = $val->Description;
                $result['Start_Date'] = $val->Start_Date;
                $result['End_Date'] = $val->End_Date;          
                
               
                $all[]=$result;            
              }                           
                  
                $response = array('success' => 1,'totalCount'=>count($results), 'message' => 'الحصول على قائمة العروض بنجاح' ,'result' => $all);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'البيانات غير متوفرة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }

  public function couponList()   //for Coupon List
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        
        try
        {    $results = DB::table('Coupon')->select('*')->get();            
            if(!empty($results))
            {
              $all = array();
              foreach($results as $val)
              {

                $result['Coupon_ID'] = $val->Coupon_ID;
                $result['Code'] = $val->Code;
                $result['Name'] = $val->Name;
                
                if($val->Type=='1')
                {
                  $result['Type'] ='عام';
                }
                else
                {
                  $result['Type'] = 'خاص'; 
                }

                $result['Discount'] = $val->Discount;
                $result['Start_Date'] = $val->Start_Date;
                $result['End_Date'] = $val->End_Date;               
       
                $all[]=$result;            
              }                           
                  
                $response = array('success' => 1,'totalCount'=>count($results), 'message' => 'الحصول على قائمة القسيمة بنجاح' ,'result' => $all);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'البيانات غير متوفرة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }


  public function driverregister(Request $request){

        $post = $request->all();

        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);         
        $decode = json_decode($post['json_content']);
        // echo "<pre>";print_r($decode);exit;
        $result = [];
        $customerId = '';
        if(!empty($decode)){
            $customerId=$decode->customerId;
        }
        try
        {           
            if(empty($customerId))
            {
              $response = array('success' => 0, 'message' => 'يرجى ملء جميع المطلوبة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
            }     

            if(!empty($post['idcard']))
            {   
                $file = $request->file('idcard'); 
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $idcard = time() . "." . $image_name;
                $destinationPath = public_path('CustomerImage/');
                $file->move($destinationPath, $idcard); 

                $user =DB::table('Customer')->where('Customer_ID',$customerId)->update([
                    'idcard'     =>   $idcard
                ]);
            }

            if(!empty($post['licence']))
            {   
                $file = $request->file('licence'); 
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $licence = time() . "." . $image_name;
                $destinationPath = public_path('CustomerImage/');
                $file->move($destinationPath, $licence); 

                $user =DB::table('Customer')->where('Customer_ID',$customerId)->update([
                    'licence'     =>   $licence
                ]);

            }

            $user = DB::table('Customer')->where('Customer_ID','=',$customerId)->update([
              'State' => '3'
            ]);  

            $selectUser = DB::table('Customer')->select('*')->where('Customer_ID',$customerId)->get()->first();
          if(!empty($selectUser)){
              $result['licence'] = $new.'/public/CustomerImage/'.$selectUser->licence;
              $result['idcard'] = $new.'/public/CustomerImage/'.$selectUser->idcard;
              $result['Customer_ID'] = $customerId;
          }

            $response = array('success' => 1, 'message' => 'Successfully added','result' => $result);
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }      
          
  }

/*  public function ActiveService()   //for service List
  {

        $input = file_get_contents('php://input');
        $post = json_decode($input, true);
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
        
        try
        {  

          if((empty($post['userId'])))
          {
            $response = array('success' => 0, 'message' => trans('يرجى ملء جميع المطلوبة'));
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;     
          }     

          $results = DB::table('Request_Service')->select('*')->where('User_ID','=',$post['userId'])->where('State','=',"1")->get();            
            if(count($results) > 0)
            {
              $all = array();
              foreach($results as $val)
              {

                $result['Service_ID'] = $val->Service_ID;
                $result['Name'] = $val->Name;
                $result['Description'] = $val->Description;
           
                
                if ($val->Picture != "") {
                    $result['Image']=$new.'/public/ServiceImage/'.$val->Picture;  
                } else {
                    $result['Image']= $new.'/public/default-image.jpeg';  
                } 
                $all[]=$result;            
              }                           
                  
                $response = array('success' => 1,'totalCount'=>count($results), 'message' => 'الحصول على قائمة الخدمة بنجاح' ,'result' => $all);
                echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
            else
            {
              $response = array('success' => 0, 'message' => 'البيانات غير متوفرة');
              echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
            }
        
        }
        catch(Exception $e)
        {
            $response = array('success' => 0, 'message' => $e->getMessage());
            echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
        }   
    
  }*/


  // public function UnactiveService()   //for service List
  // {

  //       $input = file_get_contents('php://input');
  //       $post = json_decode($input, true);
  //       $urlnew = url(''); 
  //       $new = str_replace('index.php', '', $urlnew);
        
  //       try
  //       {    $results = DB::table('Services')->select('*')->where('State','=',"1")->get();            
  //           if(!empty($results))
  //           {
  //             $all = array();
  //             foreach($results as $val)
  //             {

  //               $result['Service_ID'] = $val->Service_ID;
  //               $result['Name'] = $val->Name;
           
                
  //               if ($val->Picture != "") {
  //                   $result['Picture']=$new.'/public/ServiceImage/'.$val->Picture;  
  //               } else {
  //                   $result['Picture']= $new.'/public/default-image.jpeg';  
  //               } 
  //               $all[]=$result;            
  //             }                           
                  
  //               $response = array('success' => 1,'totalCount'=>count($results), 'message' => 'الحصول على قائمة الخدمة بنجاح' ,'result' => $all);
  //               echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
  //           }
  //           else
  //           {
  //             $response = array('success' => 0, 'message' => 'البيانات غير متوفرة');
  //             echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
  //           }
        
  //       }
  //       catch(Exception $e)
  //       {
  //           $response = array('success' => 0, 'message' => $e->getMessage());
  //           echo json_encode($response,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE|JSON_HEX_AMP);exit;
  //       }   
    
  // }




/* 
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
               
                mail($sendmail['email'],$subject,$message,$hedaer);                 
            
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
    
  }*/


}