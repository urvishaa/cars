<?php 

namespace App\Http\Controllers\Web;

use App;
use App\CarBrand;
use App\Car;
use App\User;
use App\Car_types;
use App\CarModel;
use App\Usergroup;
use App\Car_img;
use App\ShowRoomAdmin;
use App\Ads;
use App\CarYear;

use DB;
use Lang;
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
use Session;
use Hash;

class CarsController extends Controller
{ 
  public function productList(Request $request){
         $request = Request::instance();

         $already = session()->get('language');
        
        if(!isset($already)){ 
            
        $data = Input::get('language');
        //echo "<pre>"; print_r($data); die;
        App::setLocale($data);
        session()->put('locale', 'ar'); 
        Session::put('language', 'ar');
        } 

    $title = array('pageTitle' => Lang::get("website.Home"));
    $storeList = DB::table('administrators')->where('myid',$request->id)->first();
    $products = DB::table('car_accessories')->join('car_accessories_img', 'car_accessories.id', '=', 'car_accessories_img.product_id')->select('car_accessories.*','car_accessories_img.img_name')->where('store_id',$request->id)->groupby('car_accessories.id')->where('status',1)->Paginate(9);
    $result = array();      
    // echo "<pre>";print_r($storeList);exit;
    $result['products'] = $products;  
    $result['storeList'] = $storeList;  
    return view("productlist", $title)->with('result', $result);  
  }

  public function storeAdminList(Request $request){
    $request = Request::instance();

    //echo Session::get('userId');
    $title = array('pageTitle' => Lang::get("website.Home"));
    // $storeAdmins = DB::table('car_accessories')->join('administrators','car_accessories.store_id','administrators.myid','inner')->where('administrators.issubadmin',3)->Paginate(12);
    $city = DB::table('city')->groupBy('name')->get();

    $result = array();      
    // $result['storeAdmins'] = $storeAdmins; 
    $result['city'] = $city;  
    
    return view("storeadminlist", $title)->with('result', $result);     
  }

  public function storeResult(Request $request)
  {
     $request = Request::instance();

      

      // if($limit == "blnk")
      // {
      //   $limit = 0;
      // }else{
      //   $limit = 8;
      // }

      if($request->ajax())
      {
        $city = $request->get('city');

      
      
      $totalcount = $request->get('totalcount');
      $result = DB::table('administrators')->where('issubadmin',3);
      if($city != '')
      {
        $result->where('city',$city);
        $result->orderby('myid','DESC');
        $sellList = $result->get();
      } else {
          $result->orderby('myid','DESC');
          $sellList = $result->limit(8)->offset($totalcount)->get();
      }
      // echo "<pre>"; print_r($sellList); die;
       $output = '';
       if(count($sellList) > 0)
              { 
                $re = array();
               
               foreach($sellList as $key=>$row)
               { 

                $output .= '<div class="col-md-6 col-lg-3">
                  <div class="store-sec">
                      <div class="store-inr-main">';
                          $det = route('productlist', ['id' => $row->myid]);
                          
                          if(file_exists(base_path().'/'.$row->image) && $row->image != '')
                              {     
                                                             
                                  $output .='<a href="'.$det.'"><img src='.url($row->image).'></a>';                                  
                              } 
                              else 
                              {                                    
                                  $output .='<a href="'.$det.'"><img src='.url("/public/default-image.jpeg").'></a>';                                   
                              }
                             
             $output .= '</div>
                        <div class="str-main">
                          <h4>';
                          if($row->first_name !='' || $row->last_name != '') {
                            
                              $output .= '<a href="'.$det.'">'.$row->first_name.' '.$row->last_name.'</a>';

                            }
                            $output .= '</h4>
                            <ul>';
                            if($row->phone !=''){ 
                                  $output .='<li class="esta_li telp">
                                      <a href="tel:'.$row->phone.'">
                                          <label><i class="fa fa-mobile-alt"></i></label><span>'.$row->phone.'</span>
                                      </a>
                                      
                                  </li>';
                              }
                              if($row->email !=''){ 
                                  
                                $output .='<li class="esta_li telp">
                                    <a href="mailto:'.$row->email.'"><label><i class="far fa-envelope"></i></label><span>'.$row->email.'</span></a>
                                </li>';       
                            }
                           $output .=' </ul>
                            <div class="store-btn">
                                <button type="submit"><a style="color:white" href="'.$det.'">'. trans('labels.storeProduct') .'</a></button>
                            </div>
                        </div>
                    </div>
                </div>';
        $ban = Ads::where('published',1)->get();
        if($key == 7  || $key == 14){
          if(count($ban) > 0){
                $output .= '<section class="col-md-12 section-padding car-tre">
                      
                          <div class="bant-tre owl-carousel owl-theme property-slider2">';
              foreach($ban as $bann ){
                               $output .='<div class="item">';
                              
                                  if(file_exists(public_path("/dsaImage/".$bann->image)) AND $bann->image !='' ){
                                  $output .='<img src="'.url("/public/dsaImage/".$bann->image).'" alt="">';
                                  }
                              $output .='</div>';
                                }
                          $output .='</div>
                          </section>';
                        }
                    } 
                 
                   $totalcount++;      
              }
          if(count($sellList) > 7){
           if($city == '')
            {
             $output .= '
                <div id="load_more" class="col-md-12 load_more_button">
                <button type="button" name="load_more_button" style="border:1px solid #0d83a9" class="btn btn-defualt form-control" id="load_more_button">Load More...</button></div>';
            }
          }
              
      }else
      {
         $output .= '
               <div id="load_more" class="col-md-12" >
                <button type="button" name="load_more_button" style="background:#0c83a8;color:white" value="datanull" class="btn btn-defualt form-control">No Data Found</button>
                <input type="hidden" name="nodata" id="nodata" value="0" >
               </div>';

      }
      //$output = array();
      $response = array('result' => $output);
            echo json_encode($response);  
    }
  }
    

    public function index()
    { 
        //echo "789546"; die;
        if (!empty($_GET['search'])) {
          $search = $_GET['search']; 
        } else {
          $search = ''; 
        }
        if(!empty($_GET['city'])){
          $city = $_GET['city'];
        } else {
          $city ="";
        }
        if (!empty($_GET['category'])) {
          $category = $_GET['category'];
        } else {
          $category = "";
        }
        return view('car_list',compact('ads'));
    }

    public function myCar()
    {
      if(Session::get('userId'))
      {
          $carBrand = CarBrand::all();      
          $fueltype= DB::table('fueltype')->groupby('name')->get();          
          $carModel = CarModel::all();
          $citys = DB::table('city')->groupby('name')->get();      
          $myCar = DB::table('car')->select('*')->
              where('car.userId',Session::get('userId'))->paginate(9);
          $years = CarYear::all();
          $name = User::where('id',Session::get('userId'))->select('name','lname')->first();
          return view('mycar',compact('myCar','carBrand','fueltype','carModel','name','citys','years'));
      } else {
        return view('/login');
      }
  
      
    }

    public function myCar_edit($id)
    {
      if(Session::get('userId'))
      {
          $id = base64_decode($id);
          $myCar = Car::where('id',$id)->first();
          // echo '<pre>'; print_r($myCar); die;
          if(Session::get('userId') == $myCar->userId)
          {
            $carBrand = CarBrand::all(); 
            $fueltype= DB::table('fueltype')->groupby('name')->get();          
            $citys = DB::table('city')->groupby('name')->get();      
            $carModels = CarModel::where('car_brand_id',$myCar->car_brand)->get();
            $name = User::where('id',Session::get('userId'))->select('name','lname')->first();
            $images = DB::table('car_img')->where('car_id',$id)->get();
            $years = CarYear::all();
            
   
            return view('mycar_edit',compact('myCar','carBrand','fueltype','carModels','name','citys','images','years'));
          }else {

            return redirect()->back();
          }
      } else {
        return view('/login');
      }

      
    }
    public function useraddCar()
    {
      $request = Request::instance();
      $id = $request->get('id');
      if($id != '' && $id > 0)
      {
        $car = Car::findOrFail($id);

        if($request->pro_type == "1")
        {
            $request['sale_price'] = $request->get('price');
        }
         if($request->pro_type == "2")
        {
            $request['month_rentprice'] = $request->get('price');
        }
      
        $car->update($request->all());
        
     
        $files = $request->file('upload_id');


        if (!empty($files)) {
            $imageObj = [];
            $imageDeletes = $request->session()->get('myCar');
            if($imageDeletes !=  ''){
              foreach($imageDeletes as $imageDelete){
                $imageObj[] = $imageDelete['number'];    
              }
            }
            foreach($files as $key=>$file){
              if(!in_array($key,$imageObj)){
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
                        'car_id' => $id,
                        'img_name'=> $picture,
                    ]);
    
                      $car_img->save();

               } else {
                $message = Lang::get("labels.please upload valid image.");
                return back()->with('errormessage', $message);
               }
              }
            }
            if($imageDeletes !=  ''){
              session()->forget('myCar');
            }
        }  
        $message = Lang::get("labels.editCarSuccessfully");
        return redirect('/myCar')->with('message', 'Car edit successfully');
      }else{


        if($request->pro_type == "1")
        {
            $request['sale_price'] = $request->get('price');
        }
         if($request->pro_type == "2")
        {
            $request['month_rentprice'] = $request->get('price');
        }
        // echo '<pre>'; print_r($request->all()); die;
      
        $car = Car::create($request->all());
        $carId = DB::getPdo()->lastInsertId();
     
        $files = $request->file('upload_id');


        if (!empty($files)) {
          $imageObj = [];
          $imageDeletes = $request->session()->get('myCar');
          if($imageDeletes !=  ''){
            foreach($imageDeletes as $imageDelete){
              $imageObj[] = $imageDelete['number'];    
            }
          }
            foreach($files as $key=>$file){
              if(!in_array($key,$imageObj)){
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
                        'car_id' => $carId,
                        'img_name'=> $picture,
                    ]);
    
                      $car_img->save();

               } else {
                $message = Lang::get("labels.please upload valid image.");
                return back()->with('errormessage', $message);
               }
            }
          }
          if($imageDeletes !=  ''){
            session()->forget('myCar');
          }
        }  
        $message = Lang::get("labels.addCarSuccessfully");
        return redirect('/myCar')->with('message', 'New car added successfully');
      }
      
    }

    public function delete_img()
    {
      $request = Request::instance();
      $del_id = $request->get('del_id');
      // $id = $request->get('id');
      $data = Car_img::where('id',$del_id)->delete();
      echo 1;exit;
    }
    
    public function load_data()
    { 
      
        $request = Request::instance();
        
         if($request->ajax())
            { 
              

                  $search = $request->get('type');
                  $city = $request->get('city');
                  $category = $request->get('category');
                  $ads = Ads::all();

                   if($request->id > 0)
                    { 
                      if ($search == "" && $city == "" && $category == "") { //echo 99999; die;
                      $data = DB::table('car')
                        ->where('id', '<', $request->id)
                        ->orderBy('id', 'DESC')
                        ->limit(4)
                        /*->offset(5)*/
                        ->get();
                      }

                        if ($search == 1) { //echo 5555; die;
                        $data = Car::where('pro_type',1)
                            ->where('id', '<', $request->id)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                      } elseif ($search == 2) { //echo 888; die;
                          $data = Car::where('pro_type',2)
                          ->where('id', '<', $request->id)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          
                      } 

                      if ($city != "") { //echo 777; die;
                          $data = Car::where('city',$city)
                              ->where('id', '<', $request->id)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          //echo "<prE>"; print_r($query); die;
                      }

                      if ($category != "") { //echo 3331111; die;
                        $data = Car::where('prop_category',$category)
                            ->where('id', '<', $request->id)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                          //echo "<prE>"; print_r($query); die;   
                      }

                    }
                  else
                  { 
                   if ($search == "" && $city == "" && $category == "") { //echo 99999; die;
                     
                   $data = DB::table('car')
                      ->orderBy('id', 'DESC')
                      ->limit(4)
                      ->offset(0)
                      ->get();
                   }

                      if ($search == 1) { //echo 5555; die;
                        $data = Car::where('pro_type',1)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                      } elseif ($search == 2) { //echo 888; die;
                          $data = Car::where('pro_type',2)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          
                      } 

                      if ($city != "") { //echo 777; die;
                          $data = Car::where('city',$city)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          //echo "<prE>"; print_r($query); die;
                      }

                      if ($category != "") { //echo 3331111; die;
                        $data = Car::where('prop_category',$category)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                          //echo "<prE>"; print_r($query); die;   
                      }

                      if ($search != "" && $city != "" && $category != "") { //echo 99999; die;
                     
                       $data = DB::table('car')
                          ->where('pro_type',$search)
                          ->where('city',$city)
                          ->where('prop_category',$category)
                          ->orderBy('id', 'DESC')
                          ->limit(4)
                          ->offset(0)
                          ->get();
                       }

                  }

               // }
              $output = '';
              $last_id = '';
              //echo "<pre>"; print_r($data); die;
             
              if(count($data) > 0)
              { 
                  $re = array();
               foreach($data as $key=>$row)
               { //echo "<pre>"; print_r($row); die; 
                  $carImage = DB::table('car_img')->where('car_id',$row->id)->first();
                  //echo "<prE>"; print_r($carImage); die;
                   $output .='<div class="img_real_home Car-rent">
                              <div class="img_real">
                                <img src='.$carImage->img_name ? url("/public/carImage/".@$carImage->img_name) : url('/public/default-image.jpeg' ).'>
                              </div>
                              <div class="real_content">
                                <div class="estate_real">
                                  <ul class="esta_ul">';
                                     if($row->car_name !='') {                                                 
                            $output .='<li class="esta_li">
                                          <a href="#">'.$row->car_name.'</a>
                                      </li>';
                                    }
                                    if($row->phone !='') {
                            $output .='<li class="esta_li telp">
                                          <a href="tel:'.$row->phone.'">
                                            <i class="fas fa-phone-alt"></i>'.$row->phone.'
                                          </a>
                                      </li>';
                                    }
                                    if($row->email !='') {
                            $output .='<li class="esta_li telp">
                                          <a href="mailto:'.$row->email.'><i class="fas fa-envelope"></i>'.$row->email.'</a>
                                      </li>';
                                    }
                                    
                      $output .='<ul>
                                </div>
                              </div>
                            </div>';
                }

                $output .= '
               <div id="load_more">
                <span type="button" name="load_more_button" class="btn btn-defualt form-control" data-id="'.$last_id.'" id="load_more_button">Load More...</span>
              
               </div>
               ';
             } else {
                  $output .= '
                     <div id="load_more">
                      <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                     </div>';
             }
                echo $output; 

            } 
      }   

    public function firebase($id)
    { 
       return redirect('/firechat/'.$id);
        
    }

    public function car_detail($id)
    { 
      
        $detail= Car::where('id', $id)->first();
        
        $session = Session::all();
        if(!empty($session['userId']))
        {
          $user= User::where('id', $session['userId'])->first();
        } 
        else
        {
            $user= array();
        }
        $cat_name = DB::table('car_model')->where('id',$detail->prop_category)->first();
        
        $image = DB::table('car_img')->where('car_id',$detail->id)->get();    

        $type_name = DB::table('car_types')->where('id',$detail->pro_type)->first();

        return view('car_detail',compact('detail','image','user','cat_name','type_name'));
    }
}
