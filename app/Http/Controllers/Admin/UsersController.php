<?php 

namespace App\Http\Controllers\Admin;

use App\User;
use App\Usergroup;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Hash;
use DB;
use Lang;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$users = array();
        $request = Request::instance();
       
        $catsearch = $request->request->get('category');
    
        $users= User::paginate();
            
        $usergroups= Usergroup::all();
        return view('admin.users.index', compact('users','usergroups','catsearch'));
    }

    public function allposts()
    {
       
      $request = Request::instance();

        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'name',
                            3=> 'email',
                            4=> 'id',
                        );
  
        $totalData = User::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = 'Desc';
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  User::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                               ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  User::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  User::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::count();
        }      
        else
        {            
            $posts = User::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
               
                $type =Usergroup::select('typeName')->where('id', $post->u_type)->first();
                
                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;            
                $nestedData['options'] = "&emsp;<a href='users/$post->id/edit' class='btn btn-primary' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='users/$post->id'>";
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
        //$usergroups= Usergroup::all();
        
        return view('admin.users.create');
    }

    public function store(StoreUsersRequest $request)
    {
            if ($files = $request->file('image')) {
         
               $destinationPath = public_path('profileImage/'); // upload path
               $profileImage = time() . "." . $files->getClientOriginalName();
               $files->move($destinationPath, $profileImage);
           
            } else {
                $profileImage = '';
            }

            if ($request->get('aged') != "") {
                $aged = $request->get('aged');
            } else {
                $aged = "";
            }

            $user = new User([
                    'name' => $request->get('name'),
                    'lname' => $request->get('lname'),
                    'username' => $request->get('username'),
                    'email' => $request->get('email'),
                    'aged' => $aged,
                    //'password' => $request->get('password'),
                    'dob' => $request->get('dob'),
                    'gender' => $request->get('gender'),
                    'address' => $request->get('address'),
                    'image'=> $profileImage,
                    
                ]);

                $user->save();


         User::where('id', $user->id)->update(['password' => md5($request->password) ]); 
         return redirect('/admin/users')->with('message', Lang::get("labels.newUserCreatedSuccessfully"));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $user = User::findOrFail($id);  
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {

        if ($request->file('image') != '') { 
                
                if ($files = $request->file('image')) {
                   $destinationPath = public_path('profileImage/'); // upload path
                   $profileImage = time() . "." . $files->getClientOriginalName();
                   $files->move($destinationPath, $profileImage);
                   //$insert['image'] = "$profileImage";
                }   
            } else {
                     $profileImage = $request->get('oldimage'); 
            }


            if(!empty($request->password)){ 
                $password = md5($request->password);           
            } else { 
                $password = $request->old_password;
            }  

            if ($request->get('aged') != "") {
                $aged = $request->get('aged');
            } else {
                $aged = "";
            }

            $user = DB::table('users')->where('id',$id)->update([
                'name' => $request->get('name'),
                'lname' => $request->get('lname'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => $password,
                'dob' => $request->get('dob'),
                'gender' => $request->get('gender'),
                'aged' => $aged,
                'address' => $request->get('address'),
                'image'=> $profileImage,
            ]);

        return redirect('/admin/users')->with('message', Lang::get("labels.userEditedSuccessfully"));
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

        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('message', Lang::get("labels.userDeleteSuccessfully"));
      
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
        $entries = User::whereIn('id', $ids)->get();
   
            foreach ($entries as $entry) {
                $entry->delete();
            }
        return  response()->json(['url'=> route('users.index')]);        
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
