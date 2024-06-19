<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

        //Save in Session
        session()->put('cart', $cart);

        return response()->json(['message' => 'Them vao gio hang thanh cong']);
    }

    public function destroy(){
        session()->put('cart', []);

        return response()->json(['message' => 'Xoa gio hang thanh cong']);
    }
}
