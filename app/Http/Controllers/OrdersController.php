<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{
    public function getOrders(Request $request){
    	$data = DB::table('orders')->paginate(10);
        if(!$data){$data = [];}
        $result = new \stdClass();
        $result->success = true;
        $result->data = $data;
        $result->message = "";
    	return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getOrderById(Request $request,$id){
    	$data = DB::table('orders')->where('id',$id)->first();
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
                                "image"=>$request->image,
                                "video"=>$request->video 
                            );
    	$data = DB::table('orders')->insert($insertData);
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
                                "image"=>$request->image,
                                "video"=>$request->video 
                            );
    	$data = DB::table('orders')->where('id',$id)->update($updateData);
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

    public function deleteOrder(Request $request,$id){
    	$data = DB::table('orders')->where('id',$id)->delete();
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
