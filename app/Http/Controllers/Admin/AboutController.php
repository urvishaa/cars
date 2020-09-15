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

class AboutController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $testimonials= DB::table('testimonials')->paginate(10);

        // return view('admin.about.index', compact('testimonials'));
        // return view('admin.about.xml_get_current_byte_index(parser)');
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $about = DB::table('aboutus')->first();
        return view('admin.about.create',compact('about'));
    }

   

    public function save()
    {

        $request = Request::instance();
        $id = $request->input('id');
        $description = $request->input('description');
       
        $old = $request->input('old_image');
        if($id == '')
        {
           
            if ($files = $request->file('image')) {
             
               $destinationPath = public_path('aboutImage/'); // upload path
               $adsImage = time() . "." . $files->getClientOriginalName();
               $files->move($destinationPath, $adsImage);
               
            } 
            DB::table('aboutus')->insert(array('image'=>$adsImage,'description'=>$description));

            return redirect('admin/about/create')->with('message', 'About us inserted successfully');

        } else {

         
        if ($files = $request->file('image')) {
         
           $destinationPath = public_path('aboutImage/'); // upload path
           $adsImage = time() . "." . $files->getClientOriginalName();
           $files->move($destinationPath, $adsImage);
           
        } else {
            $adsImage = $old;
        }
        DB::table('aboutus')->update(array('image'=>$adsImage,'description'=>$description));

        return redirect('admin/about/create')->with('message', 'About us edit successfully');

        }

    }

    


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        
        $testimonials = DB::table('aboutus')->where('id',$id)->first();  
      
        return view('admin.testimonials.edit', compact('testimonials'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_aboutus(Request $request,$id)
    {
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $username = auth()->guard('admin')->user()->first_name;
        $description = $request->input('description');
        $title = $request->input('title');

        DB::table('testimonials')->where('id',$id)->update(array('username'=>$username,'description'=>$description,'title'=>$title));
        
        return redirect('/admin/testimonials')->with('message', 'Testimonials edited successfully');
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

        return view('admin.testimonials.show', compact('user'));
    }

    

}
