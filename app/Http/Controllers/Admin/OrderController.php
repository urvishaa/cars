<?php 

namespace App\Http\Controllers\Admin;

use App\Orders;
use App\PlaceOrder;
use App\CarAccessories;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
// use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Hash;
use DB;
use Lang;
use PHPMailer;
// echo phpinfo(); exit;
class OrderController extends Controller
{
    public function orderList(){
        $orders = Orders::paginate(10);
        
        return view('admin.order.showorder', compact('orders'));
    }

    public function allposts()
    {
      $request = Request::instance();
      
        $columns = array( 
                            0 =>'order_id', 
                            1 =>'name',
                            2 =>'status', 
                            3 =>'total',
                            4=>'date',
                            
                        );
  
        $totalData = DB::table('orders')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(!empty($request->input('search.value')))
        {            
            $search = $request->input('search.value'); 

            $posts =  DB::table('orders')->Where('Order_ID', 'LIKE',"%{$search}%")
                            ->orWhere('Name', 'LIKE',"%{$search}%")
                            ->orWhere('Status', 'LIKE',"%{$search}%")
                            ->orWhere('TotalCount', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = DB::table('orders')->where('Order_ID','LIKE',"%{$search}%")
                            ->orWhere('Name', 'LIKE',"%{$search}%")
                            ->orWhere('Status', 'LIKE',"%{$search}%")
                            ->orWhere('TotalCount', 'LIKE',"%{$search}%")
                             ->count();
        }   
        else 
        {            
            $posts = DB::table('orders')->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['order_id'] = $post->Order_ID;
                $nestedData['name'] = $post->Name;
                $nestedData['status'] = $post->Status;
                $nestedData['total'] = $post->TotalCount;
                $nestedData['date'] = $post->datetime;
                $detailUrl = route('admin.orderdetail',['id'=>$post->Order_ID]);
                $nestedData['options'] = "&emsp;<a href=".$detailUrl." class='btn btn-primary'>Detail</a>";
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

    public function orderDetail($id){
        $orders = Orders::with([
            'hasManyPlaceOrder'=>function($q){
                return $q->with('hasOneProduct','hasManyProductImg');
        }])->where('Order_Id',$id)->get()->first();
        
        $result['orders'] = $orders;
        // echo "<pre>";print_r($result);exit;
        return view('admin.order.orderdetails', compact('result'));
    }
    public function statusEdit($id){
        $request = Request::instance();

        $order = Orders::with('hasOneUser')->where('Order_ID',$id)->get()->first();
        
        $order->Status = $request->input('status');
        // echo $request->input('status');
        
        $order->save();
        // if($request->input('status') == 'Rejected'){
        //     $userObj = $order->hasOneUser ? $order->hasOneUser : '';
        //     $name = $userObj ? $userObj->name." " : '';
        //     $name .= $userObj ? $userObj->lname : '';
        //     // $to = $userObj ? $userObj->email : 'harmistest@gmail.com';
        //     $subject = 'Order Rejected';
        //     $message = 'Hello '.$name.', your order is rejected';

        //     $to = 'dalvadisandip123@gmail.com';

                // $storeemail = "harmistest@gmail.com";
                // $headers  = 'MIME-Version: 1.0' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                // $headers .= 'From: '.$storeemail. "\r\n" .
                //     'Reply-To: ' .$storeemail. "\r\n" .
                //     'MIME-Version: 1.0' . "\r\n".
                // 'X-Mailer: PHP/' . phpversion();

                
                
                // mail send code new harmis
                // require_once('mailer.php');
           
        //         $mail = new PHPMailer(true); 
            
        //         $mail->IsSMTP(); 
                
        //        // $to = "harmistest@gmail.com";
                            
        //         $mail->Host       = "ssl://smtp.mail.ru"; // SMTP server
        //         $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
        //         $mail->SMTPAuth   = true;                  // enable SMTP authentication
        //         $mail->Host       = "ssl://smtp.mail.ru"; // sets the SMTP server
        //         $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
        //         $mail->Username   = "bespalov-89@mail.ru"; // SMTP account username
        //         $mail->Password   = "777kireevbes210989";        // SMTP account password
        //         //$headers = array ('From' => 'bespalov-89@mail.ru', 'To' => $to, 'Subject' => $subject, 'Reply-To' => $to , 'MIME-Version' => '1.0', 'Content-Type' => "text/html; charset=ISO-8859-1");
        //         $mail->CharSet = 'UTF-8';
        //         $mail->Encoding = 'quoted-printable';
        //         $mail->AddReplyTo($to, 'posudacity161.ru Посуда оптом и в розницу');
        //         $mail->AddAddress($to, 'posudacity161.ru Посуда оптом и в розницу');
        //         $mail->SetFrom('bespalov-89@mail.ru', 'posudacity161.ru Посуда оптом и в розницу');
        //         $mail->AddReplyTo($to, 'posudacity161.ru Посуда оптом и в розницу');
        //         $mail->Subject = html_entity_decode($subject);
        //         $message=  html_entity_decode($message);
        //         $mail->MsgHTML($message);
            
        //         $mail->Send();

        //         exit;
        // }

    }

    public function storeOrderList(){
        $admin = auth()->guard('admin')->user(); 
        $id = $admin->myid;

        $orders = DB::table('car_accessories')
        ->leftJoin('Place_Order','Place_Order.Product_ID','=', 'car_accessories.id')
        ->leftJoin('orders','orders.Order_ID','=', 'Place_Order.Order_ID')
        ->select('car_accessories.*', 'Place_Order.*', 'orders.*')
        ->where('car_accessories.store_id',$id)
        ->groupby('orders.Order_ID')
        ->paginate(10);
        
        return view('admin.store_order.list', compact('orders'));        
        
    }
    public function storeOrderDetail($id){
        $admin = auth()->guard('admin')->user(); 
        $storeId = $admin->myid;
        $orders = DB::table('car_accessories')
        ->leftJoin('Place_Order','Place_Order.Product_ID','=', 'car_accessories.id')
        ->leftJoin('orders','orders.Order_ID','=', 'Place_Order.Order_ID')
        ->leftJoin('city','city.id','=', 'orders.city')
        ->select('car_accessories.*', 'Place_Order.*', 'orders.*','city.name as city_name')
        ->where('orders.Order_ID',$id)
        ->where('car_accessories.store_id',$storeId)
        ->get();
        // echo "<pre>";print_r($orders);exit;
        return view('admin.store_order.orderdetails', compact('orders'));
    }
}