<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class CommonController extends Controller
{
    public function getWishlist(Request $request){
        if($request->page == "all"){
            $data = DB::table('wishlist')->where('user_id',Auth::user()->id)->get();
        }else{
            $data = DB::table('wishlist')->where('user_id',Auth::user()->id)->paginate(10);
        }
        foreach($data as $key => $value){
            $value->product = DB::table('products')->where('id',$value->product_id)->first();
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

    public function getWishlistById(Request $request,$id){
        $data = DB::table('wishlist')->where('id',$id)->first();
        $data->product = DB::table('products')->where('id',$data->product_id)->first();
        return response()->json([
            "data"=>$data
        ], 200);
    }

    public function createWishlist(Request $request){
        $data = DB::table('wishlist')->insert([
                                            "user_id"=>Auth::user()->id,
                                            "product_id"=>$request->product_id
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->product_id;
            $result->message = "Item added successfully";
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

    public function deleteWishlist(Request $request,$id){
        $data = DB::table('wishlist')->where('product_id',$id)->where('user_id',Auth::user()->id)->delete();
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->id;
            $result->message = "Item deleted successfully";
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

    public function getAllRatings(Request $request){
        if($request->page == "all"){
            $data = DB::table('user_ratings')->get();
        }else{
            $data = DB::table('user_ratings')->paginate(10);
        }
        foreach($data as $key => $value){
            $value->product = DB::table('products')->where('id',$value->product_id)->first();
            $value->user = DB::table('users')->where('id',$value->user_id)->first();
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

    public function getDistincRating(Request $request){
        $data = new \stdClass();
        $data->reviews = DB::table('user_ratings')->select('product_id')->where('product_id',$request->product_id)->count();
        $data->sum = DB::table('user_ratings')->where('product_id',$request->product_id)->sum('rating');
        $data->one = DB::table('user_ratings')->where('product_id',$request->product_id)->where('rating',1)->count();
        $data->two = DB::table('user_ratings')->where('product_id',$request->product_id)->where('rating',2)->count();
        $data->three = DB::table('user_ratings')->where('product_id',$request->product_id)->where('rating',3)->count();
        $data->four = DB::table('user_ratings')->where('product_id',$request->product_id)->where('rating',4)->count();
        $data->five = DB::table('user_ratings')->where('product_id',$request->product_id)->where('rating',5)->count();
        if(!$data){$data = [];}
        $result = new \stdClass();
        $result->success = true;
        $result->data = $data;
        $result->message = "";

        return response()->json([
            "data"=>$result
        ], 200);
    }

    public function getRatings(Request $request){
        if($request->page == "all"){
            $data = DB::table('user_ratings')->where('product_id',$request->product_id)->get();
        }else{
            $data = DB::table('user_ratings')->where('product_id',$request->product_id)->paginate(10);
        }
        foreach($data as $key => $value){
            $value->product = DB::table('products')->where('id',$value->product_id)->first();
            $value->user = DB::table('users')->where('id',$value->user_id)->first();
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

    public function getRatingById(Request $request,$id){
        $data = DB::table('user_ratings')->where('id',$id)->first();
        $data->product = DB::table('products')->where('id',$data->product_id)->first();
        $data->user = DB::table('users')->where('id',$data->user_id)->first();
        return response()->json([
            "data"=>$data
        ], 200);
    }

    public function createRating(Request $request){
        $data = DB::table('user_ratings')->insert([
                                            "user_id"=>Auth::user()->id,
                                            "product_id"=>$request->product_id
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->product_id;
            $result->message = "Item added successfully";
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

    public function deleteRating(Request $request,$id){
        $data = DB::table('user_ratings')->where('id',$id)->delete();
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->id;
            $result->message = "Item deleted successfully";
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
