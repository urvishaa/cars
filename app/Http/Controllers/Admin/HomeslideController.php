<?php 

namespace App\Http\Controllers\Admin;

use App\Ads;
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
use DB;

class HomeslideController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $homeslide= DB::table('homeslide')->paginate(10);
        return view('admin.homeslide.index', compact('homeslide'));
    }

      public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'title',
                            3 =>'description',
                            4 =>'image',

                            
                            
                        );
  
        $totalData = DB::table('homeslide')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  DB::table('homeslide')->Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('homeslide')->where('id','LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                            ->orWhere('description', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else 
        {            
            $posts = DB::table('homeslide')->offset($start)
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
                $nestedData['title'] = $post->title;
                $nestedData['description'] = $post->description;
                if (!empty($post->image)) {
                    $nestedData['image'] = "<img src='".url('public/homeslide/'.$post->image)."' width='100' height='100' >" ;    
                } else {
                    $nestedData['image'] = "<img src='".url('public/default-image.jpeg')."' width='100' height='100' >";
                }
                $nestedData['options'] = "&emsp;<a href='homeslide/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='homeslide/$post->id'>";
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
        return view('admin.homeslide.create');
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

       
        $title = $request->get('title');
        $description = $request->get('description');
        $titlearabic = $request->get('titlearabic');
        $descriptionarabic = $request->get('descriptionarabic');
        $titlekurdish = $request->get('titlekurdish');
        $descriptionkurdish = $request->get('descriptionkurdish');
      
        if ($files = $request->file('image')) {
            $destinationPath = public_path('homeslide/'); // upload path
            $adsImage = time() . "." . $files->getClientOriginalName();
            $files->move($destinationPath, $adsImage);
        }   
     
        DB::table('homeslide')->insert(array('image'=>$adsImage,'description'=>$description,'title'=>$title,'titlekurdish'=>$titlekurdish,'descriptionkurdish'=>$descriptionkurdish,'descriptionarabic'=>$descriptionarabic,'titlearabic'=>$titlearabic));

        return redirect('admin/homeslide')->with('message', 'Homeslide inserted successfully');

    }

    public function edit($id)
    {         
        $homeslide =  DB::table('homeslide')->where('id',$id)->first();  
        return view('admin.homeslide.edit', compact('homeslide'));
    }

    public function update_homeslide(Request $request,$id)
    {   
        $request = Request::instance();
        
        if ($request->file('image') != '') { 
                
            if ($files = $request->file('image')) {
                $destinationPath = public_path('homeslide/'); // upload path
                $adsImage = time() . "." . $files->getClientOriginalName();
                $files->move($destinationPath, $adsImage);
            }   
        } else {
                 $adsImage = $request->get('oldimage'); 
        }

        $user = DB::table('homeslide')->where('id',$id)->update([
                
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'titlearabic' => $request->get('titlearabic'),
                'descriptionarabic' => $request->get('descriptionarabic'),
                'titlekurdish' => $request->get('titlekurdish'),
                'descriptionkurdish' => $request->get('descriptionkurdish'),
                'image'=> $adsImage,
            ]);

        return redirect('/admin/homeslide')->with('message', 'Homeslide Edited successfully');
    }


    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        $homeslide = User::findOrFail($id);
        return view('admin.homeslide.show', compact('homeslide'));
    }

    public function destroy($id)
    {   
       DB::table('homeslide')->where('id',$id)->delete();
        return redirect('/admin/homeslide')->with('message', 'Homeslide Deleted successfully');
      
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

    public function homeslidealldelete()
     { 
        $request = Request::instance();
     
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        foreach ($ids as $entry) {
        DB::table('homeslide')->whereIn('id',$ids)->delete();
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
