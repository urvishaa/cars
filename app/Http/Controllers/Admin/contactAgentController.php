<?php 

namespace App\Http\Controllers\Admin;

use App\Car_types;
use App\CarBrand;
use App\CarAccessories;
use App\pro_category;
use App\ContactAgent;
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
class contactAgentController extends Controller
{

    public function index()
    {     
        $contactAgent= DB::table('contact_agent')->paginate();
        return view('admin.contact_agent.index', compact('contactAgent'));
    }

    public function allposts()
    {   
        $admin = auth()->guard('admin')->user(); 

        $request = Request::instance();      
        $columns = array( 
                0 =>'id', 
                1 =>'agentName',
                2 =>'type',
                3 =>'name',
                4 =>'nationality',
                5 =>'email',
                6=> 'phone',
                7=> 'dateFrom',
                8=> 'dateTo',
            );
  
        $totalData = DB::table('contact_agent')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

            $res = DB::table('contact_agent');
            if(!empty($request->input('search.value')))
            {
                 $search = $request->input('search.value'); 
                $res->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('firstName', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->orWhere('dateFrom', 'LIKE',"%{$search}%")
                            ->orWhere('dateTo', 'LIKE',"%{$search}%");
            }
            
           
            $res->offset($start)->limit($limit)->orderBy($order,$dir);
            $posts =$res->get();
           
        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            { 

                $car_img =DB::table('administrators')->select('*')->where('myid', $post->userId)->first();              
      
                $nestedData['id'] = $post->id;
                $nestedData['agentName'] = $car_img->first_name.' '.$car_img->last_name;
                if ($post->user_type == "1") {
                    $nestedData['type'] = "Show Room Admin";
                } elseif ($post->user_type == "2") {
                    $nestedData['type'] = "Store Admin";
                }
                $nestedData['name'] = $post->firstName.' '.$post->lastName;
                $nestedData['nationality'] = $post->nationality;
                $nestedData['email'] = $post->email;
                $nestedData['phone'] = $post->phone;
                $nestedData['dateFrom'] = $post->dateFrom;
                $nestedData['dateTo'] = $post->dateTo;
                
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
        $pro_img = DB::table('car_accessories_img')->where('id', $_POST['del_id'])->delete();
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

        $cat = $storeAdmin_pro->category;
        $explode = explode(',', $cat);
        
        $pro_category= pro_category::whereIn('id',$explode)->get();
        
        $result['storeAdmin'] = $storeAdmin;
        $result['pro_category'] = $pro_category;
        
        return view('admin.car_accessories.edit', compact('product','car_img'))->with('result',$result);
    }

    public function update(Request $request,$id)
    {   
        $request = Request::instance();
        
        $product = CarAccessories::findOrFail($id);        
        $product->update($request->all());        
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

    public function bookingList(){
        $admin = auth()->guard('admin')->user(); 
        
        $id = $admin->myid;
        $bookings = DB::table('contact_agent')
        ->Join('car','car.id','=', 'contact_agent.carId')
        ->select('contact_agent.*','contact_agent.id as contact_agent_id','contact_agent.email as contact_agent_email','contact_agent.phone as contact_agent_phone', 'car.*');
        if($admin->issubadmin == 4){
            $bookings=$bookings->where('car.companyId',$id);
        }
            $bookings=$bookings->where('contact_agent.user_type',1)
        ->paginate(10);
        

        return view('admin.car_booking.list', compact('bookings'));
    }
    public function bookingDetail($id){
        
        $carBooking = ContactAgent::with([
            'hasOneCar'=>function($q){
                return $q->with('hasManyCarImage','hasOneCarBrand','hasOneCarModel','hasOneCarCity');
            }],'hasManyLicense','hasManyUploadId','hasOneCountry')->where('id',$id)->get()->first();
        // echo "<pre>";print_r($carBooking);exit;
        return view('admin.car_booking.detail', compact('carBooking'));
       
    }
    public function changeBookingStatus($id){
        $request = Request::instance();
        $contactAgent = ContactAgent::find($id);
        $contactAgent->status = $request->status;
        $contactAgent->save();
        echo $request->stauts;exit;

    }


}
