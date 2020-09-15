<?php 

namespace App\Http\Controllers\Admin;

use App\Car_types;
use App\CarBrand;
/*use App\User;*/
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
use Lang;

class CarBrandController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.carBrand.index');
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
                            5=> 'published',
                            6=> 'id',
                        );
  
        $totalData = CarBrand::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

       if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  CarBrand::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = CarBrand::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  CarBrand::Where('u_type','=',"{$cat}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = CarBrand::where('u_type','=',"{$cat}")
                            ->count();
        }      
        else
        {            
            $posts = CarBrand::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['ar'] = $post->ar;
                $nestedData['ku'] = $post->ku;

                if ($post->status == 1) {
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                $nestedData['options'] = "&emsp;<a href='carBrand/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='carBrand/$post->id'>";
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
        return view('admin.carBrand.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */

    
    public function store()
    {
        
        $request = Request::instance();
        
        $user = CarBrand::create($request->all());
        
        return redirect('/admin/carBrand')->with('message', Lang::get("labels.newCarBrandCreateSuccessfully"));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $carBrand = CarBrand::findOrFail($id);  
        
        return view('admin.carBrand.edit', compact('carBrand'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {   
        $request = Request::instance();
        
        $carBrand = CarBrand::findOrFail($id);
        
        $carBrand->update($request->all());
        
        return redirect('/admin/carBrand')->with('message', Lang::get("labels.carBrandEditedSuccessfully"));
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
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $CarBrand = CarBrand::findOrFail($id);
        $CarBrand->delete();

        return redirect('/admin/carBrand')->with('message', Lang::get("labels.carBrandDeleteSuccessfully"));
      
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
        $entries = CarBrand::whereIn('id', $ids)->get();
   
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
        $filename = "sample" . ".csv";

        $f = fopen('php://memory', 'w');
        $fields = array('English', 'Arabic','Kurdish');
        fputcsv($f, $fields, $delimiter);
        $data = array(
            array('english'=>'Maruti-Suzuki','ar'=>'Maruti-Suzuki','ku'=>'Maruti-Suzuki'),
            array('english'=>'Mahindra','ar'=>'Mahindra','ku'=>'Mahindra'),
            array('english'=>'Tata','ar'=>'Tata','ku'=>'Tata'));
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

    public function carBrandImportView(){
        return view('admin.carBrand.import');
    }
    public function carBrandImport(){
        $request = Request::instance();
        if($request->hasFile('car_brand_csv')){

            $carBrandCsv = $request->car_brand_csv;
    
            $file_open = fopen($carBrandCsv,"r");        
            $csv = fgetcsv($file_open, 1000, ",");
            $carBrands = CarBrand::all();
            $carBrandName = $newCarBrandName = $existCarBrandName = [];
            foreach($carBrands as $carBrand){
                $carBrandName[] = strtoupper($carBrand->name);
            }
            while(($csv = fgetcsv($file_open, 1000, ",")) !== false) 
            { 
                if(!in_array(strtoupper($csv[0]),$carBrandName)){
                    if(!in_array(strtoupper($csv[0]),$newCarBrandName)){
                        $carBrand = new CarBrand;
                        $newCarBrandName[] = strtoupper($csv[0]); 
                        $carBrand->name = $csv[0];
                        $carBrand->ar = $csv[1];
                        $carBrand->ku = $csv[2];
                        $carBrand->status = 1;
                        $carBrand->save();
                    }
                }
                // else{
                //     $existCarBrandName[] = $csv[0];
                // }
            }
        }
        return redirect('/admin/carBrand')->with('message', Lang::get("labels.carBrandImportSuccessfully"));

    }

    

}
