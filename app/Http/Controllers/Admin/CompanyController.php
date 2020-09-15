<?php 

namespace App\Http\Controllers\Admin;

use App\User;
use App\Company;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\ShowRoomAdminRequest;
use App\Http\Requests\Admin\updateAdminPassword;
use App\Http\Requests\Admin\updateShowRoomAdminRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Lang;
use Hash;
use Session;
use DB;
use Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $request = Request::instance();
        $Company = Company::where('issubadmin',4)->paginate(10);
        return view('admin.company.index', compact('Company'));
    }

    public function allposts()
    {   

      $request = Request::instance();
       $admin = auth()->guard('admin')->user(); 
       
        $columns = array( 
                            0 =>'myid', 
                            1 =>'myid', 
                            2 =>'user_name',
                            3=> 'email',
                            4=> 'myid',
                        );
  
        $totalData = Company::where('issubadmin',4)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = 'Desc';
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {         
            $search = $request->input('search.value'); 

            $posts =  Company::Where('myid', 'LIKE',"%{$search}%")
                            ->orWhere('first_name', 'LIKE',"%{$search}%")
                            ->orwhere('issubadmin',4)
                            ->orWhere('u_type','=',"{$cat}") 
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Company::where('myid','LIKE',"%{$search}%")
                             ->orWhere('first_name', 'LIKE',"%{$search}%")
                             ->orWhere('u_type','=',"{$cat}") 
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {           
            $search = $request->input('search.value'); 

            $posts =  Company::Where('myid', 'LIKE',"%{$search}%")
                            ->orWhere('first_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            
            $totalFiltered = Company::where('myid','LIKE',"%{$search}%")
                             ->orWhere('first_name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {          
            
            $posts =  Company::Where('u_type','=',"{$cat}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Company::where('u_type','=',"{$cat}")
                            ->count();
        }      
        else
        {         
            $posts = Company::where('issubadmin',4)
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        
        
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
               
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->myid'>";
                $nestedData['myid'] = $post->myid;
                $nestedData['user_name'] = $post->first_name.' '.$post->last_name;
                $nestedData['email'] = $post->email;            
                $nestedData['options'] = "&emsp;<a href='companyAdmin/$post->myid/edit' class='btn btn-primary' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='companyAdmin/$post->myid'>";
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



    public function zones()
    {
        $request = Request::instance();
        
            $zones = DB::table('zones')->where('zone_country_id', '=', $request['zone_val'])->get();
            
            $html = "";
            $html .="<option value>".trans('labels.SelectZone')."</option>";
            foreach ($zones as $zone) {
                $html .="<option value = ".$zone->zone_id.">".$zone->zone_name."</option>";        
            } 
        
        return $html;
        
    }

    public function create()
    {  
        $countries = DB::table('countries')->get();
        $cities = DB::table('city')->get();
        
        $result['countries'] = $countries;
        $result['cities'] = $cities;
        
        return view('admin.company.create')->with('result', $result);
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
}

    
    public function store(Request $request)
    {  
        
       $request = Request::instance();

        $checkemail = Company::where('email',$request['email'])->first();
        
        if ($checkemail != "") { 
            $countries = DB::table('countries')->get();
            $cities = DB::table('city')->get();
            $result['countries'] = $countries;
            $result['cities'] = $cities;
            $message = Lang::get("labels.duplicateEmailaddress");
            return view('admin.company.create',compact('result','message'));
        }

        $updated_at = date('y-m-d h:i:s');
        
        $myVar = new AdminSiteSettingController();
        $languages = $myVar->getLanguages();        
        $extensions = $myVar->imageType();
        
        if ($request->newImage != "") {
            if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
                $image = $request->newImage;
                $fileName = time().'.'.$image->getClientOriginalName();
                $image->move('resources/views/admin/images/admin_profile/', str_replace(' ', '_',$fileName));
                $uploadImage = 'resources/views/admin/images/admin_profile/'.str_replace(' ', '_',$fileName); 

                $this->resize_crop_image(300, 300,  'resources/views/admin/images/admin_profile/'.str_replace(' ', '_',$fileName), 'resources/views/admin/images/admin_profile/thumb_'.str_replace(' ', '_',$fileName));
            }   else{
                $uploadImage = $request->oldImage;
            }   
        } else {
            $uploadImage = '';
        }
        
            
           
        $orders_status = new Company([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'email'         =>  $request->email,
                'password'      =>  Hash::make($request->password),
                'address'       =>  $request->address,
                'description'   =>  $request->description,
                /*'city'          =>  $request->city,*/
                'zip'           =>  $request->zip,
                'country'       =>  $request->country,
                'phone'         =>  $request->phone,
                'image'         =>  $uploadImage,
                'adminType'     =>  '1',
                'issubadmin'    =>  '4',
                'updated_at'    =>  $updated_at
                ]);

        $orders_status->save();
         $id = DB::getPdo()->lastInsertId();

         foreach ($request->city as $value) {
            $cityid = DB::table('showroom_city')->insertGetId([
                'admin_id' => $id,
                'city_id' => $value
            ]);
        } 

        //$message = Lang::get("labels.ProfileUpdateMessage");
        return redirect('admin/companyAdmin');
        
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $ShowRoomAdmin = Company::where('myid',$id)->first();
        $countries = DB::table('countries')->get();
        $cities = DB::table('city')->get();

        $cityid = DB::table('showroom_city')->where('admin_id',$id)->get();

        
        $result['countries'] = $countries;
        $result['cities'] = $cities;

        $setProperty = array();
        
        foreach ($cityid as $value) {
            $setProperty[] = $value->city_id;
        }

        return view('admin.company.edit', compact('ShowRoomAdmin','result','setProperty'));
    }


    public function updateShowRoomAdmin(updateShowRoomAdminRequest $request,$id){
        
        
        $checkemail = Company::where('email',$request['email'])->where('myid','!=',$id)->first();
        
        if ($checkemail != "") { 
            $Company = Company::where('myid',$id)->first();
            $countries = DB::table('countries')->get();
            $cities = DB::table('city')->get();
            $result['countries'] = $countries;
            $result['cities'] = $cities;
            $message = Lang::get("labels.duplicateEmailaddress");
            return view('admin.company.edit',compact('Company','result','message'));
        }

        $updated_at = date('y-m-d h:i:s');
        
        $myVar = new AdminSiteSettingController();
        $languages = $myVar->getLanguages();        
        $extensions = $myVar->imageType();
        
        if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
            $image = $request->newImage;
            $fileName = time().'.'.$image->getClientOriginalName();
            $image->move('resources/views/admin/images/admin_profile/', str_replace(' ', '_',$fileName));
            $uploadImage = 'resources/views/admin/images/admin_profile/'.str_replace(' ', '_',$fileName); 

             $this->resize_crop_image(300, 300,  'resources/views/admin/images/admin_profile/'.str_replace(' ', '_',$fileName), 'resources/views/admin/images/admin_profile/thumb_'.str_replace(' ', '_',$fileName));
        }   else{
             $newimg= str_replace('resources/views/admin/images/admin_profile/', 'resources/views/admin/images/admin_profile/thumb_', $request->oldImage);

            $this->resize_crop_image(300, 300,  $request->oldImage,  $newimg);
            $uploadImage = $request->oldImage;
        }   
        
        $orders_status = DB::table('administrators')->where('myid','=', $id)->update([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'email'         =>  $request->email,
                'address'       =>  $request->address,
                'description'   =>  $request->description,
                // 'city'          =>  $request->city,
                'zip'           =>  $request->zip,
                'country'       =>  $request->country,
                'phone'         =>  $request->phone,
                'image'         =>  $uploadImage,
                'adminType'     =>  '1',
                'issubadmin'    =>  '4',
                'updated_at'    =>  $updated_at
                ]);
        
        foreach ($request->city as $value) {
            $cityid = DB::table('showroom_city')->insertGetId([
                'admin_id' => $id,
                'city_id' => $value
            ]);
        }

        return redirect('admin/companyAdmin');
        
    }

    public function updateAdminPassword(updateAdminPassword $request,$id){ 
        
        $request = Request::instance();
            
        $orders_status = DB::table('administrators')->where('myid','=', $id)->update([
                'password'      =>  Hash::make($request->password)
                ]);
        
        return redirect('admin/companyAdmin');
        
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
            //return abort(401);
        }
        $user = Company::findOrFail($id);

        return view('admin.company.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Company::where('myid',$id)->delete();
        
        return redirect('/admin/companyAdmin')->with('message', Lang::get("labels.companyAdminDeletedSuccessfully"));
      
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




    public function alldelete(Request $request)
    {   
        $request = Request::instance();
        $pubid = Request::input('ids');
        // echo 11;
        // echo '<pre>'; print_r($pubid); exit;
        
        $ids=explode(',', $pubid);

        $entries = Company::whereIn('myid', $ids)->delete();            
        return  response()->json(['url'=> route('companyAdmin.index')]);         
    }


    public function massDestroy(Request $request)
    {
        $request = Request::instance();

        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('myid', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


}
