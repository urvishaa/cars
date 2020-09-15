<?php 

namespace App\Http\Controllers\Admin;

use App\Car;
use App\User;
use App\Car_types;
use App\CarModel;
use App\Usergroup;
use App\Car_img;
use App\ShowRoomAdmin;
use App\CarBrand;
use App\Company;
use App\CarYear;
use DB;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
// use App\Http\Requests\Admin\StoreCarRequest;
// use App\Http\Requests\Admin\UpdatePropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Auth;
use Hash;

class CarController extends Controller
{

    public function index()
    {
       
        $users =User::select('*')->get();
        $ShowRoomAdmin =ShowRoomAdmin::select('*')->where('issubadmin',2)->get();
        $company =ShowRoomAdmin::select('*')->where('issubadmin',4)->get();
        
       return view('admin.car.index', compact('users','ShowRoomAdmin','company'));
    }

    public function allposts()
    {

      $admin = auth()->guard('admin')->user(); 

      //echo '<pre>'; print_r($admin); die;
    
      $request = Request::instance();
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'car_img', 
                            3 =>'car_name',
                            4 =>'pro_type',
                            5=> 'sale_price',
                            6=> 'userType',
                            7=> 'user',
                            8=> 'published',
                            9=> 'id',
                        );

        if($admin['issubadmin'] == 2) {
            $totalData = Car::where('showRoomId',$admin['myid'])->count();  
            $totalFiltered = $totalData; 
        }elseif($admin['issubadmin'] == 4){
            $totalData = Car::where('companyId',$admin['myid'])->count();  
            $totalFiltered = $totalData; 
        }else{
            $totalData = Car::count();  
            $totalFiltered = $totalData; 
        }

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 
        $userId =  $request->input('columns.1.search.value'); 
        $showRoomId =  $request->input('columns.2.search.value'); 
        $companyId =  $request->input('columns.3.search.value'); 
        
        //echo "<pre>"; echo $userId; die;
        if ($admin['issubadmin'] == 2) {

            $res = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($admin['myid'])) {
                $res->Where('showRoomId','=',"{$admin['myid']}");
            }
            if (!empty($cat)) {
                $res->Where('userType','=',"{$cat}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();

            $res1 = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res1->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($admin['myid'])) {
                $res1->Where('showRoomId','=',"{$admin['myid']}");
            }
            if (!empty($cat)) {
                $res1->Where('userType','=',"{$cat}");   
            }
            $totalFiltered =$res1->count();


            //echo "<pre>"; print_r($posts); die;
        } elseif ($admin['issubadmin'] == 4) { //echo 44444; die;
            $res = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($admin['myid'])) {
                $res->Where('companyId','=',"{$admin['myid']}");
            }
            if (!empty($cat)) {
                $res->Where('userType','=',"{$cat}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();

            $res1 = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res1->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($admin['myid'])) {
                $res1->Where('companyId','=',"{$admin['myid']}");
            }
            if (!empty($cat)) {
                $res1->Where('userType','=',"{$cat}");   
            }
            $totalFiltered =$res1->count();

            //echo "<pre>"; print_r($posts); die;
        } else  { //echo 777; die;
            $res = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            if (!empty($userId)) {
                $res->Where('userId','=',"{$userId}");
            }
            if (!empty($showRoomId)) {
                $res->Where('showRoomId','=',"{$showRoomId}");
            }
            if (!empty($companyId)) {
                $res->Where('companyId','=',"{$companyId}");
            }
            if (!empty($cat)) {
                $res->Where('userType','=',"{$cat}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();

             $res1 = DB::table('car');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res1->Where('id', 'LIKE',"%{$search}%")->orWhere('sale_price', 'LIKE',"%{$search}%")
                                ->orWhere('car_name', 'LIKE',"%{$search}%");
            }
            if (!empty($userId)) {
                $res1->Where('userId','=',"{$userId}");
            }
            if (!empty($showRoomId)) {
                $res1->Where('showRoomId','=',"{$showRoomId}");
            }
            if (!empty($companyId)) {
                $res1->Where('companyId','=',"{$companyId}");
            }
            if (!empty($cat)) {
                $res1->Where('userType','=',"{$cat}");   
            }

            $totalFiltered =$res1->count();


        }


        
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {   

                
                $car_img =Car_img::select('img_name')->where('car_id', $post->id)->first();
                $users =User::select('username')->where('id', $post->userId)->first();
                $showRoomAdmin =ShowRoomAdmin::select('first_name')->where('myid', $post->showRoomId)->first();
                $companyName =ShowRoomAdmin::select('first_name')->where('myid', $post->companyId)->first();

                
                
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                if ($car_img != '') {
                    $nestedData['car_img'] = "<img src='".url('public/carImage/'.$car_img['img_name'])."' width='100' height='100' >" ;    
                } else {
                    $nestedData['car_img'] = "<img src='".url('public/default-image.jpeg')."' width='100' height='100' >";
                }
                
                $nestedData['car_name'] = $post->car_name;

                if ($post->pro_type == 1) {
                    $nestedData['pro_type'] ="For Buy & Sale";
                    $nestedData['sale_price'] = $post->sale_price;  
                } else {
                    $nestedData['pro_type']= "For Rent";
                      $nestedData['sale_price'] = $post->month_rentprice;  
                }

                if ($post->userType == 1) {
                    $nestedData['userType'] ="users";
                } else if ($post->userType == 2) {
                    $nestedData['userType']= "show Room Admin";
                }
                else{
                    $nestedData['userType']= "company";
                }


               
                if ($post->userType == 1) {
                    if(!empty($users['username'])){
                        $nestedData['users'] = $users['username'];
                        $nestedData['sale_price'] = $post->sale_price;  
                    }
                    else
                    {
                        $nestedData['users'] = '';
                        $nestedData['sale_price'] = $post->sale_price;  
                    }
                }elseif ($post->userType == 3 ) {
                    if(!empty($companyName)){
                        $nestedData['users'] = $companyName['first_name'];
                        $nestedData['sale_price'] = $post->month_rentprice; 
                    } else
                    {
                        $nestedData['users'] = '';
                        $nestedData['sale_price'] = $post->month_rentprice;  
                    }
                } else {
                    if(!empty($showRoomAdmin)){
                        $nestedData['users'] = $showRoomAdmin['first_name'];
                        $nestedData['sale_price'] = $post->month_rentprice; 
                    }else
                    {
                        $nestedData['users'] = '';
                        $nestedData['sale_price'] = $post->month_rentprice;  
                    } 
                }


                if ($post->published == 1) {       
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                
                $nestedData['options'] = "&emsp;<a href='car/$post->id/edit' class='btn btn-primary' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='car/$post->id'>";
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
        $car_type = Car_types::all();
        $carBrand = CarBrand::all();
        $users= User::all();        
        $ShowRoomAdmin= ShowRoomAdmin::where('issubadmin',2)->get();
        $Company= ShowRoomAdmin::where('issubadmin',4)->get();        
        $years= CarYear::all();        
        $city= DB::table('city')->groupby('name')->get();     
          
        
        $fueltype= DB::table('fueltype')->groupby('name')->get();      
        return view('admin.car.create',compact('car_type','users','ShowRoomAdmin','Company','carBrand','city','fueltype','years'));
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

// return;






        //$max_width=100; $max_height=100;

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

      //  $width_new =$width * $percent;
      //   $height_new =$height * $percent;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            //$w_point = (($width - $width_new) / 1);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
}

    public function store(Request $request)
    {   
        $request = Request::instance();
        // echo '<pre>'; print_r($request->all()); die;
        $car = Car::create($request->all());
        $proid = DB::getPdo()->lastInsertId();
     
        $files = $request->file('image');


        if (!empty($files)) {
            
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $picture = time() . "." . $image_name;
                $destinationPath = public_path('carImage/');
               
                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);


               if (in_array(strtolower($extension),$valid_extension)) {
                    $file->move($destinationPath, $picture);

                    $car_img = new Car_img([
                        'car_id' => $proid,
                        'img_name'=> $picture,
                    ]);
    
                    $car_img->save();

                    //usage example
                    $this->resize_crop_image(300, 300, public_path('carImage/'.$picture), public_path('carImage/thumb_'.$picture));

               } else {
                return redirect('/admin/car')->with('errormessage', 'please upload valid image.');
               }
            }
        }  

        return redirect('/admin/car')->with('message', 'New car created successfully');
    }

    public function edit($id)
    { 
        $car = Car::findOrFail($id);
        $car_type = Car_types::all();
        $carBrand = CarBrand::all();
        $car_category = CarModel::where('car_brand_id',$car->car_brand)->get();
        $users= User::all();        
        $ShowRoomAdmin= ShowRoomAdmin::where('issubadmin',2)->get();
        $Company= ShowRoomAdmin::where('issubadmin',4)->get();           
        $car_name =Car_img::select('id','img_name')->where('car_id',$car->id)->get();
        $city= DB::table('city')->groupby('name')->get(); 
        $years = CarYear::all();


        // $source_file=public_path('carImage/1583404259.1583176865.DSC05333.jpeg');
        // $dst_dir=public_path('carImage/thumb_1583404259.1583176865.DSC05333.jpeg');
        // header('Content-Type: image/jpeg');
        // $thumb = imagecreatetruecolor(100, 100);
        // $source = imagecreatefromjpeg($source_file);

        // list($width, $height) = getimagesize($source_file);

        // imagecopyresized($thumb, $source, 0, 0, 0, 0, 350, 350, $width, $height);

        // imagejpeg($thumb, $dst_dir);
        // exit;


        // echo public_path('carImage/thumb_1583404259.1583176865.DSC05333.jpeg');
        
        // $this->resize_crop_image(300, 300, public_path('carImage/1583404259.1583176865.DSC05333.jpeg'), public_path('carImage/thumb_1583404259.1583176865.DSC05333.jpeg'));exit;
        $fueltype= DB::table('fueltype')->groupby('name')->get();      
        
        return view('admin.car.edit', compact('car','car_type','Company','car_name','users','ShowRoomAdmin','car_category','carBrand','city','fueltype','years'));
    }

    function resize_image($file, $w, $h, $crop=FALSE){
            list($width, $height) = getimagesize($file);
            $r = $width / $height;
            if ($crop) {
                if ($width > $height) {
                    $width = ceil($width-($width*abs($r-$w/$h)));
                } else {
                    $height = ceil($height-($height*abs($r-$w/$h)));
                }
                $newwidth = $w;
                $newheight = $h;
            } else {
                if ($w/$h > $r) {
                    $newwidth = $h*$r;
                    $newheight = $h;
                } else {
                    $newheight = $w/$r;
                    $newwidth = $w;
                }
            }
            $src = imagecreatefromjpeg($file);
       echo     $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            return $dst;
    }
    public function update(Request $request, $id)
    {

        $request = Request::instance();
        
        
       
        if(($request->userType=="2"))
        {
            $request['pro_type'] = '1';
        }
         if(($request->userType=="3"))
        {
            $request['pro_type'] = '2';
        }
        
        $car = Car::findOrFail($id);
        $proId = $car->id;
        if ($request['userType'] == '1') { 
            $request['showRoomId'] = " ";
        } else { 
            $request['userId'] = " ";
        }
        
        $car->update($request->all());
        
        $files = $request->file('image');
        $image_idArray = $request->image_id;

        if(!empty($image_idArray)){

            foreach($image_idArray as $key=>$value){

                 $carImg = Car_img::findOrFail($value);

                 //echo "<pre>";print_r($carImg);print_r($carImg->img_name);

                //if(file_exists(public_path('/carImage/'.$carImg->img_name)) && !file_exists(public_path('carImage/thumb_'.$carImg->img_name)))
                 if(file_exists(public_path('/carImage/'.$carImg->img_name)))
                {
                    $this->resize_crop_image(300, 300, public_path('carImage/'.$carImg->img_name), public_path('carImage/thumb_'.$carImg->img_name));
                   //$this->resize_image(public_path('/carImage/'.$carImg->img_name), 300, 300);

                }
                 //if(!empty($carImg->img_name))
            }

        }
        //echo '<pre>'; print_r($request->all()); die;
        if (!empty($files)) {
        
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $picture = time() . "." . $image_name;
                $destinationPath = public_path('carImage/');

                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);

                if (in_array(strtolower($extension),$valid_extension)){
                    
                    $file->move($destinationPath, $picture);

                    $car_img = new Car_img([
                            'car_id' => $proId,
                            'img_name'=> $picture,
                         ]);

                          $car_img->save();   

                           //usage example
                    $this->resize_crop_image(300, 300, public_path('carImage/'.$picture), public_path('carImage/thumb_'.$picture)); 

                } else {
                    return redirect('/admin/car')->with('errormessage', 'please upload valid image.');
                }
                
            }
        }  
        
        return redirect('/admin/car')->with('message', 'Car Edited successfully');
    }


    function delete_img(){
        
        $car_img = Car_img::select('img_name')->where('id', $_POST['del_id'])->first();
        $Car_img = DB::table('car_img')->where('id', $_POST['del_id'])->delete();
        
        
    }

    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = DB::table('car')->where('id', $id)->delete();
        $car_img = DB::table('car_img')->where('car_id', $id)->get();
        
        foreach ($car_img as $value) {
            

            $Car_imgdel = DB::table('car_img')->where('car_id', $id)->delete();
         
        }
        
        return redirect('/admin/car')->with('message', 'Car Deleted successfully');
      
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

    public function Carmultidelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = Car::whereIn('id', $ids)->get();
        $Car_img = Car_img::whereIn('car_id', $ids)->get();
        
            foreach ($entries as $entry) {
                $entry->delete();
            }

            foreach ($Car_img as $img) {
                $img->delete();
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
