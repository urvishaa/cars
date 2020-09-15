<?php 

namespace App\Http\Controllers\Admin;

use App\Ads;
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

class AdsController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        return view('admin.ads.index');
    }

    public function allposts()
    {
       
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'name',
                            3=> 'published',
                            4=> 'id',
                        );
  
        $totalData = Ads::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  Ads::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Ads::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")    
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  Ads::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Ads::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  Ads::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Ads::count();
        }      
        else
        {            
            $posts = Ads::offset($start)
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
                $nestedData['name'] = $post->name;
                if ($post->published == 1) {
                    $nestedData['published'] ="<span class='fa fa-check-square' ></span>";
                } else {
                    $nestedData['published'] ="<span class='fa fa-window-close' ></span>";
                }
                $nestedData['options'] = "&emsp;<a href='ads/edit/$post->id' title='EDIT' class='btn btn-primary' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='ads/$post->id'>";
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
        return view('admin.ads.create');
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
        //echo "<pre>"; print_r($request->all()); die;

        if ($files = $request->file('image')) {
         
               $destinationPath = public_path('dsaImage/'); // upload path
               $adsImage = time() . "." . $files->getClientOriginalName();
               $files->move($destinationPath, $adsImage);
           
            } else {
                $adsImage ="";
            }

            $Ads = new Ads([
                'type' => $request->get('type'),
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'fromdate' => $request->get('fromdate'),
                'todate' => $request->get('todate'),
                'published'=> $request->get('published'),
                'image'=> $adsImage,
                
            ]);

            $Ads->save();

        //$Ads = Ads::create($request->all());
        return redirect('/admin/ads')->with('message', Lang::get("labels.NewAdsCreatedSuccessfully"));
    }

    public function edit($id)
    {         
        $ads = Ads::findOrFail($id);  
        return view('admin.ads.edit', compact('ads'));
    }

    public function update_ads(Request $request,$id)
    {   
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;

        if ($request->file('image') != '') { 
                
            //$Template = new Template;
            //echo public_path(); die;
            if ($files = $request->file('image')) {
               $destinationPath = public_path('dsaImage/'); // upload path
               $adsImage = time() . "." . $files->getClientOriginalName();
              // echo "<pre>"; print_r($adsImage); die;
               $files->move($destinationPath, $adsImage);
               //$insert['image'] = "$profileImage";
            }   
        } else {
                 $adsImage = $request->get('oldimage'); 
        }

        $user = DB::table('ads')->where('id',$id)->update([
                'type' => $request->get('type'),
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'fromdate' => $request->get('fromdate'),
                'todate' => $request->get('todate'),
                'published'=> $request->get('published'),
                'image'=> $adsImage,
            ]);

        return redirect('/admin/ads')->with('message', Lang::get("labels.AdsEditdSuccessfully"));
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
        $Ads = Ads::findOrFail($id);
        $Ads->delete();
        return redirect('/admin/ads')->with('message', Lang::get("labels.adsDeleteSuccessfully"));
      
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
        $entries = Ads::whereIn('id', $ids)->get();
   
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
