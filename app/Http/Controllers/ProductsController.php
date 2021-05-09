<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    public function getProducts(Request $request){
        if($request->page == "all"){
            $data = DB::table('products')->get();
        }else{
            $data = DB::table('products')->paginate(10);
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

    public function getProductById(Request $request,$id){
    	$data = DB::table('products')->where('id',$id)->first();
        $dataWishlist = DB::table('wishlist')->where('product_id',$data->id)->first();
        if($dataWishlist){
            $data->wishlist = true;
        }else{
            $data->wishlist = false;
        }
    	return response()->json([
            "data"=>$data
        ], 200);
    }

    public function createProduct(Request $request){
        $insertData  = array(
                                "name"=>$request->name,
                                "description"=>$request->description,
                                "price"=>$request->price,
                                "category_id"=>$request->category_id,
                                "image"=>json_encode($request->image),
                                "video"=>$request->video,
                                "color"=>json_encode($request->color),
                                "size"=>json_encode($request->size) 
                            );
    	$data = DB::table('products')->insert($insertData);
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $insertData;
            $result->message = "Product ".$request->name." created successfully";
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

    public function updateProduct(Request $request,$id){
        $updateData  = array(
                                "name"=>$request->name,
                                "description"=>$request->description,
                                "price"=>$request->price,
                                "category_id"=>$request->category_id,
                                "image"=>json_encode($request->image),
                                "video"=>$request->video,
                                "color"=>json_encode($request->color),
                                "size"=>json_encode($request->size) 
                            );
    	$data = DB::table('products')->where('id',$id)->update($updateData);
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $updateData;
            $result->message = "Product ".$request->name." created successfully";
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

    public function deleteProduct(Request $request,$id){
    	$data = DB::table('products')->where('id',$id)->delete();
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $request->id;
    		$result->message = "Product deleted successfully";
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
