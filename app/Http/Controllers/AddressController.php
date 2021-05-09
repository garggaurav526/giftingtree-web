<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class AddressController extends Controller
{
    public function getAddress(Request $request){
        if($request->page == "all"){
            $data = DB::table('address')->get();
        }else{
            $data = DB::table('address')->paginate(10);
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

    public function getUserAddress(Request $request){
        $user_id = Auth::user()->id;
        if($request->page == "all"){
            $data = DB::table('address')->where('user_id',$user_id)->get();
        }else{
            $data = DB::table('address')->where('user_id',$user_id)->paginate(10);
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

    public function getAddressById(Request $request,$id){
    	$data = DB::table('address')->where('id',$id)->first();
    	return response()->json([
            "data"=>$data
        ], 200);
    }

    public function createAddress(Request $request){
        if($request->user_id){
            $insertData = [
                            "user_id"=>$request->user_id,
                            "street_address"=>$request->street_address,
                            "landmark"=>$request->landmark,
                            "city"=>$request->city,
                            "state"=>$request->state,
                            "country"=>$request->country,
                            "pincode"=>$request->pincode,
                            ]
    	    $data = DB::table('address')->insert($insertData);
        	$result = new \stdClass();
        	if($data){
        		$result->success = true;
        		$result->data = $insertData;
        		$result->message = "Address created successfully";
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
        }else{
            $result = new \stdClass();
            $result->success = false;
            $result->message = "User id can not be empty !!!";
            return response()->json([
                "data"=> $result
            ], 400);
        }
    }

    public function updateAddress(Request $request,$id){
        $updateData = [
                            "user_id"=>$request->user_id,
                            "street_address"=>$request->street_address,
                            "landmark"=>$request->landmark,
                            "city"=>$request->city,
                            "state"=>$request->state,
                            "country"=>$request->country,
                            "pincode"=>$request->pincode,
                            ]
    	$data = DB::table('address')->where('id',$id)->update($updateData);
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $updateData;
    		$result->message = "Address ".$request->name." updated successfully";
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

    public function deleteAddress(Request $request,$id){
    	$data = DB::table('address')->where('id',$id)->delete();
    	$result = new \stdClass();
    	if($data){
    		$result->success = true;
    		$result->data = $request->id;
    		$result->message = "Address deleted successfully";
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
