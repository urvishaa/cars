<?php 

namespace App\Http\Controllers\Admin;

use App\Car_types;
/*use App\Template;
use App\User;*/
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

class carTypeController extends Controller
{
    
    public function index()
    {
    
        return view('admin.car_type.index');
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
  
        $totalData = Car_types::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
       
       if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  Car_types::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Car_types::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else
        {            
            $posts = Car_types::offset($start)
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
                if ($post->published == 1) {
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                $nestedData['options'] = "&emsp;<a href='car_type/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='car_type/$post->id'>";
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

    public function create()
    {   
        return view('admin.car_type.create');
    }

    public function save()
    {

        $request = Request::instance();
        $car_type = new Car_types([
            'name' => $request->get('name'),
            'ar' => $request->get('ar'),
            'ku' => $request->get('ku'),
            'published'=> $request->get('status')
        ]);
            $car_type->save();
        
        return redirect('admin/car_type')->with('message', Lang::get("labels.newCarTypeCreatedSuccessfully"));

    }

    public function edit($id)
    { 
        
        $car_types = Car_types::findOrFail($id);  
        
        return view('admin.car_type.edit', compact('car_types'));
    }

  
    public function update_carType(Request $request,$id)
    {
        $request = Request::instance();
        $car_types = Car_types::findOrFail($id);
        
        $car_types->update($request->all());
        
        return redirect('/admin/car_type')->with('message', Lang::get("labels.carTypeEditedSuccessfully"));
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
        $car_types = Car_types::findOrFail($id);
        $car_types->delete();

        return redirect('/admin/car_type')->with('message', Lang::get("labels.carTypeDeletedSuccessfully"));
      
    }

    public function carTypealldelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = Car_types::whereIn('id', $ids)->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
    }



    public function alldelete()
    {   
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = Car_types::whereIn('id', $ids)->get();
   
            foreach ($entries as $entry) {
                $entry->delete();
            }
    }
  
   

    

}
