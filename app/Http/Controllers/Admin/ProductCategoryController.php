<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function create(){
        return view('admin.pages.product_category.create');
    }

    public function store(ProductCategoryStoreRequest $request){
        $result = DB::table('product_category')->insert([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
        ]);

        $message = $result ? 'Tao danh muc thanh cong' : 'tao danh muc that bai';

        return redirect()->route('admin.product_category.index')->with('message', $message);
    }

    public function index(Request $request){
        // $key = $request->key ?? null;
        // $sortBy = $request->sortBy ?? 'latest';
        // //SELECT * FROM `product_category` WHERE name like '%DVM%' OR slug like '%DVM%';
        // //SELECT * FROM product_category ORDER BY created_at DESC;

        // //Eloquent 
        // if(is_null($key)){
        //     $datas = ProductCategory::withTrashed();
        // }else{
        //     $datas = ProductCategory::withTrashed()
        //     ->where('name', 'like' ,"%$key%")
        //     ->orWhere('slug', 'like' ,"%$key%");
        // }

        // $datas->orderBy('created_at', $sortBy === 'latest' ? 'desc' : 'asc');

        // $datas = $datas->paginate(config('myconfig.my_item_per_page'));
        
        $datas = ProductCategory::withTrashed()->get();

        return view('admin.pages.product_category.index', ['datas' => $datas]);
    }
    
    public function makeSlug(Request $request){
        $dataSlug = $request->slug;
        $slug = Str::slug($dataSlug);
        return response()->json(['slug' => $slug]);
    }

    public function destroy(Request $request, ProductCategory $productCategory){
        $result = $productCategory->delete();
        //Flash message
        $message = $result ? 'Xoa danh muc thanh cong' : 'Xoa danh muc that bai';
        return redirect()->route('admin.product_category.index')->with('message', $message);
    }

    public function restore(Request $request, int $id){
        $id = $request->id;
        //Eloquent
        ProductCategory::withTrashed()->find($id)->restore();

        return redirect()->route('admin.product_category.index')->with('message', 'Khoi phuc thanh cong');
    }

    public function detail(Request $request, ProductCategory $productCategory){
        return view('admin.pages.product_category.detail', ['data' => $productCategory]);
    }

    public function update(ProductCategoryUpdateRequest $request, int $id){
        //Eloquent Update
        $productCategory = ProductCategory::find($id);

        //mass assignment
        $result = $productCategory->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
        ]);
        
        //Query Builder        
        // $result = DB::table('product_category')->where('id', $id)
        // ->update([
        //     'name' => $request->name,
        //     'slug' => $request->slug,
        //     'status' => $request->status
        // ]);

        $message = $result ? 'Cap nhat danh muc thanh cong' : 'Cap nhat danh muc that bai';

        return redirect()->route('admin.product_category.index')->with('message', $message);
    }
}

