<?php 

namespace App\Http\Controllers\Admin;

use App\pro_category;
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

class ProCategoryController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_type= pro_category::paginate();
        return view('admin.procategory.index', compact('car_type'));
    }

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'name',
                            2 =>'ar',
                            2 =>'ku',
                            3=> 'published',
                            6=> 'id',
                        );
  
        $totalData = pro_category::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  pro_category::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('ar', 'LIKE',"%{$search}%")
                            ->orWhere('ku', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = pro_category::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")    
                             ->orWhere('ar', 'LIKE',"%{$search}%")    
                             ->orWhere('ku', 'LIKE',"%{$search}%")    
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  pro_category::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('ar', 'LIKE',"%{$search}%")
                            ->orWhere('ku', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = pro_category::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->orWhere('ar', 'LIKE',"%{$search}%")
                             ->orWhere('ku', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  pro_category::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = pro_category::count();
        }      
        else
        {            
            $posts = pro_category::offset($start)
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
                $nestedData['options'] = "&emsp;<a href='procategory/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='procategory/$post->id'>";
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
        return view('admin.procategory.create');
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
        $car_category = new pro_category([
            'name' => $request->get('name'),
            'ar' => $request->get('ar'),
            'ku' => $request->get('ku'),
            'published'=> $request->get('published')
        ]);
        $car_category->save();
        
        return redirect('admin/procategory')->with('message', Lang::get("labels.newProductCategoryCreatedSuccessfully"));;

    }

   
    public function edit($id)
    {         
        $car_features = pro_category::findOrFail($id);  
        return view('admin.procategory.edit', compact('car_features'));
    }

    public function update_carCategory(Request $request,$id)
    {
        $request = Request::instance();
        $car_features = pro_category::findOrFail($id);        
        $car_features->update($request->all());
        
        return redirect('/admin/procategory')->with('message', Lang::get("labels.productCategoryEditedSSuccessfully"));
    }



    public function destroy($id)
    {
        $car_features = pro_category::findOrFail($id);
        $car_features->delete();
        return redirect('/admin/procategory')->with('message', Lang::get("labels.productCategoryDeletedSuccessfully"));
      
    }



    public function carCategoryalldelete(Request $request)
    { 
        $request = Request::instance();
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = pro_category::whereIn('id', $ids)->get();
        foreach ($entries as $entry) {
            $entry->delete();
        }     
    }


    public function alldelete()
    {   
        $pubid = Request::input('ids'); 
        $ids=explode(',', $pubid);
        $entries = pro_category::whereIn('id', $ids)->get();
   
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

    

}
