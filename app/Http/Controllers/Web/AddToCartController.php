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
use App\Admin;
use Session;
class AddToCartController extends Controller
{
	public function addNewCart(Request $request){
        $product = DB::table('car_accessories')
        ->join('car_accessories_img','car_accessories_img.product_id','=','car_accessories.id')
        ->select('car_accessories.*','car_accessories_img.img_name')
        ->where('car_accessories.id',$request->id)
        ->get()->first();

        $orderQuantity = 0;
        $orderProducts = DB::table('Place_Order')->where('Product_ID',$request->id)->get();
        foreach($orderProducts as $orderProduct){
            $orderQuantity = $orderQuantity + $orderProduct->Quantity;
        }
        $compareQuantity = $product->quantity - $orderQuantity;
        if($compareQuantity <= 0){
            return redirect()->route('showcart')->with('message', trans('labels.productQuantityNotAvailable'));
        }
        
        
        $getCarts=session()->get('cart');
        
        if(Session::has('cart')){
            foreach($getCarts as $index=>$cart){
                if($cart['id'] == $product->id){
                    $getCarts[$index]['quantity'] = $cart['quantity'];
                    session()->put('cart', $getCarts);
                    return redirect()->route('showcart')->with('message', trans('labels.alreadyAddedInCart'));
                }
            }
        }
        $request->session()->push('cart',
        ['id'=>$request->id,
        'name'=>$product->name,
        "description"=>$product->description,
        "price"=>$product->price,
        'size'=>$product->size,
        'model'=>$product->model,
        'color'=>$product->color,
        'specification'=>$product->specification,
        'img_name' =>$product->img_name,
        'quantity' =>1,
        ]);    
        $carts = $request->session()->get('cart');
        $grandTotal = 0;
        foreach($carts as $cart){
            $grandTotal = $grandTotal + $cart['price'];
        }
        $request->session()->put('grandTotal',$grandTotal);
        return redirect()->route('showcart')->with('message', trans('labels.cartAddedSuccessfully'));
        
    }

    public function updateCart(Request $request){

        $cart=session()->get('cart');        
        $productCarts = DB::table('Place_Order')->where('Product_ID',$cart[$request->id]['id'])->get();
        $product = DB::table('car_accessories')->find($cart[$request->id]['id']);
        $quantity = 0;
        foreach($productCarts as $productCart){
            $quantity = $quantity + $productCart->Quantity;
        }
        $compareQuantity = $product->quantity - $quantity;
        
        $res = array();
        if($compareQuantity >= 0 && $request->quantity < $compareQuantity){
            $cart[$request->id]['quantity'] = $request->quantity;
            $res['total'] = $cart[$request->id]['price'] * $request->quantity;
            $res['message'] = 'Your Cart Updated Successful.';
            $res['quantity'] = $request->quantity;
        }else{
            $cart[$request->id]['quantity'] = $compareQuantity;
            $res['message'] = 'Please Enter Quantity '.$compareQuantity.' Or In Range.';
            $res['quantity'] = $compareQuantity;
            $res['total'] = $cart[$request->id]['price'] * $compareQuantity;
        }
        
        session()->put('cart', $cart);
        $carts=session()->get('cart');
        $grandTotal = 0;
        foreach($carts as $index=>$cart){
            $total = $cart['quantity'] * $cart['price'];
            $grandTotal = $grandTotal + $total;
        }
        $res['grandTotal'] = $grandTotal;

        $request->session()->put('grandTotal',$grandTotal);

        return $res;
    }

    public function deleteCart(Request $request){
        $cart=session()->get('cart');
        $request->session()->forget('cart.'.$request->id);
        return redirect()->route('showcart')->with('message', trans('labels.cartDeletedSuccessfully'));

    }
}