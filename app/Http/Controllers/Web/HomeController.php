<?php 

namespace App\Http\Controllers\Web;

use App;
use App\Car;
use App\User;
use App\Car_types;
use App\CarModel;
use App\Usergroup;
use App\Car_img;
use App\ShowRoomAdmin;
use App\Ads;
use App\TopCar;
use App\CarBrand;
use DB;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

use Auth;
use Hash;

class HomeController extends Controller
{

    public function index()
    {

        $already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 




        $company= ShowRoomAdmin::orderBy('myid', 'DESC')->where('issubadmin',4)->paginate(3);
        // echo '<pre>'; print_r($company); die;
        $showroom= ShowRoomAdmin::orderBy('myid', 'DESC')->where('issubadmin',2)->limit(3)->get();
        $sellcar= Car::orderBy('id', 'DESC')->where('pro_type',1)->where('published',1)->limit(10)->get();
        $about= DB::table('aboutus')->first();
        $city = DB::table('city')->groupby('name')->get();
        $brand = CarBrand::get();
        $category = CarModel::where('published',1)->get();
        $homeslide = DB::table('homeslide')->get();
        $ban = Ads::where('published',1)->get();
        $year = DB::table('car_year')->pluck('year')->toArray();;

        
        
        $result['city'] = $city;
        $result['sellcar'] = $sellcar;
        $result['showroom'] = $showroom;
        $result['about'] = $about;
        $result['company'] = $company;
        $result['brand'] = $brand;
        $result['category'] = $category;
        $result['homeslide'] = $homeslide;
        $result['ban'] = $ban;
        $result['year'] = $year;

        //echo '<pre>'; print_r($ShowRoomAdmin); die;

       return view('welcome')->with('result',$result);
    }

    public function categoryFilter(){
        $request = Request::instance();
        $categorys = CarModel::where('published',1)->where('car_brand_id',$request->id)->get();
        $selectedCategory = $request->selectedCategory ? $request->selectedCategory : '';
        $categoryOption = '<option value="">'.trans('labels.selectCategoryType').'</option>';
        foreach($categorys as $category){
            $select = '';
            if($selectedCategory == $category->id){
                $select = 'selected';
            }
            $categoryOption = $categoryOption.'<option value='.$category->id.' '.$select.'>'.$category->name.'</option>';
        }
        return $categoryOption;
    }

    public function categoryFilter1(){
        $request = Request::instance();
        $categorys = DB::table('car_year')->where('car_model_id',$request->id)->get();
        $selectedCategory = $request->selectedCategory ? $request->selectedCategory : '';
        $categoryOption = '<option value="">'.trans('labels.yearOfCar').'</option>';
        foreach($categorys as $category){
            $select = '';
            if($selectedCategory == $category->id){
                $select = 'selected';
            }
            $categoryOption = $categoryOption.'<option value='.$category->id.' '.$select.'>'.$category->year.'</option>';
        }
        return $categoryOption;
    }

    public function changelang($text)
    {
    
        App::setLocale($text);
        session()->put('locale', $text); 
        Session::put('language', $text);
        $session = Session::all();
        // echo "<pre>";print_r($session);exit;
        // exit;
        return redirect()->back();
    }

    public function allposts()
    {
        
        $admin = auth()->guard('admin')->user();
        
      $request = Request::instance();
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'car_img', 
                            3 =>'car',
                            4 =>'pro_type',
                            5=> 'sale_price',
                            6=> 'userType',
                            7=> 'user',
                            8=> 'published',
                            9=> 'id',
                        );

  
        $totalData = Car::count();
       
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 
        $userId =  $request->input('columns.1.search.value'); 
        $showRoomId =  $request->input('columns.2.search.value'); 
        

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
            
        } else { 
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
            if (!empty($cat)) {
                $res->Where('userType','=',"{$cat}");   
            }
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();
        }

        //$totalData = Car::count();
        //$totalFiltered = count($posts); 
        
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $car_img =Car_img::select('img_name')->where('car_id', $post->id)->first();
                $users =User::select('username')->where('id', $post->userId)->first();
                $showRoomAdmin =ShowRoomAdmin::select('first_name')->where('myid', $post->showRoomId)->first();
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                if (!empty($car_img)) {
                    $nestedData['car_img'] = "<img src='".url('public/carImage/'.$car_img['img_name'])."' width='100' height='100' >" ;    
                } else {
                    $nestedData['car_img'] = "<img src='".url('public/default-image.jpeg')."' width='100' height='100' >";
                }
                $nestedData['car_name'] = $post->car_name;
                if ($post->pro_type == 1) {
                    $nestedData['pro_type'] ="For Sale";
                    $nestedData['sale_price'] = $post->sale_price;  
                } else {
                    $nestedData['pro_type']= "For Rent";
                      $nestedData['sale_price'] = $post->month_rentprice;  
                }

                if ($post->userType == 1) {
                    $nestedData['userType'] ="users";
                } else {
                    $nestedData['userType']= "show Room Admin";
                }

                if ($post->userType == 1) {
                    $nestedData['users'] =$users['username'];
                } else {
                    $nestedData['users'] =$showRoomAdmin['first_name'];
                      $nestedData['sale_price'] = $post->month_rentprice;  
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
                    "recordsTotal"    => intval($totalFiltered),  
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
        $carTypes = Car_types::all();
        $carModel = CarModel::all();
        $users= User::all();        
        $ShowRoomAdmin= ShowRoomAdmin::where('issubadmin',2)->get();        
        return view('admin.car.create',compact('carTypes','users','ShowRoomAdmin','carModel'));
    }

    public function store(Request $request)
    {   
        $request = Request::instance();
        $request['prop_category'] = implode(',', $request['prop_category']);
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

               } else {
                    return redirect('/admin/car')->with('errormessage', 'please upload valid image.');
               }
            }
        }  
        return redirect('/admin/car')->with('message', 'New Car created successfully');
    }

    public function edit($id)
    { 
        $car = Car::findOrFail($id);
        $carTypes = Car_types::all();
        $carModel = CarModel::all();
        $users= User::all();        
        $ShowRoomAdmin= ShowRoomAdmin::where('issubadmin',2)->get();        
        $car_name =Car_img::select('id','img_name')->where('car_id',$car->id)->get();
        return view('admin.car.edit', compact('car','car_types','car_name','users','ShowRoomAdmin','carModel'));
    }
    public function update(Request $request, $id)
    {

        $request = Request::instance();
        $car = Car::findOrFail($id);
        $proId = $car->id;
        if ($request['userType'] == '1') { 
            $request['showRoomId'] = " ";
        } else { 
            $request['userId'] = " ";
        }
        $request['prop_category'] = implode(',', $request['prop_category']);
        
        $car->update($request->all());
        
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
                            'car_id' => $proId,
                            'img_name'=> $picture,
                         ]);

                          $car_img->save();    

                } else {
                
                    return redirect('/admin/car')->with('errormessage', 'please upload valid image.');
                }
                
            }
        }  
        
        return redirect('/admin/car')->with('message', 'Car Edited successfully');
    }


    function delete_img() {
        
        $car_img =Car_img::select('img_name')->where('id', $_POST['del_id'])->first();
        $car_img = DB::table('car_img')->where('id', $_POST['del_id'])->delete();
        
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
        $car = Car::findOrFail($id);

        return view('admin.car.show', compact('car'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = DB::table('car')->where('id', $id)->delete();
        // $Pro_feature = DB::table('pro_feature')->where('pro_id', $id)->delete();
        $car_img = DB::table('car_img')->where('car_id', $id)->get();
        
        foreach ($car_img as $value) {
            
            $car_imgdel = DB::table('car_img')->where('car_id', $id)->delete();
         
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
