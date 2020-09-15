<?php 

namespace App\Http\Controllers\Admin;

use App\Property_types;
use App\CarBrand;
use App\property_category;
/*use App\User;*/
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
use DB;

class YearController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // exit;
       
        return view('admin.year.index');
    }

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'car_brand_id', 
                            3 =>'car_model_id',
                            4 =>'year',
                            
                        );
  
        $totalData = DB::table('car_year')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  DB::table('car_year')->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('year', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('car_year')->where('id','LIKE',"%{$search}%")
                            ->orWhere('year', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else 
        {            
            $posts = DB::table('car_year')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $brand = CarBrand::where('id',$post->car_brand_id)->select('name')->first();
                $model = property_category::where('id',$post->car_model_id)->select('name')->first();


                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['year'] = $post->year;
                $nestedData['car_brand_id'] = $brand->name;
                $nestedData['car_model_id'] = $model->name;

                $nestedData['options'] = "&emsp;<a href='year/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='year/$post->id'>";
                $nestedData['options'] .=  csrf_field();
                $nestedData['options'] .= method_field("DELETE");
                $nestedData['options'] .=  "<button class='btn btn-danger' onclick='return ConfirmDelete()'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                    </form>";
                $data[] = $nestedData;

            }
        }
                // echo '<pre>'; print_r($brand); die;
          
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
         $carBrand = CarBrand::where('status',1)->get();
        return view('admin.year.create',compact('carBrand'));
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
        $year = $request->get('year');
        $car_brand_id = $request->get('car_brand_id');
        $car_model_id = $request->get('car_model_id');

        DB::table('car_year')->insert(array('year'=>$year,'car_brand_id'=>$car_brand_id,'car_model_id'=>$car_model_id));

        return redirect('admin/year')->with('message', 'Year inserted successfully');

    }

    public function store(StoreUsersRequest $request)
    {

        $user = User::create($request->all());
         User::where('id', $user->id)->update(['password' => md5($request->password) ]); 
         return redirect('/admin/year')->with('message', 'New year created successfully');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $year = DB::table('car_year')->where('id',$id)->first();
        $carBrand = CarBrand::where('status',1)->get();
        $carModels = property_category::where('car_brand_id',$year->car_brand_id)->get();
        
        return view('admin.year.edit', compact('carBrand','year','carModels'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_year(Request $request,$id)
    {
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $year = $request->get('year');
        $car_brand_id = $request->get('car_brand_id');
        $car_model_id = $request->get('car_model_id');

        $city =  DB::table('car_year')->where('id',$id)->update(array('year'=>$year,'car_brand_id'=>$car_brand_id,'car_model_id'=>$car_model_id));
        
        return redirect('/admin/year')->with('message', 'Year Edited successfully');
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

        return view('admin.year.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo 1111; die;
     
        DB::table('car_year')->where('id',$id)->delete();

        return redirect('/admin/year')->with('message', 'Year Deleted successfully');
      
    }


    public function yearalldelete(Request $request)
    { 
        $request = Request::instance();
     
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        foreach ($ids as $entry) {
         DB::table('car_year')->whereIn('id', $ids)->delete();
            }
        //return  response()->json(['url'=> route('property.index')]);        
    }



    public function alldelete()
    {   
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = Property_types::whereIn('id', $ids)->get();
   
            foreach ($entries as $entry) {
                $entry->delete();
            }
        //return  response()->json(['url'=> route('property_type.index')]);        
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
