<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        //Empty Session Cart
        session()->put('cart', []);

        //Send email to customer
        Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailCustomer($order));
        //Send email to admin
        Mail::to('nguyenlyhuuphucwork@gmail.com')->send(new OrderEmailAdmin($order));
        //Minus qty in system

        return redirect()->route('home')->with('message', 'Dat hang thanh cong');
    }
    
    private function getTotalPrice():float {
        $totalPrice = 0;

        $cart = session()->get('cart', []);

        foreach($cart as $item){
            $totalPrice += $item['price'] * $item['qty'];
        }

        return $totalPrice;
    }
}
