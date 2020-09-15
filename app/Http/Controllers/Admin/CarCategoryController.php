<?php 

namespace App\Http\Controllers\Admin;

use App\CarModel;
use App\CarBrand;
use App\CarYear;
/*use App\Template;
use App\User;*/
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Hash;
use Lang;

class CarCategoryController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        return view('admin.category.index');
    }

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'name',
                            3 =>'ar',
                            4 =>'ku',
                            5=> 'car_brand',
                            6=> 'published',
                            7=> 'id',
                        );
  
        $totalData = CarModel::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  CarModel::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = CarModel::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")    
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  CarModel::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = CarModel::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  CarModel::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = CarModel::count();
        }      
        else
        {            
            $posts = CarModel::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir);
                        
        }
        $posts = $posts->with('hasOneCarBrand')->get();

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $carBrandObj = $post->hasOneCarBrand ? $post->hasOneCarBrand : '';
                $carBrandName = $carBrandObj ? $carBrandObj->name : '';
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['ar'] = $post->ar;
                $nestedData['ku'] = $post->ku;
                $nestedData['car_brand'] = $carBrandName;
                if ($post->published == 1) {
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                $nestedData['options'] = "&emsp;<a href='category/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='category/$post->id'>";
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
        $carBrands = CarBrand::all();

        return view('admin.category.create', compact('carBrands'));
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
        $car_category = new CarModel([
            'name' => $request->get('name'),
            'ar' => $request->get('ar'),
            'ku' => $request->get('ku'),
            'car_brand_id' => $request->get('car_brand_id'),
            'published'=> $request->get('published')
        ]);
        $car_category->save();
        
        return redirect('admin/category')->with('message', Lang::get("labels.newModelCreatedSuccessfully"));

    }

    public function edit($id)
    {         
        $carBrands = CarBrand::all();
        $car_edit = CarModel::findOrFail($id);  
        return view('admin.category.edit', compact('car_edit','carBrands'));
    }

    public function update_carCategory(Request $request,$id)
    {
        $request = Request::instance();
        $car_features = CarModel::findOrFail($id);        
        $car_features->update($request->all());
        
        return redirect('/admin/category')->with('message', Lang::get("labels.carModelEditSuccessfully"));
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
        $car_features = CarModel::findOrFail($id);
        $car_features->delete();
        return redirect('/admin/category')->with('message', Lang::get("labels.carModelEditDeleted"));
      
    }



    public function carCategoryalldelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = CarModel::whereIn('id', $ids)->get();
        foreach ($entries as $entry) {
            $entry->delete();
        }     
    }


    public function alldelete()
    {   
        $pubid = Request::input('ids'); 
        $ids=explode(',', $pubid);
        $entries = CarModel::whereIn('id', $ids)->get();
   
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

    public function sampleDownload(){            
        $lineData = array();
        $delimiter = ",";
        $filename = "carModel" .time(). ".csv";

        $f = fopen('php://memory', 'w');
        $fields = array('English', 'Arabic','Kurdish');
        fputcsv($f, $fields, $delimiter);
        $data = array(
            array('english'=>'Maruti Swift','ar'=>'Maruti Swift','ku'=>'Maruti Swift'),
            array('english'=>'Maruti Wagonr','ar'=>'Maruti Wagonr','ku'=>'Maruti Wagonr'),
            array('english'=>'Maruti Vitara Brezza','ar'=>'Maruti Vitara Brezza.','ku'=>'Maruti Vitara Brezza'));
        foreach( $data as $row ){
            
            // echo "<pre>";print_r($row);exit;
                $lineData = array(
                'English'    => $row['english'],
                'Arabic'   => $row['ar'],
                'Kurdish'  => $row['ku'],
            );
            
            fputcsv($f, $lineData, $delimiter);

        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
    }

    public function carModelImportView(){
        $carBrands = CarBrand::all();
        return view('admin.category.import',['carBrands'=>$carBrands]);
    }
    public function carModelImport(){
        $request = Request::instance();

        if($request->hasFile('car_model_csv')){
            
            $carModelCsv = $request->car_model_csv;
            
            $file_open = fopen($carModelCsv,"r");        
            $csv = fgetcsv($file_open, 1000, ",");
            $carModels = CarModel::where('car_brand_id',$request->car_brand_id)->get();
            $carModelName = $sheetCarModelName = [];
            foreach($carModels as $carModel){
                $carModelName[] = strtoupper($carModel->name);
            }
            $carBrand = CarBrand::find($request->car_brand_id);
            while(($csv = fgetcsv($file_open, 1000, ",")) !== false) 
            { 
                
                if(strtoupper($carBrand->name) == strtoupper($csv[1])){
                    if(!in_array(strtoupper($csv[2]),$carModelName)){
                        if(!in_array(strtoupper($csv[2]),$sheetCarModelName)){
                            $carModel = new CarModel;
                            $sheetCarModelName[] = strtoupper($csv[2]); 
                            $carModel->name = $csv[2];
                            $carModel->ar = $csv[2];
                            $carModel->ku = $csv[2];
                            $carModel->published = 1;
                            $carModel->car_brand_id = $request->car_brand_id;
                            $carModel->save();
                        }
                    }
                }
            }
        }
       
        return redirect('/admin/category')->with('message', Lang::get("labels.carModelImportSuccessfully"));

    }

}
