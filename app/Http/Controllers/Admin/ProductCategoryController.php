<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('admin.product_category.create')->with('message', 'Tao danh muc thanh cong');
        }else{
            dd('that bai');
        }
    }

    public function index(){
        // totalRecord = 17 (select count(*) as total_records from product_category;)
        // itemPerPage =  5
        // totalPages =  floar(17 / 5) = 4
        // REQUEST USER page=2
        // LIMIT 0, 5 => page 1 => (1 - 1) * itemPerPage
        // LIMIT 5, 5 => page 2 => (2 - 1) * itemPerPage
        // LIMIT 10, 5 => page 3 => (3 - 1) * itemPerPage
        // LIMIT 15, 5  => page 4 =>  (4 - 1) * itemPerPage

        $itemPerPage = 5;
        $totalRecord = DB::table('product_category')->count();
        $totalPage = (int)ceil($totalRecord / $itemPerPage);

        //Query Builder
        $datas = DB::table('product_category')->get();

        return view('admin.pages.product_category.index', ['datas' => $datas, 'totalPage' => $totalPage]);
    }
}

