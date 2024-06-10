<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function create(){
        return view('admin.pages.product_category.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required',
            'status' => 'required',
        ],[
            'name.required' => 'Ten buoc phai nhap!',
            'name.min' => 'Ten it nhat phai co 3 ky tu',
            'name.max' => 'Ten nhieu nhat phai chi co 255 ky tu', 
        ]);

        //Fresh data
        $result = DB::table('product_category')->insert([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
        ]);

        if($result){
            return redirect()->route('admin.product_category.index')->with('message', 'Tao danh muc thanh cong');
        }else{
            dd('that bai');
        }
    }

    public function index(Request $request){
        // totalRecord = 17 (select count(*) as total_records from product_category;)
        // itemPerPage =  5
        // totalPages =  floar(17 / 5) = 4
        // REQUEST USER page=2
        // LIMIT 0, 5 => page 1 => (1 - 1) * itemPerPage
        // LIMIT 5, 5 => page 2 => (2 - 1) * itemPerPage
        // LIMIT 10, 5 => page 3 => (3 - 1) * itemPerPage
        // LIMIT 15, 5  => page 4 =>  (4 - 1) * itemPerPage
        // $page = $request->page ?? 1;

        // $itemPerPage = config('myconfig.my_item_per_page');
        // $totalRecord = DB::table('product_category')->count();
        // $totalPage = (int)ceil($totalRecord / $itemPerPage);
        // $offset = ($page - 1) * $itemPerPage;

        //Query Builder
        // $datas = DB::table('product_category')->offset($offset)->limit($itemPerPage)->get();
        $datas = DB::table('product_category')->paginate(config('myconfig.my_item_per_page'));

        return view('admin.pages.product_category.index', ['datas' => $datas]);
    }
    
    public function makeSlug(Request $request){
        $dataSlug = $request->slug;
        $slug = Str::slug($dataSlug);
        return response()->json(['slug' => $slug]);
    }

    public function destroy(Request $request){
        $id = $request->id;

        //Query Builder
        // $result = DB::table('product_category')->where('id', $id)->delete();
        //Eloquent - ORM
        $result = ProductCategory::find($id)->delete();

        //Flash message
        $message = $result ? 'Xoa danh muc thanh cong' : 'Xoa danh muc that bai';
        return redirect()->route('admin.product_category.index')->with('message', $message);
    }
}

