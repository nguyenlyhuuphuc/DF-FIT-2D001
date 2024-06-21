<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

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
}
