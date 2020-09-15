<?php 

namespace App\Http\Controllers\Web;

use App\property_features;
use App\Template;
use App\User;
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



class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'fename',
                            3=> 'published',
                            6=> 'id',
                        );
  
        $totalData = property_features::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  property_features::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('fename', 'LIKE',"%{$search}%")
                            ->orWhere('u_type','=',"{$cat}") 
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = property_features::where('id','LIKE',"%{$search}%")
                             ->orWhere('fename', 'LIKE',"%{$search}%")
                             ->orWhere('u_type','=',"{$cat}") 
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  property_features::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('fename', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = property_features::where('id','LIKE',"%{$search}%")
                             ->orWhere('fename', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  property_features::Where('u_type','=',"{$cat}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = property_features::where('u_type','=',"{$cat}")
                            ->count();
        }      
        else
        {            
            $posts = property_features::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
               //echo "<pre>"; print_r($post); die;
                /*$owner =User::select('name')->where('id', $post->ownerid)->first();
                $agent =User::select('name')->where('id', $post->agentid)->first();*/
                
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['fename'] = $post->fename;
                if ($post->published == 1) {
                    $nestedData['published'] ="<span class='btn btn-warning btn-xs' style='cursor:text;'>Published</span>";
                } else {
                    $nestedData['published'] ="<span class='btn btn-danger btn-xs' style='cursor:text;'>Unpublished</span>";
                }
                $nestedData['options'] = "&emsp;<a href='property_features/edit/$post->id' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='/realestate/admin/property_features/$post->id'>";
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
    public function create($id)
    {   
       
        $user_email = User::where('id', $id)->first();
        //echo "<pre>"; print_r($user_email); die;
        // $user_email['email']->email; 

        return view('forgotPassword.create',compact('user_email'));
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
    //  echo "<pre>"; print_r($request->all()); die;
        $id = $request->get('userId'); 
        
	$get_email = User::where('id', $id)->first();
	//echo "<pre>"; print_r($get_email->email); die;
	if($get_email->email == $request->get('oldemail')) { 
	
	        if ($request->get('new_password') == $request->get('con_password')) { 
	            $changePass = DB::table('users')->where('email','=',$request->get('oldemail') )->update([
	                    'password'=> md5($request->get('new_password')),
	                ]);
	        } else { 
	            return redirect('ForgotPassword/'.$id)->with('message', 'new password and confirm password is not Match'); die;
	        } 
        } else { 
         	return redirect('ForgotPassword/'.$id)->with('message', 'Please Enter Valid email address'); die;
         }
         
        return redirect('/success');

    }

    public function store(StoreUsersRequest $request)
    {

        $user = User::create($request->all());
         User::where('id', $user->id)->update(['password' => md5($request->password) ]); 
         return redirect('/admin/users')->with('message', 'New User created successfully');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        
        $property_features = property_features::findOrFail($id);  
        //echo "<pre>"; print_r($property_features); die;
        //$usergroups= Usergroup::all();
        return view('admin.property_features.edit', compact('property_features'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_propertyFeatures(Request $request,$id)
    {
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $property_features = property_features::findOrFail($id);
        
        $property_features->update($request->all());
        
        return redirect('/admin/property_features')->with('message', 'Property Features Edited successfully');
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

        $property_features = property_features::findOrFail($id);
        $property_features->delete();

        return redirect('/admin/property_features')->with('message', 'Property Features Deleted successfully');
      
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


    public function propertyFeaturesalldelete(Request $request)
    { 
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = property_features::whereIn('id', $ids)->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        //return  response()->json(['url'=> route('property.index')]);        
    }


    public function alldelete()
    {   
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = property_features::whereIn('id', $ids)->get();
   
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
