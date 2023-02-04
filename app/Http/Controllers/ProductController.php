<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Categories;

class ProductController extends Controller
{
    public function index()
    {
        $typeCategory = Categories::all();
        return view('page.product.index',compact('typeCategory'));
    }

    public function store(Request $request)
    {
        $tableName = new Product();
        $tableName->id = $request->id;
        $tableName->name = $request->name;
        $tableName->priceP = $request->priceP;
        $tableName->priceS = $request->priceS;
        $tableName->category_id = $request->category_id;
        $tableName->qty = $request->qty;
        $tableName->save();

        return redirect()->route('product.index')->with('success', "บันทึกข้อมูลเรียบร้อย");

    }


}
