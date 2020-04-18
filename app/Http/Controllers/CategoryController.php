<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category; 

class CategoryController extends Controller
{
    //add category
    public function add_category(Request $request)
    {
    	$this->validate($request,array('category_name'=>'required|min:2|max:50'));
    	$category = new Category();
    	$category->category_name = $request->category_name;
    	$category->save();
    	return array('message'=>'OK');
    }

    public function all_category()
    {
    	$categories = Category::all();
    	return response()->json(array('categories' => $categories),200);
    }

    public function remove_category($id)
    {
    	$category = Category::find($id);
    	$category->delete();
    	return array('message'=>'OK');
    }

    public function update_category(Request $request)
    {
    	$this->validate($request,array('category_id'=>'required|min:1|max:11','category_name'=>'required|min:2|max:50'));
    	$category = Category::find($request->category_id);
    	$category->category_name = $request->category_name;
    	$category->save();
    	return array('message'=>'OK');
    }
}
