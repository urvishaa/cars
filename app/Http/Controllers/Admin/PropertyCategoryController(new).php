<?php 

namespace App\Http\Controllers\Admin;

use App\property_category;
use App\CarBrand;
use App\CarYear;
/*use App\Template;
use App\User;*/
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

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property_type= property_category::paginate();
        return view('admin.category.index', compact('property_type'));
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
                            6 =>'year',
                            7=> 'published',
                            8=> 'id',
                        );
  
        $totalData = property_category::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  property_category::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = property_category::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")    
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  property_category::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = property_category::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  property_category::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir);
                            
            $totalFiltered = property_category::count();
        }      
        else
        {            
            $posts = property_category::offset($start)
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
                $nestedData['year'] = $post->car_year ? $post->car_year : '-';
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
        $carYears = CarYear::all();

        return view('admin.category.create', compact('carBrands','carYears'));
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
        $property_category = new property_category([
            'name' => $request->get('name'),
            'ar' => $request->get('ar'),
            'ku' => $request->get('ku'),
            'car_year' => $request->get('car_year'),
            'car_brand_id' => $request->get('car_brand_id'),
            'published'=> $request->get('published')
        ]);
        $property_category->save();
        
        return redirect('admin/category')->with('message', Lang::get("labels.newModelCreatedSuccessfully"));

    }

    public function edit($id)
    {         
        $carBrands = CarBrand::all();
        $property_features = property_category::findOrFail($id);  
        $carYears = CarYear::all();
        return view('admin.category.edit', compact('property_features','carBrands','carYears'));
    }

    public function update_propertyCategory(Request $request,$id)
    {
        $request = Request::instance();
        $property_features = property_category::findOrFail($id);        
        $property_features->update($request->all());
        
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
        $property_features = property_category::findOrFail($id);
        $property_features->delete();
        return redirect('/admin/category')->with('message', Lang::get("labels.carModelEditDeleted"));
      
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


    public function propertyCategoryalldelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = property_category::whereIn('id', $ids)->get();
        foreach ($entries as $entry) {
            $entry->delete();
        }     
    }


    public function alldelete()
    {   
        $pubid = Request::input('ids'); 
        $ids=explode(',', $pubid);
        $entries = property_category::whereIn('id', $ids)->get();
   
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
        $fields = array('English', 'Arabic','Kurdish','Year');
        fputcsv($f, $fields, $delimiter);
        $data = array(
            array('english'=>'Maruti Swift','ar'=>'Maruti Swift','ku'=>'Maruti Swift','year'=>'2019'),
            array('english'=>'Maruti Wagonr','ar'=>'Maruti Wagonr','ku'=>'Maruti Wagonr','year'=>'2018'),
            array('english'=>'Maruti Vitara Brezza','ar'=>'Maruti Vitara Brezza.','ku'=>'Maruti Vitara Brezza','year'=>'2017'));
        foreach( $data as $row ){
            
            // echo "<pre>";print_r($row);exit;
                $lineData = array(
                'English'    => $row['english'],
                'Arabic'   => $row['ar'],
                'Kurdish'  => $row['ku'],
                'Year'  => $row['year']
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

        // echo $request->car_brand_id;exit;
        if($request->hasFile('car_model_csv')){

            $carModelCsv = $request->car_model_csv;
    
            $file_open = fopen($carModelCsv,"r");        
            $csv = fgetcsv($file_open, 1000, ",");
            $carModels = property_category::where('car_brand_id',$request->car_brand_id)->get();
            $carModelName = $carYears = $sheetCarModelName = [];
            foreach($carModels as $carModel){
                $carModelName[] = strtoupper($carModel->name);
            }
            
            while(($csv = fgetcsv($file_open, 1000, ",")) !== false) 
            { 
                // echo "<pre>";print_r($csv);
                // echo $request->car_brand_id;
                // exit;
                if(!in_array(strtoupper($csv[0]),$carModelName)){
                    if(!in_array(strtoupper($csv[0]),$sheetCarModelName)){
                        $carModel = new property_category;
                        $sheetCarModelName[] = strtoupper($csv[0]); 
                        $carModel->name = $csv[0];
                        $carModel->ar = $csv[1];
                        $carModel->ku = $csv[2];
                        $carModel->published = 1;
                        $carModel->car_brand_id = $request->car_brand_id;
                        $carModel->save();
                        // $carYears[strtoupper($csv[0])]['car_model_id'] = $carModel->id;  
                    }
                        // $carYears[strtoupper($csv[0])][] = $csv[3];
                    // else{
                    //     $existSheetCarModelName[] = $csv[2];
                    // }
                }
            }
        }
        // if(count($carYears)){
        //     foreach($carYears as $carYear){
        //         $yearExist = [];
        //         for($year=0; $year<count($carYear)-1; $year++){
        //             if(!in_array($carYear[$year],$yearExist)){
        //                 $yearExist[] = $carYear[$year];
        //                 $saveYear = new CarYear;
        //                 $saveYear->car_brand_id = $request->car_brand_id;
        //                 $saveYear->car_model_id = $carYear['car_model_id'];
        //                 $saveYear->year = $carYear[$year];
        //                 $saveYear->save();
        //             }
        //         }
        //     }
        // }
        // echo "<pre>";print_r($carYears);exit;
        return redirect('/admin/category')->with('message', Lang::get("labels.carModelImportSuccessfully"));

    }

}
