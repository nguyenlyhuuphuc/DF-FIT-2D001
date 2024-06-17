<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //SELECT p.*, pc.name as product_category_name 
        // FROM product p 
        // JOIN product_category pc 
        // ON p.product_category_id = pc.id LIMIT 0,5;

        //Query Builder
        // $datas = DB::table('product')->join('product_category', 
        // 'product.product_category_id',
        // '=',
        // 'product_category.id')
        // ->select('product.*')
        // ->selectRaw('product_category.name as product_category_name')
        // ->paginate(config('myconfig.my_item_per_page'));



        // dd($datas);
        $datas = Product::with('productCategory')->paginate(config('myconfig.my_item_per_page'));
        return view('admin.pages.product.index', ['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        return view('admin.pages.product.create', ['productCategories' => $productCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        //Eloquent - Mass assignment - Model 
        // $product = Product::create([
        //     'name' => $request->name,
        //     'slug' => $request->slug,
        //     'price' => $request->price,
        //     'qty' => $request->qty,
        //     'description' => $request->description,
        //     'status' => $request->status,
        //     'product_category_id' => $request->product_category_id,
        // ]);

        // if($request->hasFile('image_url')){
        //     $file = $request->file('image_url');
        //     $originName = $file->getClientOriginalName();

        //     $fileName = pathinfo($originName, PATHINFO_FILENAME);
        //     $extension = $file->getClientOriginalExtension();
        //     $fileName = $fileName . '_' . uniqid() . '.' . $extension;

        //     //move_uploaded_file()
        //     $file->move(public_path('images'), $fileName);
        // }

        // //Update column
        // $product->image_url = $fileName;
        // $product->save(); //update

        $product = new Product;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->product_category_id = $request->product_category_id;

        if($request->hasFile('image_url')){
            $file = $request->file('image_url');
            $originName = $file->getClientOriginalName();

            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $fileName . '_' . uniqid() . '.' . $extension;

            //move_uploaded_file()
            $file->move(public_path('images'), $fileName);
        }

        $product->image_url = $fileName;
        $product->save(); // insert

        $message = $product ? 'Tao san pham thanh cong' : 'Tao san pham that bai';

        return redirect()->route('admin.product.index')->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('show');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
