<?php 

namespace App\Http\Controllers\Admin;

use App\Property;
use App\User;
use App\Property_types;
use App\property_category;
use App\Usergroup;
use App\Property_img;
use App\ShowRoomAdmin;
use App\TopProperty;
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

use Auth;
use Hash;
use Lang;

class TopPropertyController extends Controller
{

    public function index()
    {   
        $property= TopProperty::paginate(5);
        $users =User::select('*')->get();
        $ShowRoomAdmin =ShowRoomAdmin::select('*')->where('issubadmin',2)->get();
        
       return view('admin.topProperty.index', compact('property','users','ShowRoomAdmin'));
    }

    public function allposts()
    {
        
      $request = Request::instance();
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'property_img', 
                            3 =>'property_name',
                            4 =>'pro_type',
                            5=> 'sale_price',
                            6=> 'userType',
                            7=> 'user',
                            8=> 'published',
                            9=> 'id',
                        );

  
        $totalData = TopProperty::count();
       
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 
        $userId =  $request->input('columns.1.search.value'); 
        $showRoomId =  $request->input('columns.2.search.value'); 
        
        if(!empty($request->input('search.value')) && ($cat>0) && ($userId>0))
        {  
            $search = $request->input('search.value'); 

            $posts =  TopProperty::Where('id', 'LIKE',"%{$search}%")
                             ->orWhere('sale_price', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('userType','=',"{$cat}") 
                            ->orWhere('userId','=',"{$userId}") 
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TopProperty::where('id','LIKE',"%{$search}%")
                             ->orWhere('sale_price', 'LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->orWhere('userType','=',"{$cat}")
                             ->orWhere('userId','=',"{$userId}")
                            ->count();
        }   
        else if(!empty($request->input('search.value')))
        { 
            $search = $request->input('search.value'); 

            $posts =  TopProperty::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('sale_price', 'LIKE',"%{$search}%")
                            ->orWhere('property_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = TopProperty::where('id','LIKE',"%{$search}%")
                             ->orWhere('sale_price', 'LIKE',"%{$search}%")
                            ->orWhere('property_name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($userId>0 || $userId != '' )
        {        
            $posts =  TopProperty::Where('userId','=',"{$userId}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            
            $totalFiltered = TopProperty::where('userId','=',"{$userId}")
                            ->count();
        }
        else if($showRoomId>0 || $showRoomId != '' )
        {       
            $posts =  TopProperty::Where('showRoomId','=',"{$showRoomId}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            
            $totalFiltered = TopProperty::where('showRoomId','=',"{$showRoomId}")
                            ->count();
        }
        else if($cat>0 || $cat != '')
        {   
            $posts =  TopProperty::Where('userType','=',"{$cat}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            
            $totalFiltered = TopProperty::where('userId','=',"{$cat}")
                            ->count();
        }
        else
        {    
            $posts = TopProperty::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {   

                $property = Property::select('property_name')->where('id',$post->propertyId)->first();

                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['propertyId'] = $property->property_name;
                $nestedData['days'] = $post->days;
                
                $nestedData['options'] = "&emsp;<a href='property/$post->id/edit' class='btn btn-primary' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='property/$post->id'>";
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


    public function getPropertyId()
    {  
        $request = Request::instance();
        $property = Property::select('id','property_name')->whereIn('id',$request['proppertyId'])->get()->toArray();
        
        //$setProperty = TopProperty::select('*')->whereIn('propertyId',$request['proppertyId'])->get()->toArray();    
        //echo "<prE>"; print_r($property); die;
            $html = '';
            $abc = array();
            /*if (!empty($setProperty)) { 
                foreach ($setProperty as $pro) {*/
                
                    foreach ($property as $all_perm) {
                        //if (array_diff($all_perm, $pro)) {
                        
                            $setProperty123 = TopProperty::select('*')->where('propertyId',$all_perm['id'])->first();    
                            $property123 = Property::select('property_name')->where('id',$all_perm['id'])->first();
                        
                            $html.='<div class="form-group">
                                    <div class="col-md-4"><label for="mainProId" >'.$all_perm['property_name'].'</label></div>';
                            if (isset($setProperty123['fromdate']) || isset($setProperty123['todate'])) {
                                $html.='<div class="col-md-4"><label>'. trans('labels.fromDate').'</label><input type="date" name="fromdate[]" value='.$setProperty123['fromdate'].' class="form-control" style="width: 100%;" placeholder="days" autofocus required ></div>';  
                                $html.='<div class="col-md-4"><label>'. trans('labels.toDate').'</label><input type="date" name="todate[]" value='.$setProperty123['todate'].' class="form-control" placeholder="days" style="width: 100%;" autofocus required ></div>';  
                            } else {

                                $html.='<div class="col-md-4"><label>'. trans('labels.fromDate').'</label><input type="date" name="fromdate[]" value="" class="form-control" placeholder="days" style="width: 100%;" autofocus required ></div>';
                                 $html.='<div class="col-md-4"><label>'. trans('labels.toDate').'</label><input style="width: 100%;" type="date" name="todate[]" value="" class="form-control" placeholder="days" autofocus required ></div>';
                            }
                                $html.="</div>";
                            $html.='<input type="hidden" name="propertyId[]" value="'.$all_perm['id'].'">';
                        //}
                    } 
                
                    return $html;
             /*   } 
            }*/
    }



   
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $topProperty = TopProperty::all();
        $property = Property::all();
        
        $TopProperty = array();
        foreach ($topProperty as $value) {
            $setProperty[] = $value->propertyId;
        }
        return view('admin.topProperty.create',compact('setProperty','property'));
    }

    public function store(Request $request)
    {   //echo 1111; die;
        $request = Request::instance();
        //echo "<prE>"; print_r($request->all()); die;
        $empty_table = DB::table('top_property')->truncate();

        foreach ($request['propertyId'] as $key => $value) {
            $propertyId = $value;
            $fromdate = $request['fromdate'][$key];
            $todate = $request['todate'][$key];
            
            $topProperty = new TopProperty([
                'propertyId' => $propertyId,
                'fromdate'=> $fromdate,
                'todate'=> $todate,
            ]);

              $topProperty->save();
        } 

        
        return redirect('/admin/topCar/create')->with('message', 'New Property created successfully');
    }

    public function edit($id)
    { 
        $property = Property::findOrFail($id);
        $property_type = Property_types::all();
        $property_category = Property_category::all();
        $users= User::all();        
        $ShowRoomAdmin= ShowRoomAdmin::where('issubadmin',2)->get();        
        $property_name =Property_img::select('id','img_name')->where('property_id',$property->id)->get();
        return view('admin.topProperty.edit', compact('property','property_type','property_name','users','ShowRoomAdmin','property_category'));
    }
    public function update(Request $request, $id)
    {
        
        $request = Request::instance();
        $property = Property::findOrFail($id);
        $proId = $property->id;
        if ($request['userType'] == '1') { 
            $request['showRoomId'] = " ";
        } else { 
            $request['userId'] = " ";
        }
        $request['prop_category'] = implode(',', $request['prop_category']);
        
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
                            'property_id' => $proId,
                            'img_name'=> $picture,
                         ]);

                          $property_img->save();    

                } else {
                
                    return redirect('/admin/topCar')->with('errormessage', Lang::get("labels.pleaseUploadValidImage"));
                }
                
            }
        }  
        
        return redirect('/admin/topCar')->with('message', Lang::get("labels.carEditSuccessfully"));
    }


    function delete_img() {
        
        $property_img =Property_img::select('img_name')->where('id', $_POST['del_id'])->first();
        $Property_img = DB::table('property_img')->where('id', $_POST['del_id'])->delete();
        $filePath = public_path('propertyImage/'.$property_img->img_name);
        unlink($filePath);
        
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
        $property = Property::findOrFail($id);

        return view('admin.topProperty.show', compact('property'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = DB::table('properties')->where('id', $id)->delete();
        $Property_img = DB::table('property_img')->where('property_id', $id)->get();
        
        foreach ($Property_img as $value) {
            $filePath = public_path('propertyImage/'.$value->img_name);
            unlink($filePath);

            $Property_imgdel = DB::table('property_img')->where('property_id', $id)->delete();
         
        }
        
        return redirect('/admin/topCar')->with('message', Lang::get("labels.carDeletedSuccessfully"));
      
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

    public function propertymultidelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = Property::whereIn('id', $ids)->get();
        $Property_img = Property_img::whereIn('property_id', $ids)->get();
        
            foreach ($entries as $entry) {
                $entry->delete();
            }

            foreach ($Property_img as $img) {
                $img->delete();
            }
        //return  response()->json(['url'=> route('property.index')]);        
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
