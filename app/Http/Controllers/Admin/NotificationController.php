<?php 

namespace App\Http\Controllers\Admin;

use App\Car_types;
use App\User;
use App\ShowRoomAdmin;
use App\Company;
use App\StoreAdmin;
/*use App\Template;
use App\User;*/
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
// use App\Http\Requests\Admin\StorePropertyRequest;
// use App\Http\Requests\Admin\UpdatePropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        //$city= DB::table('city')->paginate(10);

        return view('admin.notification.index');
    }

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'name',
                            
                        );
  
        $totalData = DB::table('city')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  DB::table('city')->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('city')->where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else 
        {            
            $posts = DB::table('city')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['options'] = "&emsp;<a href='city/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='city/$post->id'>";
                $nestedData['options'] .=  csrf_field();
                $nestedData['options'] .= method_field("DELETE");
                $nestedData['options'] .=  "<button class='btn btn-danger' onclick='return ConfirmDelete()'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                    </form>";
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->request->get('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        
        echo json_encode($json_data); 
        
    }


   
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user = User::select('id','username')->get();
        $ShowRoomAdmin = ShowRoomAdmin::where('issubadmin',2)->select('myid','first_name')->get();
        $StoreAdmin = ShowRoomAdmin::where('issubadmin',3)->select('myid','first_name')->get();
        $company = ShowRoomAdmin::where('issubadmin',4)->select('myid','first_name')->get();

   
        return view('admin.notification.create',compact('user','ShowRoomAdmin','company','StoreAdmin'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function save()
    {


        $request = Request::instance();
            
            if ($request['type'] == 1) {
              //$user = DB::table('users')->whereIn('id',$request->user)->get();  
              // echo "<pre>";
              // print_r($request->user); exit;

              if ($request->user[0] == "alluser") { //echo 111111; die;
                    
                    
                   $results = DB::table('userdevicetoken')->get();        

                  $url = 'https://fcm.googleapis.com/fcm/send';
                    foreach ($results as $key => $value) {

                      // echo "<pre>";
                      // print_r($value); exit;

                          // $allusers = DB::table('users')->where('deviceToken',$value->deviceToken)->get();   
                        $usernot = DB::table('notification')->insertGetId([
                          'deviceToken'=>$value->deviceToken,
                          'notification' => $request->notification,
                          'status' => 0,
                        ]);
                    
                        $id = $value->deviceToken;    
                        // echo $id; die;   
                        if($value->device==1)
                        {        
                            $fields = array (
                            'registration_ids' => array ($id),
                            'data' => array (
                            "title" => "Iraq Car Notification",
                            "message" => $request->notification,
                            "notificationId" => $usernot,
                            "status" => 0,
                            )
                          );
                        }
                        else
                        {      
                            $fields = array (
                            'registration_ids' => array ($id),
                            'notification' => array (
                            "sound" => "default",
                            "title" => "Iraq Car Notification",
                            "body" => $request->notification,
                            "message" => $request->notification,
                            "notificationId" => $usernot,
                            "status" => 0,
                            )
                          );
                        }

                        $fields = json_encode ($fields);
                        // echo '<pre>'; print_r($fields); die;

                        $headers = array (
                        'Authorization: key='."AAAAikAV4iE:APA91bEXI-RYlyBANw-pvd8AWD-EvADf0vq1k32EfTKyizD9LZ2uh6atKyBi0JhPMeAxY5tJkViogjAFruJknzwDhkG8azZXCrXc9gC6_n9DngKJVDbUkCmeLNwXX28p9AYpcgN52xza",
                        'Content-Type: application/json'
                        );

                        $ch = curl_init ();
                        curl_setopt ( $ch, CURLOPT_URL, $url );
                        curl_setopt ( $ch, CURLOPT_POST, true );
                        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
                        $result = curl_exec ( $ch );
                         // echo '<pre>'; print_r($result); die;        
                            curl_close ( $ch );
                  
                  }

            
                  
                        

              } else { //echo 22222; die;

                     $user = DB::table('users')->whereIn('id',$request->user)->get();    
                    //echo "<pre>"; print_r($user); die;
                      $url = 'https://fcm.googleapis.com/fcm/send';
                      foreach ($user as $key => $value) { 

                        $usernot = DB::table('notification')->insertGetId([
                          'notification' => $request->notification,
                          'deviceToken'=> $value->deviceToken,
                          'status' => 0,
                        ]);

                        $id = $value->deviceToken;       
                        if($value->device==1)
                        {             
                            $fields = array (
                          'registration_ids' => array ($id),
                            'data' => array (
                            "title" => "Iraq Car Notification",
                            "message" => $request->notification,
                            "notificationId" => $usernot,
                            "status" => 0,
                            )
                          );
                        }
                        else
                        {               
                            $fields = array (
                          'registration_ids' => array ($id),
                            'notification' => array (
                            "sound" => "default",
                            "title" => "Iraq Car Notification",
                            "body" => $request->notification,
                            "message" => $request->notification,
                            "notificationId" => $usernot,
                            "status" => 0,
                            )
                          );
                        }

                          $fields = json_encode ($fields);

                          $headers = array (
                          'Authorization: key='."AAAAikAV4iE:APA91bEXI-RYlyBANw-pvd8AWD-EvADf0vq1k32EfTKyizD9LZ2uh6atKyBi0JhPMeAxY5tJkViogjAFruJknzwDhkG8azZXCrXc9gC6_n9DngKJVDbUkCmeLNwXX28p9AYpcgN52xza",
                          'Content-Type: application/json'
                          );

                          $ch = curl_init ();
                          curl_setopt ( $ch, CURLOPT_URL, $url );
                          curl_setopt ( $ch, CURLOPT_POST, true );
                          curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                          curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                          curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
                          $result = curl_exec ( $ch );
                                       
                              curl_close ( $ch );    


                    }
              }


            } elseif($request['type'] == 2) {

            	if ($request->ShowRoomAdmin[0] == "allshowRoomAdmin") {

	              $ShowRoomAdmin = DB::table('administrators')->where('issubadmin',2)->get();  
	              
	              foreach ($ShowRoomAdmin as $key => $value) {
	                  Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
	                   
	                  $m->from('harmistest@gmail.com', 'Iraq Car');

	                  $m->to($value->email)->subject('Iraq Car');
	                  
	                  });
	                }
	            }else {

	              $ShowRoomAdmin1 = DB::table('administrators')->whereIn('myid',$request->ShowRoomAdmin)->where('issubadmin',2)->get();  
	              
	              foreach ($ShowRoomAdmin1 as $key => $value) {
	                  Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
	                   
	                  $m->from('harmistest@gmail.com', 'Iraq Car');

	                  $m->to($value->email)->subject('Iraq Car');
	                  
	                  });
	                }

	            }

            } elseif($request['type'] == 3) {

            	if ($request->StoreAdmin[0] == "allshowRoomAdmin") {

	                $StoreAdmin = DB::table('administrators')->where('issubadmin',3)->get();  
	              
	                foreach ($StoreAdmin as $key => $value) {
	                  Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
	                   
	                  $m->from('harmistest@gmail.com', 'Iraq Car');

	                  $m->to($value->email)->subject('Iraq Car');
	                  
	                  });
	                }
	            } else {

	            	$StoreAdmin1 = DB::table('administrators')->whereIn('myid',$request->StoreAdmin)->where('issubadmin',3)->get();  
	              
	                foreach ($StoreAdmin1 as $key => $value) {
	                  Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
	                   
	                  $m->from('harmistest@gmail.com', 'Iraq Car');

	                  $m->to($value->email)->subject('Iraq Car');
	                  
	                  });
	                }

	            }

            } elseif($request['type'] == 4) {
            	// echo '<pre>'; print_r($request->all()); die;

            	if ($request->company[0] == "allcompany") {
              		$company = DB::table('administrators')->where('issubadmin',4)->get();  
              
              		foreach ($company as $key => $value) {
                  	Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
                   
                  	$m->from('harmistest@gmail.com', 'Iraq Car');

                 	 $m->to($value->email)->subject('Iraq Car');
                  
                 		});
              		}
              	} else {
              		$company1 = DB::table('administrators')->whereIn('myid',$request->company)->where('issubadmin',4)->get();  
              
              		foreach ($company1 as $key => $value) {
                  	Mail::send('notification_mail', ['posts' => $request->all()], function ($m) use ($value) {
                   
                  	$m->from('harmistest@gmail.com', 'Iraq Car');

                 	 $m->to($value->email)->subject('Iraq Car');
                  
                 		});
              		}
              	}	
            }  
              
              

        return redirect('admin/notification/create')->with('message', 'notification send');

    }

    public function store(StoreUsersRequest $request)
    {

        $user = User::create($request->all());
         User::where('id', $user->id)->update(['password' => md5($request->password) ]); 
         return redirect('/admin/users')->with('message', 'New User created successfully');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        
        $city = DB::table('city')->where('id',$id)->first();  
        
        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_city(Request $request,$id)
    {
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $name = $request->input('name');
        $city =  DB::table('city')->where('id',$id)->update(array('name'=>$name));
        
        return redirect('/admin/city')->with('message', 'User Edited successfully');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo 1111; die;
     
        DB::table('city')->where('id',$id)->delete();

        return redirect('/admin/city')->with('message', 'City Deleted successfully');
      
    }

    public function userexist()
    {
        $name = Request::input('name');
        $user = User::userexist($name); 
        if(!empty($user))
        {
            $val="1";
        }
        else
        {
            $val="0";
        }


        return response()->json(array('val'=> $val), 200);
        
    }

    public function cityalldelete(Request $request)
    { 
        $request = Request::instance();
     
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        foreach ($ids as $entry) {
         DB::table('city')->whereIn('id', $ids)->delete();
            }
    }



    public function alldelete()
    {   
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = Car_types::whereIn('id', $ids)->get();
   
            foreach ($entries as $entry) {
                $entry->delete();
            }
    }
  
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    

}
