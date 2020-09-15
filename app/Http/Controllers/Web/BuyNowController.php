<?php 

namespace App\Http\Controllers\Web;
use Validator;

use DB;
//for password encryption or hash protected
use Hash;

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
//for Carbon a value 
use Carbon;
// use Request;
//email
use Illuminate\Support\Facades\Mail;
use App\Orders;
use App\PlaceOrder;
use App\CarAccessories;
use App\Car;
use App\Car_img;
use Session;

class BuyNowController extends Controller
{
    public function addCart(Request $request){
        if(Session::has('userName')){
            $carts = session()->get('cart');
            $quantity = 0;
            foreach($carts as $cart){
                $carAccessories = CarAccessories::find($cart['id']);
                $placeOrders = PlaceOrder::where('Product_Id',$cart['id'])->get();
                foreach($placeOrders as $placeOrder){
                    $quantity = $quantity + $placeOrder->Quantity;
                }
                $cartQuantity = $quantity + $cart['quantity'];
                $compareQuantity = $carAccessories->quantity-$cartQuantity;
                if( $compareQuantity < 0 || $cart['quantity'] == 0){
                    return redirect()->route('showcart')->with('message', ucfirst($cart["name"])." ". trans('labels.Product')." ".trans('labels.quantityAvailable'));
                }                
            }
            if(count($carts) == 0){
                return redirect()->route('storeadminlist');
            }
            $cities = DB::table('city')->get();        
            $result['total'] = $request->total;
            $result['cities'] = $cities;
            return view('themes.themeone.views.addcartform', compact('result'));
        }
        else{
            return redirect()->route('login');
        }
    }
    public function saveCart(Request $request)
    {
        if(Session::has('userName')){
            $order = new Orders();
            $order->Name= $request->name;
            $order->User_Id = session()->get('userId');
            $order->Mobile= $request->mobile;
            $order->address= $request->address;
            $order->city= $request->city;
            $order->TotalCount= session()->get('grandTotal');;
            $order->Status = 'Pending';
            $order->save();

            $lastId = $order->Order_ID;
            $carts = session()->get('cart');
        

            foreach($carts as $cart){
                $placeOrder = new PlaceOrder();
                $placeOrder->Order_ID = $lastId;                
                $placeOrder->Product_ID = $cart['id'];
                $placeOrder->Name = $cart['name'];
                $placeOrder->Price = $cart['price'];
                $placeOrder->Quantity = $cart['quantity'];
                $placeOrder->save();
            }
            session()->forget('cart');
            session()->forget('grandTotal');
            return redirect()->route('order.list')->with('message', trans('labels.orderAddedSuccessfully'));
    
        }
        else{
            return redirect()->route('login');
        }
    }
    public function orderList(){
        if(Session::has('userName')){
            $orders = Orders::with('hasOneCity')->where('User_ID',session()->get('userId'))->get();
           
            $result['orders'] = $orders;
            return view('themes.themeone.views.ordershow', compact('result'));
        }
        else{
            return redirect()->route('login');
        }

    }

    public function orderDetail(Request $request){

        $orders = Orders::with([
            'hasManyPlaceOrder' => function($q){
                return $q->with('hasManyProductImg');
            }
        ],'hasOneCity')
        ->where('User_ID',session()->get('userId'))
        ->where('Order_ID',$request->id)->get()->first();
       
        $result['orders'] = $orders;
        return view('themes.themeone.views.orderdetails', compact('result'));

    }


     public function bookList(){
        if(Session::has('userId')){
            $book = DB::table('car')->join('contact_agent','contact_agent.carId','=','car.id')->where('car.pro_type','2')->where('contact_agent.userId',session()->get('userId'))->groupBy('contact_agent.id')->paginate(10);
            // $carBrand = CarBrand::where('status',1)->get();
            // $carBrand = CarModel::where('published',1)->get();
           
            $result['book'] = $book;
            return view('themes.themeone.views.bookshow', compact('result'));
        }
        else{
            return redirect()->route('login');
        }

    }

    public function bookDetail($id){

        
        $id = base64_decode($id);

   
        $detail = DB::table('car')->join('contact_agent','contact_agent.carId','=','car.id')->where('contact_agent.id',$id)->first();
        $image = Car_img::where('car_id',$detail->carId)->first();

        $licence = DB::table('driverLicense')->where('c_agentId',$detail->id)->get();
        $uploadid = DB::table('upload_id')->where('c_agentId',$detail->id)->get();

        return view('themes.themeone.views.bookdetails', compact('detail','image','licence','uploadid'));

    }

    
}