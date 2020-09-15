<?php 

namespace App\Http\Controllers\Admin;

use App\Car;

use App\Car_img;
// use App\ShowRoomAdmin;
use App\TopCar;
use DB;
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

class TopCarController extends Controller
{

    public function getCarId()
    {  
        $request = Request::instance();
        $car = Car::select('id','car_name')->whereIn('id',$request['proppertyId'])->get()->toArray();
        $urlnew = url(''); 
        $new = str_replace('index.php', '', $urlnew);
       
        $html = '';
        $abc = array();
            
                
        foreach ($car as $all_perm) {


            
            $setCar123 = TopCar::select('*')->where('carId',$all_perm['id'])->first();    
            $car123 = Car::select('car_name')->where('id',$all_perm['id'])->first();

        
            $html.='<div class="form-group">
                    <div class="col-md-3"><label for="mainProId" >'.$all_perm['car_name'].'</label></div>';
            if (isset($setCar123['fromdate']) || isset($setCar123['todate'])) {
                $html.='<div class="col-md-4"><label>'. trans('labels.fromDate').'</label><input type="date" name="fromdate[]" value='.$setCar123['fromdate'].' class="form-control" style="width: 100%;" placeholder="days" autofocus required ></div>';  
                $html.='<div class="col-md-4"><label>'. trans('labels.toDate').'</label><input type="date" name="todate[]" value='.$setCar123['todate'].' class="form-control" placeholder="days" style="width: 100%;" autofocus required ></div>';  
                 $html.='<div class="col-md-1"><label style="min-height: 23px;"></label><a class="btn btn-danger" href="'.$new.'/admin/topCar/deletetopcar/'.$all_perm["id"].'"><i class="fa fa-trash" aria-hidden="true"></i> </a></div>';  
            } else {

                $html.='<div class="col-md-4"><label>'. trans('labels.fromDate').'</label><input type="date" name="fromdate[]" value="" class="form-control" placeholder="days" style="width: 100%;" autofocus required ></div>';
                    $html.='<div class="col-md-4"><label>'. trans('labels.toDate').'</label><input style="width: 100%;" type="date" name="todate[]" value="" class="form-control" placeholder="days" autofocus required ></div>';
            }
                $html.="</div>";
            $html.='<input type="hidden" name="carId[]" value="'.$all_perm['id'].'">';
        } 
                
        return $html;
    }



   
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $topCar = TopCar::all();
        $car = Car::all();
        
        $Topcar = array();
        foreach ($topCar as $value) {
            $Topcar[] = $value->carId;
        }
        return view('admin.topCar.create',compact('Topcar','car'));
    }

    public function store(Request $request)
    {   
        $request = Request::instance();
        $empty_table = DB::table('top_car')->truncate();

        foreach ($request['carId'] as $key => $value) {
            $carId = $value;
            $fromdate = $request['fromdate'][$key];
            $todate = $request['todate'][$key];
            
            $topCar = new TopCar([
                'carId' => $carId,
                'fromdate'=> $fromdate,
                'todate'=> $todate,
            ]);

              $topCar->save();
        } 

        
        return redirect('/admin/topCar/create')->with('message', 'Top Car created successfully');
    }

    public function deletetopcar(Request $request)
    {   
      
        $request = Request::instance();
        $empty_table = DB::table('top_car')->where('carId',$request->id)->delete();       
       return redirect('/admin/topCar/create')->with('message', 'Top Car deleted successfully');
    }
}
