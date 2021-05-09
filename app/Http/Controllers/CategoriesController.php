<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CategoriesController extends Controller
{
    public function getCategories(Request $request){
    	if($request->page == "all"){
    		$data = DB::table('categories')->where('is_parent',0)->get();
    	}else{
    		$data = DB::table('categories')->where('is_parent',0)->paginate(10);
    	}
    	if(!$data){$data = [];}
    	$result = new \stdClass();
    	$result->success = true;
    	$result->data = $data;
    	$result->message = "";

    	return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getCategoriesAll(Request $request){
        if($request->page == "all"){
            $data = DB::table('categories')->get();
        }else{
            $data = DB::table('categories')->paginate(10);
        }
        if(!$data){$data = [];}
        $result = new \stdClass();
        $result->success = true;
        $result->data = $data;
        $result->message = "";

        return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getCategoriesSubAll(Request $request){
        if($request->page == "all"){
            $data = DB::table('categories')->where('is_parent',0)->get();
        }else{
            $data = DB::table('categories')->where('is_parent',0)->paginate(5);
        }

        foreach($data as $key => $value){
            $value->sub_categories = DB::table('categories')->where('is_parent',$value->id)->get();
        }

        if(!$data){$data = [];}
        $result = new \stdClass();
        $result->success = true;
        $result->data = $data;
        $result->message = "";

        return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getSubCategories(Request $request){
    	if($request->page == "all"){
    		$data = DB::table('categories')->where('is_parent',$request->category_id)->get();
    	}else{
    		$data = DB::table('categories')->where('is_parent',$request->category_id)->paginate(10);
    	}
    	if(!$data){$data = [];}
    	$result = new \stdClass();
    	$result->success = true;
    	$result->data = $data;
    	$result->message = "";

    	return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getCategoryItem(Request $request){
    	if($request->page == "all"){
    		$data = DB::table('products')->where('category_id',$request->category_id)->get();
    	}else{
    		$data = DB::table('products')->where('category_id',$request->category_id)->paginate(10);
    	}
        foreach($data as $key => $value){
            $dataWishlist = DB::table('wishlist')->where('product_id',$value->id)->first();
            if($dataWishlist){
                $value->wishlist = true;
            }else{
                $value->wishlist = false;
            }
        }
    	if(!$data){$data = [];}
    	$result = new \stdClass();
    	$result->success = true;
    	$result->data = $data;
    	$result->message = "";

    	return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getCategoriesById(Request $request,$id){
    	$data = DB::table('categories')->where('id',$id)->first();
    	return response()->json([
            "data"=>$data
        ], 200);
    }

    public function createCategory(Request $request){
    	$data = DB::table('categories')->insert([
    										"name"=>$request->name,
    										"image"=>is_array(@$request->image) ? json_encode(@$request->image) : @$request->image,
    										"description"=>@$request->description,
    										"is_parent"=>$request->is_parent ? $request->is_parent : 0
    										]);
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $request->name;
    		$result->message = "Category ".$request->name." created successfully";
	    	return response()->json([
	            "data"=> $result
	        ], 200);
    	}else{
    		$result->success = false;
    		$result->message = "Something went wrong !!!";
    		return response()->json([
	            "data"=> $result
	        ], 400);
    	}
    }

    public function updateCategory(Request $request,$id){
    	$data = DB::table('categories')->where('id',$id)->update([
                                            "name"=>$request->name,
                                            "image"=>is_array(@$request->image) ? json_encode(@$request->image) : @$request->image,
                                            "description"=>@$request->description,
                                            "is_parent"=>$request->is_parent ? $request->is_parent : 0
                                            ]);
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $request->name;
    		$result->message = "Category ".$request->name." updated successfully";
	    	return response()->json([
	            "data"=> $result
	        ], 200);
    	}else{
    		$result->success = false;
    		$result->message = "Something went wrong !!!";
    		return response()->json([
	            "data"=>$result
	        ], 400);
    	}
    }

    public function deleteCategory(Request $request,$id){
    	$data = DB::table('categories')->where('id',$id)->delete();
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $request->id;
    		$result->message = "Category deleted successfully";
	    	return response()->json([
	            "data"=> $result
	        ], 200);
    	}else{
    		$result->success = false;
    		$result->message = "Something went wrong, please try again";
    		return response()->json([
	            "data"=> $result
	        ], 400);
    	}
    }


}
