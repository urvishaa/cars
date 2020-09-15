<?php 

namespace App\Http\Controllers\Admin;

use App\Car_types;
use App\CarBrand;
use App\CarAccessories;
use App\pro_category;
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
use Lang;
class carAccessoriesController extends Controller
{

    public function index()
    {     
        $stores = DB::table('administrators')->select('first_name','last_name','myid')->where('issubadmin', 3)->get();

        return view('admin.car_accessories.index', compact('stores'));
    }

    public function allposts()
    {       
        $admin = auth()->guard('admin')->user(); 

        $request = Request::instance();      
        // echo '<pre>'; print_r($request->all()); die;
        $columns = array( 
                0 =>'id', 
                1 =>'id', 
                2 =>'storeName', 
                3 =>'image',
                4 =>'name',
                5 =>'price',
                6=> 'published',
                7=> 'id',
            );


        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 
        $storeId =  $request->input('columns.1.search.value'); 
       
        if ($admin['issubadmin'] == 3) { 
            $res = DB::table('car_accessories');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($admin['myid'])) {
                $res->Where('store_id','=',"{$admin['myid']}");
            }
            if (!empty($cat)) {
                $res->Where('userType','=',"{$cat}");   
            }
            if (!empty($storeId)) {
                $res->Where('store_id','=',"{$storeId}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();
            //echo "<pre>"; print_r($posts); die;
        } else { 
            $res = DB::table('car_accessories');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%");
            }
            
            if (!empty($cat)) {
                $res->Where('u_type','=',"{$cat}");
            }
            if (!empty($storeId)) {
                $res->Where('store_id','=',"{$storeId}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();
        
        }

        $totalData = $res->Count();
            
        $totalFiltered = $totalData; 
      
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $car_img =DB::table('car_accessories_img')->select('*')->where('product_id', $post->id)->first();              
                
                $storeNames = DB::table('administrators')->select('first_name','last_name')->where('myid', $post->store_id)->where('issubadmin', 3)->first();
                if(!empty($storeNames))
                {
                    $storeName = $storeNames->first_name.' '.$storeNames->last_name;
                }
                else
                {
                    $storeName = '';
                }
                

                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                if (!empty($car_img->img_name)) {
                    $nestedData['image'] = "<img src='".url('public/productImage/'.$car_img->img_name)."' width='100' height='100' >";    
                } else {
                    $nestedData['image'] = "<img src='".url('public/default-image.jpeg')."' width='100' height='100' >";    
                }
                
                $nestedData['storeName'] = $storeName;
                $nestedData['name'] = $post->name;
                $nestedData['price'] = $post->price;
                if ($post->status == 1) {
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                $nestedData['options'] = "&emsp;<a href='car_accessories/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='car_accessories/$post->id'>";
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


    public function getCategory()
    {
        $request = Request::instance();
        
        $storeAdmin =DB::table('administrators')->select('category')->where('myid',$request['store_id'])->first();
        
        $cat = $storeAdmin->category;
        $explode = explode(',', $cat);
        
        $pro_category= pro_category::whereIn('id',$explode)->get();
        
        $html = "";
        $html.="<option value=''>".trans('labels.SelectCategory')."</option>";
        foreach ($pro_category as $key => $value) {
            $html.="<option value=".$value['id'].">".$value['name']."</option>";
        } 
        return $html;    
    }
    public function create()
    {   

        $admin = auth()->guard('admin')->user(); 
        //echo "<pre>"; print_r($admin['myid']); die;
        if ($admin['issubadmin'] == 3) {
            $storeAdmin =DB::table('administrators')->select('myid','first_name','last_name','category')->where('myid',$admin['myid'])->get();    
        } else {
            $storeAdmin =DB::table('administrators')->select('myid','first_name','last_name','category')->where('issubadmin',3)->get();
        }
            //echo "<pre>"; print_r($storeAdmin); die;
        $result['storeAdmin'] = $storeAdmin;
        return view('admin.car_accessories.create')->with('result',$result);
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


  
    public function store()
    {
        $request = Request::instance();        
        $product = CarAccessories::create($request->all());
        $proid = DB::getPdo()->lastInsertId();     
        $files = $request->file('image');
        if (!empty($files)) {
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $picture = time() . "." . $image_name;
                $destinationPath = public_path('productImage/');
               
                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);


               if (in_array(strtolower($extension),$valid_extension)) {
                    
                    
                    $file->move($destinationPath, $picture);

                      $this->resize_crop_image(300, 300, public_path('productImage/'.$picture),public_path('productImage/thumb_'.$picture));

                    $product_img = DB::table('car_accessories_img')->insertGetId([
                        'product_id' => $proid,
                        'img_name'=> $picture,
                    ]);

               } else {
                return redirect('/admin/car_accessories')->with('errormessage', Lang::get("labels.pleaseUploadValidImage"));
               }
            }
        }

        return redirect('/admin/car_accessories')->with('message', Lang::get("labels.newProductCreatedSuccessfully"));
    }


    function delete_img() {
        $car_img = DB::table('car_accessories_img')->where('id', $_POST['del_id'])->delete();
    }

    public function edit($id)
    {   
        $admin = auth()->guard('admin')->user(); 

        $car_img =DB::table('car_accessories_img')->select('*')->where('product_id', $id)->get();
        if ($admin['issubadmin'] == 3) {
            $storeAdmin =DB::table('administrators')->select('myid','first_name','last_name','category')->where('myid',$admin['myid'])->get();    
        } else {
            $storeAdmin =DB::table('administrators')->select('myid','first_name','last_name','category')->where('issubadmin',3)->get();
        }
        
        $product = CarAccessories::findOrFail($id);  
        
        $storeAdmin_pro =DB::table('administrators')->select('myid','first_name','last_name','category')->where('issubadmin',3)->where('myid',$product['store_id'])->first();


        if(!empty($storeAdmin_pro))
        {
            $cat = $storeAdmin_pro->category;
            $explode = explode(',', $cat);        
            $pro_category= pro_category::whereIn('id',$explode)->get();
            $result['pro_category'] = $pro_category;
        }
        else
        {
            $result['pro_category'] =array();
        }    



        $result['storeAdmin'] = $storeAdmin;
       
        
        return view('admin.car_accessories.edit', compact('product','car_img'))->with('result',$result);
    }

    public function update(Request $request,$id)
    {   
        $request = Request::instance();

        //echo "<pre>";print_r($request->all());exit;
        
        $product = CarAccessories::findOrFail($id);        
        $product->update($request->all());        
        $files = $request->file('image');

         $image_idArray = $request->image_id;

        if(!empty($image_idArray)){

            foreach($image_idArray as $key=>$value){


                $carImg = DB::table('car_accessories_img')->where('id',$value)->first();


                // $carImg = Car_img::findOrFail($value);

                 //echo "<pre>";print_r($carImg);print_r($carImg->img_name);

                //if(file_exists(public_path('/carImage/'.$carImg->img_name)) && !file_exists(public_path('carImage/thumb_'.$carImg->img_name)))
                 if(file_exists(public_path('/productImage/'.$carImg->img_name)))
                {
                    $this->resize_crop_image(300, 300, public_path('productImage/'.$carImg->img_name), public_path('productImage/thumb_'.$carImg->img_name));
                   //$this->resize_image(public_path('/carImage/'.$carImg->img_name), 300, 300);

                }
                 //if(!empty($carImg->img_name))
            }

        }
        if (!empty($files)) {
        
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                $picture = time() . "." . $image_name;
                $destinationPath = public_path('productImage/');
               
                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);


               if (in_array(strtolower($extension),$valid_extension)) {
                    
                    
                    $file->move($destinationPath, $picture);

                    $this->resize_crop_image(300, 300, public_path('productImage/'.$picture),public_path('productImage/thumb_'.$picture));


                    $product_img = DB::table('car_accessories_img')->insertGetId([
                        'product_id' => $id,
                        'img_name'=> $picture,
                    ]);

               } else {
                return redirect('/admin/car_accessories')->with('errormessage', Lang::get("labels.pleaseUploadValidImage"));
               }
            }
        
        }  
        
        return redirect('/admin/car_accessories')->with('message', Lang::get("labels.ProductEditedSuccessfully"));
    }


    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }


    public function destroy($id)
    {
        $CarAccessories = CarAccessories::findOrFail($id);
        $CarAccessories->delete();
        $image_delete = DB::table('car_accessories_img')->where('product_id',$id)->delete();

        return redirect('/admin/car_accessories')->with('message', Lang::get("labels.productDeletedSuccessfully"));      
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

    
    public function alldelete()
    {  
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = CarAccessories::whereIn('id', $ids)->get();

        foreach ($entries as $entry) { 
            $entry->delete();
            $image_delete = DB::table('car_accessories_img')->where('product_id',$entry['id'])->delete();

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
