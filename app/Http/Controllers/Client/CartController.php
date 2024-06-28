<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use Exception;
use Faker\Calculator\Ean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Mockery\CountValidator\Exact;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart', []);
        // dd($cart);
        return view('client.pages.cart', ['cart' => $cart]);
    }

    public function add(Request $requset){
        $productId = $requset->productId;
        
        $product = Product::find($productId);

        $cart = session()->get('cart', []);
        $cart[$productId] = [
            'name' => $product->name,
            'qty' => isset($cart[$productId]) ? ($cart[$productId]['qty'] + 1) : 1,
            'price' => $product->price
        ];

        $totalProducts = count($cart);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalItem = $item['price'] * $item['qty'];
            $totalPrice += $totalItem;
        }

        //Save in Session
        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Them vao gio hang thanh cong',
            'totalProducts' => $totalProducts,
            'totalPrice' => number_format($totalPrice, 2)
        ]);
    }

    public function destroy(){
        session()->put('cart', []);

        return response()->json(['message' => 'Xoa gio hang thanh cong']);
    }

    public function deleteItem(string $productId){
       $cart = session()->get('cart', []);
       
        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }else{
            throw new Exception("Khong the xoa");
        }

       return response()->json(['message' => 'Xoa san pham thanh cong']);
    }

    public function addProductItem(string $productId, int $qty){
        $cart = session()->get('cart', []);

        if(array_key_exists($productId, $cart)){

            if($qty === 0){
                 unset($cart[$productId]);
            }else{
                $cart[$productId]['qty'] = $qty;
            }
            
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Cap nhat san pham thanh cong']);
    }

    public function checkout(){
        $user = Auth::user();
        $cart = session()->get('cart', []);

        return view('client.pages.checkout', ['user' => $user, 'cart' => $cart]);
    }

    public function placeOrder(Request $request){
        try{
            DB::beginTransaction();
            //Insert Order
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->status = Order::PENDING;
            $order->total = $this->getTotalPrice();
            $order->save(); //insert

            //Insert Order Item
            $cart = session()->get('cart', []);
            $i = 1;
            foreach($cart as $productId => $item){
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->qty = $item['qty'];
                $orderItem->name = $item['name'];
                $orderItem->image = null;
                $orderItem->price = $item['price'];
                $orderItem->save(); //insert
            }

            //Update phone cho User
            $user = Auth::user();
            $user->phone = $request->phone;
            $user->save(); //update

        
            if(in_array($request->payment_method, ['VNBANK' , 'INTCARD'])){
                //VNPAY
                $vnp_TxnRef = $order->id; //Mã giao dịch thanh toán tham chiếu của merchant
                $vnp_Amount = $order->total * 23500; // Số tiền thanh toán
                $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                $vnp_BankCode = $request->payment_method; //Mã phương thức thanh toán
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

                date_default_timezone_set('Asia/Ho_Chi_Minh');            
                $startTime = date("YmdHis");
                $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));          

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => config('myconfig.vnpay.TmnCode'),
                    "vnp_Amount" => $vnp_Amount * 100,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:". $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => config('myconfig.vnpay.Returnurl'),
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate"=> $expire,
                    "vnp_BankCode" => $vnp_BankCode
                );
                
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = config('myconfig.vnpay.Url') . "?" . $query;
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, config('myconfig.vnpay.HashSecret'));
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

                return redirect()->to($vnp_Url);
            }else{
                //COD
                $orderPayment = new OrderPayment();
                $orderPayment->total = $order->total;
                $orderPayment->payment_method = 'cod';
                $orderPayment->status = 'success';
                $orderPayment->reason = null;
                $orderPayment->order_id = $order->id;
                $orderPayment->save();

                //Empty Session Cart
                session()->put('cart', []);

                //public event
                event(new OrderSuccessEvent($order));
            }

            DB::commit();
            return redirect()->route('home')->with('message', 'Dat hang thanh cong');
        }catch(\Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    
    private function getTotalPrice():float {
        $totalPrice = 0;

        $cart = session()->get('cart', []);

        foreach($cart as $item){
            $totalPrice += $item['price'] * $item['qty'];
        }

        return $totalPrice;
    }

    public function vnpayCallBack(Request $request){
        $order = Order::find($request->vnp_TxnRef);

        $orderPayment = new OrderPayment();
        $orderPayment->total = $order->total;
        $orderPayment->payment_method = 'vnpay';
        $orderPayment->status = $request->vnp_ResponseCode === '00' ? 'success' : 'fail';
        $orderPayment->reason = OrderPayment::RESPONSE_CODE_VNPAY[$request->vnp_ResponseCode];
        $orderPayment->order_id = $order->id;

        $message = '';
        if($orderPayment->status === 'success'){
            event(new OrderSuccessEvent($order));    
            session()->put('cart', []);
            $message = 'Dat hang thanh cong';
        }else{
            $message = 'Dat hang that bai';
        }

        $orderPayment->save();

        return redirect()->route('home')->with('message', $message);
    }
}
