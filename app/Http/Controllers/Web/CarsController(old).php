<?php 

namespace App\Http\Controllers\Web;

use App\CarBrand;
use App\Property;
use App\User;
use App\Property_types;
use App\property_category;
use App\Usergroup;
use App\Property_img;
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
          
        //$property= Property::orderBy('id', 'DESC')->paginate(4);
      
          $propertymap= Property::orderBy('id', 'DESC')->limit(4)->get();  
          // $propertymap= array();
        
        // echo "<prE>"; print_r($propertymap); die;
        //$ads = Ads::where('showBanner',0)->get();

        //echo "<pre>"; print_r($ads); die;
        //echo "<pre>"; print_r($ads); die;
        //echo "<pre>"; print_r($property); die;

        return view('car_list',compact('propertymap','ads'));
    }

    public function myCar()
    {
      if(Session::get('userId'))
      {
          $carBrand = CarBrand::all();      
          $fueltype= DB::table('fueltype')->groupby('name')->get();          
          $property_category = Property_category::all();
          $citys = DB::table('city')->groupby('name')->get();      
          $myCar = DB::table('properties')->select('*')->
              where('properties.userId',Session::get('userId'))->paginate(9);
          $years = CarYear::all();
          $name = User::where('id',Session::get('userId'))->select('name','lname')->first();
          return view('mycar',compact('myCar','carBrand','fueltype','property_category','name','citys','years'));
      } else {
        return view('/login');
      }
  
      
    }

    public function myCar_edit($id)
    {
      if(Session::get('userId'))
      {
          $carBrand = CarBrand::all(); 
          $fueltype= DB::table('fueltype')->groupby('name')->get();          
          $citys = DB::table('city')->groupby('name')->get();      
          $myCar = Property::where('id',$id)->first();
          $property_category = Property_category::where('car_brand_id',$myCar->car_brand)->get();
          
          $name = User::where('id',Session::get('userId'))->select('name','lname')->first();
          $images = DB::table('property_img')->where('property_id',$id)->get();
          $years = CarYear::all();
          // $caryear = array();
          // if($myCar->prop_category != ''){ 
          //     $caryear= DB::table('car_year')->where('car_model_id',$myCar->prop_category)->get();     
          // }
 
          return view('mycar_edit',compact('myCar','carBrand','fueltype','property_category','name','citys','images','years'));
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
        $property = Property::findOrFail($id);

        if($request->pro_type == "1")
        {
            $request['sale_price'] = $request->get('price');
        }
         if($request->pro_type == "2")
        {
            $request['month_rentprice'] = $request->get('price');
        }
        // echo '<pre>'; print_r($request->all()); die;
      
        $property->update($request->all());
        
     
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
                $destinationPath = public_path('propertyImage/');
               
                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);


               if (in_array(strtolower($extension),$valid_extension)) {
                    
                    
                    $file->move($destinationPath, $picture);

                    $property_img = new Property_img([
                        'property_id' => $id,
                        'img_name'=> $picture,
                    ]);
    
                      $property_img->save();

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
        $message = Lang::get("labels.editPropertySuccessfully");
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
      
        $property = Property::create($request->all());
        $proid = DB::getPdo()->lastInsertId();
     
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
                $destinationPath = public_path('propertyImage/');
               
                $valid_extension = array("jpg","jpeg","png");

                $rules= [
                     'file' => 'mimes:jpeg,png,jpg'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);


               if (in_array(strtolower($extension),$valid_extension)) {
                    
                    
                    $file->move($destinationPath, $picture);

                    $property_img = new Property_img([
                        'property_id' => $proid,
                        'img_name'=> $picture,
                    ]);
    
                      $property_img->save();

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
        $message = Lang::get("labels.addPropertySuccessfully");
        return redirect('/myCar')->with('message', 'New car added successfully');
      }
      
    }

    public function delete_img()
    {
      $request = Request::instance();
      $del_id = $request->get('del_id');
      // $id = $request->get('id');
      $data = Property_img::where('id',$del_id)->delete();
      echo 1;exit;
    }
    
    public function load_data()
    { 
      
        $request = Request::instance();
        //echo "<prE>"; print_r($request->all()); die;
        //$propertymap= Property::orderBy('id', 'DESC')->limit(4)->get();  
        //echo "<pre>"; print_r($search); die;
         if($request->ajax())
            { 
              /*if($request->sort == 1){
                   if($request->id > 0)
                    { echo 22222; 
                     $data = DB::table('properties')
                        ->where('id', '<', $request->id)
                        ->orderBy('id', 'ASC')
                        ->limit(4)
                        ->offset(5)
                        ->get();
                    }
                  else
                  { echo 11111; 
                   $data = DB::table('properties')
                      ->orderBy('id', 'ASC')
                      ->limit(4)
                      ->offset(0)
                      ->get();
                  }*/
              //} else {

                  $search = $request->get('type');
                  $city = $request->get('city');
                  $category = $request->get('category');
                  $ads = Ads::all();

                   if($request->id > 0)
                    { 
                      if ($search == "" && $city == "" && $category == "") { //echo 99999; die;
                      $data = DB::table('properties')
                        ->where('id', '<', $request->id)
                        ->orderBy('id', 'DESC')
                        ->limit(4)
                        /*->offset(5)*/
                        ->get();
                      }

                        if ($search == 1) { //echo 5555; die;
                        $data = Property::where('pro_type',1)
                            ->where('id', '<', $request->id)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                      } elseif ($search == 2) { //echo 888; die;
                          $data = Property::where('pro_type',2)
                          ->where('id', '<', $request->id)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          
                      } 

                      if ($city != "") { //echo 777; die;
                          $data = Property::where('city',$city)
                              ->where('id', '<', $request->id)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          //echo "<prE>"; print_r($query); die;
                      }

                      if ($category != "") { //echo 3331111; die;
                        $data = Property::where('prop_category',$category)
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
                     
                   $data = DB::table('properties')
                      ->orderBy('id', 'DESC')
                      ->limit(4)
                      ->offset(0)
                      ->get();
                   }

                      if ($search == 1) { //echo 5555; die;
                        $data = Property::where('pro_type',1)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                      } elseif ($search == 2) { //echo 888; die;
                          $data = Property::where('pro_type',2)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          
                      } 

                      if ($city != "") { //echo 777; die;
                          $data = Property::where('city',$city)
                              ->orderBy('id', 'DESC')
                              ->limit(4)
                              ->offset(0)
                              ->get();
                          //echo "<prE>"; print_r($query); die;
                      }

                      if ($category != "") { //echo 3331111; die;
                        $data = Property::where('prop_category',$category)
                            ->orderBy('id', 'DESC')
                            ->limit(4)
                            ->offset(0)
                            ->get();
                          //echo "<prE>"; print_r($query); die;   
                      }

                      if ($search != "" && $city != "" && $category != "") { //echo 99999; die;
                     
                       $data = DB::table('properties')
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
                  $proimage = DB::table('property_img')->where('property_id',$row->id)->first();
                  //echo "<prE>"; print_r($proimage); die;
                   $output .='<div class="img_real_home Car-rent">
                              <div class="img_real">
                                <img src='.$proimage->img_name ? url("/public/propertyImage/".@$proimage->img_name) : url('/public/default-image.jpeg' ).'>
                              </div>
                              <div class="real_content">
                                <div class="estate_real">
                                  <ul class="esta_ul">';
                                     if($row->property_name !='') {                                                 
                            $output .='<li class="esta_li">
                                          <a href="#">'.$row->property_name.'</a>
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

    public function myproperty_loaddata()
    {
      $request = Request::instance();
         if($request->ajax())
             {
              if($request->id > 0)
              { //echo 22222; die;
               $data1 = DB::table('properties')
                  ->where('id', '<', $request->id)
                  ->orderBy('id', 'DESC')
                  ->where('userId',Session::get('userId'))
                  ->limit(3)
                  ->get();
              }
              else
              { 
               $data1 = DB::table('properties')
                  ->orderBy('id', 'DESC')
                  //->where('userId',Session::get('userId'))
                  ->limit(3)
                  ->offset(3)
                  ->get();
              }
                 // echo "<pre>"; print_r($data); die;
              $output = '';
              $last_id = '';
              
              if(!$data1->isEmpty())
              {
               foreach($data1 as $key=>$data)
               { //echo "<pre>"; print_r($row); 
                $output .='<div class="listing_box new house sale">
                                <div class="listing">
                                    <div class="listing_image">
                                      <div class="listing_image_container">';
                                        $myproimg = DB::table('property_img')->where('property_id',$data->id)->first(); 
                                        if (!empty($myproimg)) {
                                            if(file_exists(base_path().'/public/propertyImage/'.$myproimg->img_name) && $myproimg->img_name != '')
                                            { 
                                            	$output .='<img src='.url("/public/propertyImage/".@$myproimg->img_name).'>';
                                            }
                                        } else {
                                        $output .='<img src='.url("/public/default-image.jpeg").'>';
                                        }
                                       
                                        
                                    $output .='</div>
                                            <div class="tags d-flex flex-row align-items-start justify-content-start flex-wrap">';

                        $output .='<div class="tag tag_sale"><a href="#">';

                                        if($data->pro_type == 1){
                                        $output .= 'for sale';
                                        } else if ($data->pro_type == 2){
                                        $output .= 'for rent';
                                        }
                                        $output .= '</a></div>



                                        </div>
                                      <div class="lst-btm-prc listing_price">
                                        <div class="tag_price">';

                                        if($data->pro_type == 1){
                                         $output .= '$'.$data->sale_price;
                                        } else if ($data->pro_type == 2){
                                         $output .='$'.$data->month_rentprice;
                                        }

                                        $output .= '</div>
                                                    <div class="tag_price edit">
                                                    <a class="Prop" data-toggle="modal" data-target="#editProperty_<?php echo $mypro->id; ?>">Edit<i class="fas fa-pencil-alt"></i></a>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="listing_content">
                                                  <div class="prop_location listing_location d-flex flex-row align-items-center justify-content-start">';
                                                $output .='<img src='.url("/resources/assets/website/images/icon_1.png").'>';
                                                 $output .='<a href="#">'.$data->googleLocation.'</a>
                                                  </div>


                                                  <div class="listing_info">
                                                    <ul class="d-flex flex-row align-items-center justify-content-start flex-wrap">
                                                        <li class="property_area d-flex flex-row align-items-center justify-content-start">';
                                                         $output .='   <img src='.url("/resources/assets/img/icon_4.png").' alt="">';
                                                         $output .='   <span>'. $data->bedroom.' Bedroom</span>
                                                        </li>
                                                        <li class="d-flex flex-row align-items-center justify-content-start">';
                                                         $output .='   <img src='.url("/resources/assets/img/icon_3.png").' alt="">';
                                                         $output .='   <span>'.$data->bath.' Bath</span>
                                                        </li>
                                                        <li class="d-flex flex-row align-items-center justify-content-start">';
                                                        $output .='    <img src='.url("/resources/assets/img/icon_2.png").' alt="">';
                                                        $output .='    <span>512 meter</span>
                                                        </li>
                                                    </ul>
                                                </div>';


                                      if($data->published == 1){
                                       $output .=   '<div class="publish grren_p">
                                            <a href="#">Publish</a>
                                          </div>';
                                      } else {

                                        $output .= '<div class="publish red_p">
                                            <a href="#">UnPublish</a>
                                        </div>';
                                      } 
                       $output .= '   </div>
                                  </div>
                                </div>';
                $last_id = $data->id;
               }
               $output .= '
               <div id="load_more">
                <button type="button" name="load_more_button" class="btn btn-success btn-sm" data-id="'.$last_id.'" id="load_more_button">Load More</button>
               </div>
               ';
              }
              else
              {
               $output .= '
               <div id="load_more">
                <button type="button" name="load_more_button" class="btn btn-info btn-sm">No Data Found</button>
               </div>
               ';
              }
              echo $output;
             }
    }


    public function property_edit($id)
    {
        $session = Session::all();
        if(!empty($session['userId']))
        {

        $category= DB::table('property_category')->get();
        $city= DB::table('city')->get();
        $myproperty = DB::table('properties')->where('userId',$session['userId'])->where('id',$id)->get(); 
        //$image = DB::table('property_img')->where('property_id',$detail->id)->first(); 
        return view('editmy_property',compact('category','myproperty','city'));
        
      }else
      {
        return view('/login');
      }

    }

    public function search()
    {
        $request = Request::instance();
        $brand = $request->get('brand');
        $city = $request->get('city');
        $year = $request->get('year');
        $category = $request->get('category');

        $result = Property::where('published',1);
        if ($brand != "") {
            $result->where('car_brand',$brand);
        }
        if ($city != "") {
            $result->where('city',$city);
        } 
        if ($category != "") {
            $result->where('prop_category',$category);
        }
        if ($year != "") {
            $result->where('year_of_car',$year);
        }
        $result->orderby('properties.id','DESC');
        $data = $result->paginate(10);

        // echo "<pre>"; print_r($data); die;


        return view('property_list',compact('query','ads'));
    }

    public function firebase($id)
    { 
       return redirect('/firechat/'.$id);
        
    }

    public function car_detail($id)
    { //echo 111111; die;
      
        $detail= Property::where('id', $id)->first();
        
        $session = Session::all();
        if(!empty($session['userId']))
        {
          $user= User::where('id', $session['userId'])->first();
        } 
        else
        {
            $user= array();
        }
    
        //echo "<pre>"; print_r($detail); die;
        //$new = DB::table('properties');
        /*foreach($ex as $key=>$value)
        {
          if($key == '0'){            
            $new->where('prop_category' ,'LIKE', "%{$value}%");
          }else{
            $new->orwhere('prop_category' ,'LIKE', "%{$value}%");
          }*/
          
          $cat_name = DB::table('property_category')->where('id',$detail->prop_category)->first();
          
        //}
        //$new = $new->orderBy('id','desc')->paginate(3);
        $image = DB::table('property_img')->where('property_id',$detail->id)->get();    
        //echo "<pre>"; print_r($image); die;
        $type_name = DB::table('property_types')->where('id',$detail->pro_type)->first();
        //echo "<prE>"; print_r($type_name); die;

        return view('car_detail',compact('detail','image','user','cat_name','type_name'));
    }



    public function myproperty()
    {
        //echo 11111; die;

        $session = Session::all();
        if(!empty($session['userId']))
        {

        //echo "<pre>"; print_r($session['userId']); die;
        $category= DB::table('property_category')->get();
        $city= DB::table('city')->get();
        $myproperty = DB::table('properties')->where('userId',$session['userId'])->get(); 
        //echo "<pre>"; print_r($myproperty); die;
        //$image = DB::table('property_img')->where('property_id',$detail->id)->first(); 
        return view('my_property',compact('category','myproperty','city'));
        //echo "<pre>"; print_r($detail); die;
        
      }else
      {
        return view('/login');
      }

    }

    public function addPropertyuser(Request $request)
    {   
        $request = Request::instance();
        //echo '<pre>'; print_r($request->all()); die;
        if($request['propertyid'] == ""){ 

                $request['prop_category'] = implode(',', $request['prop_category']);
                
                if ($request['pro_type'] == '1') { 
                    $request['sale_price'] = $request['price'];
                } else { 
                    $request['month_rentprice'] = $request['price'];
                }
                
                $property = Property::create($request->all());
                $proid = DB::getPdo()->lastInsertId();
             
                $files = $request->file('image');
                
                if (!empty($files)) {
                    
                    foreach($files as $file){
                        $extension = $file->getClientOriginalExtension();
                        $mimeType = $file->getMimeType();
                        $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                        $picture = time() . "." . $image_name;
                        $destinationPath = public_path('propertyImage/');
                        $valid_extension = array("jpg","jpeg","png");

                        $rules= [
                             'file' => 'mimes:jpeg,png,jpg'
                        ];
                        $x = $request->all();
                        $validator=Validator::make($x, $rules);

                        if (in_array(strtolower($extension),$valid_extension)) {
                            
                            $file->move($destinationPath, $picture);

                            $property_img = new Property_img([
                                'property_id' => $proid,
                                'img_name'=> $picture,
                            ]);
                            $property_img->save();

                       } else {
                            return redirect('/myproperty')->with('errormessage', 'please upload valid image.');
                       }
                    }
                }

        } else { 
            //echo '<pre>'; print_r($request->all()); die;
                $property = Property::findOrFail($request['propertyid']);
                //echo "<pre>"; print_r($property); die;
                 $proid = $property->id; 

            $request['prop_category'] = implode(',', $request['prop_category']);
                
                if ($request['pro_type'] == '1') { 
                    $request['sale_price'] = $request['price'];
                } else { 
                    $request['month_rentprice'] = $request['price'];
                }
                
                $property->update($request->all());
                
                $files = $request->file('image');
                
                if (!empty($files)) {
                    
                    foreach($files as $file){
                        $extension = $file->getClientOriginalExtension();
                        $mimeType = $file->getMimeType();
                        $image_name = str_replace(' ', '-', $file->getClientOriginalName());
                        $picture = time() . "." . $image_name;
                        $destinationPath = public_path('propertyImage/');
                        $valid_extension = array("jpg","jpeg","png");

                        $rules= [
                             'file' => 'mimes:jpeg,png,jpg'
                        ];
                        $x = $request->all();
                        $validator=Validator::make($x, $rules);

                        if (in_array(strtolower($extension),$valid_extension)) {
                            
                            $file->move($destinationPath, $picture);

                            $property_img = new Property_img([
                                'property_id' => $proid,
                                'img_name'=> $picture,
                            ]);
                            $property_img->save();

                       } else {
                            return redirect('/myproperty')->with('errormessage', 'please upload valid image.');
                       }
                    }
                }

        }

        return redirect('/myproperty')->with('message', 'New Property created successfully');
    }

    

}
