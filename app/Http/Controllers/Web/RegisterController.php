<?php 

namespace App\Http\Controllers\Web;

use App\Car;
use App\User;
use App\Car_types;
use App\CarModel;
use App\Usergroup;
use App\Car_img;
use App\ShowRoomAdmin;
use DB;
use App;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Auth;
use Hash;
use Lang;
use Session;
class RegisterController extends Controller
{
    public function index()
    {   //echo 1111; die;
        $data = Session::get('language');
        if(isset($data))
        {
            App::setLocale($data);
            session()->put('locale', $data); 
            Session::put('language', $data);
        } else
        {
            App::setLocale('ar');
            session()->put('locale', 'ar'); 
            Session::put('language', 'ar');
        }
       
        return view('register');
    }

    public function insertuser()
    { 
        $request = Request::instance();
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $checkexists = User::where('username',$username)->orwhere('email',$email)->first();
        if(empty($checkexists)){
            $user = new User([
                
                'username' => $username,
                'name' => $username,
                'email' => $email,
                'password' => md5($password),
                
                ]);

                $user->save();
                Session::put('userName', $username);
                Session::put('userId', $user->id);
                Session::put('email', $email);
                $session = Session::all();
                if(isset($session['rentalRoute'])){

                    $rental = Session('rentalRoute');
                    session()->forget('rentalRoute');
                    return redirect($rental)->with('message', 'Registered successfully');
                }
            return redirect('/')->with('message', 'Registered successfully');
        } else {
            return redirect()->back()->with('message', 'Email and username already exists.');
        }
    }
    public function login()
    {
        return view('login');
    }

    public function checkuserLogin(Request $request){ 
    $request = Request::instance();
    //echo "<pre>"; print_r($request->all()); die;
    //$locale = $request->session()->put('locale', $request['language']); 

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
 
    // $minutes = 60;
    // $response = new Response('Set Cookie');
    // $response->withCookie(cookie('name', 'MyValue', $minutes));
  
    if($validator->fails()){ 
        return redirect('/')->withErrors($validator)->withInput();
    }else{ 
            $email = $request->get('email');
            $password = $request->get('password');
            $users = DB::table('users')->where('email',$email)->where('password',md5($password))->first();                  
           
           if($users)
            { 
                Session::put('userName', $users->username);
                Session::put('userId', $users->id);
                Session::put('email', $users->email);
                $session = Session::all();
                if(isset($session['rentalRoute'])){

                    $rental = Session('rentalRoute');
                    session()->forget('rentalRoute');
                    return redirect($rental)->with('message', 'Login successfully');
                }
                return redirect('/')->with('message', 'Login successfully');
            }else{ 
              
                return redirect()->back()->with('message', 'Email or password wrong.');
            }
        
        }
    
    }
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
    public function profile()
    {
        $id = Session::get('userId');
        $detail = User::where('id',$id)->first();
        // echo $detail; exit;
        
        return view('profile',compact('detail'));
    }
    public function updateprofile()
    {
        $request = Request::instance();
        //echo '<pre>'; print_r($request->all()); die;
        $id = Session::get('userId');
        $name = $request->get('name');
        $lname = $request->get('lname');
        $email = $request->get('email');
        $username = $request->get('username');
        $dob = $request->get('dob');
        $address = $request->get('address');
        $phone = $request->get('phone');
        $city = $request->get('city');
        $gender = $request->get('gender');

        $updated_at = date('y-m-d h:i:s');
        // DB::enableQueryLog();
        $checkexists = User::where('email',$email)->where('id','!=',$id)->count();
        //echo '<pre>'; print_r($checkexists); die;
        // dd(DB::getQueryLog());
       
        if($checkexists > 0 ){

            return redirect()->back()->with('message', 'Email and username already exists.');
        } else {
       
            $user =array('username' => $username,'name' => $name,'lname' => $lname,'dob' => $dob,'address' => $address,'phone' => $phone,'email' => $email,'updated_at' => $updated_at,'gender' => $gender);

            User::where('id',$id)->update($user);

            return redirect('/');


        }
    }

    public function edituserimage()
    {
        $request = Request::instance();
        $id = Session::get('userId');

        if($request->hasfile('image')) 
        { 
              $file = $request->file('image');
              $extension = $file->getClientOriginalExtension();
              $image_name = str_replace(' ', '-', $file->getClientOriginalName());
              $filename =time().'.'.$image_name;
              $destinationPath = public_path('profileImage/');
              $file->move($destinationPath, $filename);
        }
        
            $data = array('image'=>$filename);
            $dd = DB::table('users')->where('id',$id)->update($data);
            if($dd){
                echo $filename; exit;
            } else {
                echo 0; exit;
            }
    }
    public function changePassword()
    {
        $request = Request::instance();
        $id = Session::get('userId');

        $password = $request->get('password');
        if(!empty($password))
        {
            User::where('id',$id)->update(array('password' => md5($password)));

            echo 1; exit;
        }
    }
}
