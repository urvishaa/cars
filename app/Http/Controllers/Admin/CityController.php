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
use DB;
use Lang;

class CityController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $city= DB::table('city')->paginate(10);

        return view('admin.city.index', compact('city'));
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
                            
                        );
  
        $totalData = DB::table('city')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  DB::table('city')->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('ar', 'LIKE',"%{$search}%")
                            ->orWhere('ku', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('city')->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('ar', 'LIKE',"%{$search}%")
                            ->orWhere('ku', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else 
        {            
            $posts = DB::table('city')->offset($start)
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
                $nestedData['options'] = "&emsp;<a href='city/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='city/$post->id'>";
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
        return view('admin.city.create');
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
        $name = $request->input('name');
         $ar = $request->input('ar');
          $ku = $request->input('ku');
        DB::table('city')->insert(array('name'=>$name,'ku'=>$ku,'ar'=>$ar));

        return redirect('admin/city')->with('message', Lang::get("labels.cityCreatedSuccessfully"));

    }

    public function store(StoreUsersRequest $request)
    {

        $user = User::create($request->all());
         User::where('id', $user->id)->update(['password' => md5($request->password) ]); 
         return redirect('/admin/users')->with('message', Lang::get("labels.cityCreatedSuccessfully"));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        
        $city = DB::table('city')->where('id',$id)->first();  
        
        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_city(Request $request,$id)
    {
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $name = $request->input('name');
         $ar = $request->input('ar');
          $ku = $request->input('ku');
        $city =  DB::table('city')->where('id',$id)->update(array('name'=>$name,'ku'=>$ku,'ar'=>$ar));
        
        return redirect('/admin/city')->with('message', Lang::get("labels.cityEditSuccessfully"));
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
        //echo 1111; die;
     
        DB::table('city')->where('id',$id)->delete();

        return redirect('/admin/city')->with('message', Lang::get("labels.cityDeleteSuccessfully"));
      
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

    public function cityalldelete(Request $request)
    { 
        $request = Request::instance();
     
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        foreach ($ids as $entry) {
         DB::table('city')->whereIn('id', $ids)->delete();
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
