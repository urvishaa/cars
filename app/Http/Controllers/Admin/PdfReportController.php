<?php 

namespace App\Http\Controllers\Admin;

use App\Price;
use App\Car;
use App\Pdf_report;
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

class PdfReportController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $priceList= Pdf_report::paginate(5);
           

        return view('admin.pdf_report.index', compact('priceList'));
    }

    public function allposts()
    {
       
      $request = Request::instance();
      //echo "<pre>"; print_r($request->all()); die;
        $columns = array( 
                            0 =>'id', 
                            1 =>'id', 
                            2 =>'pro_name',
                            3=> 'pdf_upload',
                            6=> 'id',
                        );
  
        $totalData = Pdf_report::count();
           
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $cat =  $request->input('columns.0.search.value'); 

         if(!empty($request->input('search.value')) && ($cat>0))
        {            
            $search = $request->input('search.value'); 

            $posts =  Pdf_report::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('pro_name', 'LIKE',"%{$search}%")
                            ->orWhere('u_type','=',"{$cat}") 
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pdf_report::where('id','LIKE',"%{$search}%")
                             ->orWhere('pro_name', 'LIKE',"%{$search}%")
                             ->orWhere('u_type','=',"{$cat}") 
                             ->count();
        }   
        else if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  Pdf_report::Where('id', 'LIKE',"%{$search}%")
                            ->orWhere('pro_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pdf_report::where('id','LIKE',"%{$search}%")
                             ->orWhere('pro_name', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else if($cat>0)
        {            
            

            $posts =  Pdf_report::Where('u_type','=',"{$cat}")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Pdf_report::where('u_type','=',"{$cat}")
                            ->count();
        }      
        else
        {            
            $posts = Pdf_report::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
               //echo "<pre>"; print_r($posts); die;
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
               //echo "<pre>"; print_r($post); die;
                $car_name =Car::select('car_name')->where('id', $post->pro_name)->first();
                //echo "<pre>"; print_r($post); die;
                
                $exp = explode('.', $post->pdf_upload);
                //echo "<pre>"; print_r($exp[1].'.'.$exp[2]); die;

                $nestedData['checkdata']="<input type='checkbox' class='case' name='case' value='$post->id'>";
                $nestedData['id'] = $post->id;
                $nestedData['pro_name'] = $car_name->car_name;
                $nestedData['pdf_upload'] =  "<a download=". $exp[1].'.'.$exp[2] ." href=".url('public/pdfFiles/'.$post->pdf_upload)." class=''>". $exp[1].'.'.$exp[2] ."</a>";
                $nestedData['options'] = "&emsp;<a href='pdf_report/edit/$post->id' class='btn btn-primary' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a><form method='POST' action='pdf_report/$post->id'>";
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
    {   //echo 22222; die;
        $Car = Car::all();
        return view('admin.pdf_report.create',compact('Car'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */

    

    public function store(Request $request)
    {   
        $request = Request::instance();
            
            $files = $request->file('pdf_upload');
            
        if (!empty($files)) {
                $extension = $files->getClientOriginalExtension();
                $mimeType = $files->getMimeType();
                $image_name = str_replace(' ', '-', $files->getClientOriginalName());
                $picture = time() . "." . $image_name;
                $destinationPath = public_path('pdfFiles/');
               
                $valid_extension = array("pdf","PDF");

                $rules= [
                     'file' => 'mimes:pdf,PDF'
                ];
                    $x = $request->all();
                    $validator=Validator::make($x, $rules);
        
               if (in_array(strtolower($extension),$valid_extension)) {
                    
                    
                    $files->move($destinationPath, $picture);

                    $pdf_report = new Pdf_report([
                        'pro_name' => $request['pro_name'],
                        'pdf_upload'=> $picture,
                    ]);
    
                      $pdf_report->save();

               } else {
                return redirect('/admin/car')->with('errormessage', 'please upload valid PDF File.');
               }
        }  

        return redirect('/admin/pdf_report')->with('message', 'PDF file uploaded successfully');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        //echo $id; die;
        $Car = Car::all();
        $Pdf_report = Pdf_report::findOrFail($id);  
        return view('admin.pdf_report.edit', compact('Pdf_report','Car'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_pdfFile(Request $request,$id)
    {   

        $request = Request::instance();

        $files = $request->file('pdf_upload');
        if (!empty($files)) {
            $extension = $files->getClientOriginalExtension();
            $mimeType = $files->getMimeType();
            $image_name = str_replace(' ', '-', $files->getClientOriginalName());
            $picture = time() . "." . $image_name;
            $destinationPath = public_path('pdfFiles/');
            
            $valid_extension = array("pdf","PDF");

            $rules= [
                    'file' => 'mimes:pdf,PDF'
            ];
            $x = $request->all();
            $validator=Validator::make($x, $rules);

            if (in_array(strtolower($extension),$valid_extension)) {
            
                $files->move($destinationPath, $picture);

            } else {
                return redirect('/admin/pdf_report')->with('errormessage', 'please upload valid PDF File.');
            }

        } else {
            $picture = $request['oldpdf_upload'];
        }           
                
                $pdf_report = DB::table('pdf_report')->where('id','=',$id )->update([
                    'pro_name' => $request['pro_name'],
                    'pdf_upload'=> $picture,
                ]);

        return redirect('/admin/pdf_report')->with('message', 'PDF File Edited successfully');
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

        $Price = Pdf_report::findOrFail($id);
        $Price->delete();

        return redirect('/admin/pdf_report')->with('message', 'PDF File Deleted successfully');
      
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


    public function priceListalldelete(Request $request)
    { 
        $request = Request::instance();
        //echo "<pre>"; print_r($request->all()); die;
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = Price::whereIn('id', $ids)->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
    }


    public function alldelete()
    {   
        $pubid = Request::input('ids'); 

        $ids=explode(',', $pubid);
        $entries = car_features::whereIn('id', $ids)->get();
   
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
