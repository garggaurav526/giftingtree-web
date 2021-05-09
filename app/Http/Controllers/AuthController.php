<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use DB;

class AuthController extends Controller
{
    
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
 
        $credentials = request(['email', 'password']);
    	$result = new \stdClass();
 
        if(!Auth::attempt($credentials)){
        	$result->success = false;
	        $result->message = 'Invalid email or password';
            return response()->json([
                'data'=> $result
            ], 400);
        }
        $user = $request->user();
        // $token = $user->createToken('Access Token');
        $token = "aasds";
        $user->access_token = $user->api_token;
        $user->uuid = $user->id;
        $result->success = true;
        $result->data = $user;
        $result->message = "Login successfull";
        return response()->json([
            "data"=> $result
        ], 200);
    }
 
    public function signup(Request $request){
 
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|confirmed'
        // ]);


        try {
	        $user = new User([
	            'name'=>$request->name,
	            'email'=>$request->email,
	            'phone'=>$request->phone,
	            'image'=>@$request->image,
	            'password' => Hash::make($request->password),
	            'api_token' => Str::random(60),
	        ]);
	 
	        if($user->save()){
	        	return response()->json([
	            	"success" => "User registered successfully",
	            	"api_token" => $user->api_token
	        	], 200);

	        }else{
	        	return response()->json([
	            	"error" => "User already exists"
	        	], 400);
	        }
	    }

        catch(Exception $e) {
        	return response()->json([
	            	"error" => $e->getMessage()
	        	], 400);
		}
        
    }

    public function updateProfile(Request $request){
        $data = DB::table('users')->where('id',Auth::user()->id)->update([
                                            "name"=>$request->name,
                                            "email"=>$request->email,
                                            "image"=> $request->image,
                                            "phone"=>@$request->phone,
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "User details of ".$request->name." updated successfully";
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

    public function getUser(Request $request){
        $data = Auth::user();
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $data;
            $result->message = "User data";
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

    public function updatePassword(Request $request){
        $data = DB::table('users')->where('id',Auth::user()->id)->update([
                                                'password' => Hash::make($request->password),
                                                'api_token' => Str::random(60)
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "Password updated successfully";
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

    public function updateUser(Request $request){
        $data = DB::table('users')->where('id',Auth::user()->id)->update([
                                                'name' => $request->name,
                                                'email' => $request->email,
                                                'phone' => $request->phone,
                                                'image' => $request->image
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "Password updated successfully";
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

    public function requestChangePassword(Request $request){
        $data = DB::table('users')->where('email',$request->email)->first();
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "User found";
            return response()->json([
                "data"=> $result
            ], 200);
        }else{
            $result->success = false;
            $result->message = "User not found !!!";
            return response()->json([
                "data"=>$result
            ], 400);
        }
    }


    public function changePassword(Request $request){
        $data = DB::table('users')->where('email',$request->email)->update([
                                                'password' => Hash::make($request->password),
                                                'api_token' => Str::random(60)
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "Password changed successfully";
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

    public function changeUserPassword(Request $request){
        $data = DB::table('users')->where('id',$request->user_id)->update([
                                                'password' => Hash::make($request->password),
                                                'api_token' => Str::random(60)
                                            ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "Password changed successfully";
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

    public function updateUserProfile(Request $request){
        $data = DB::table('users')->where('id',$request->user_id)->update([
                                            "name"=>$request->name,
                                            "email"=>$request->email,
                                            "role"=>$request->role,
                                            "image"=> $request->image,
                                            "phone"=>@$request->phone,
                                        ]);
        $result = new \stdClass();
        if($data){
            $result->success = true;
            $result->data = $request->name;
            $result->message = "User details of ".$request->name." updated successfully";
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
 
    public function logout(Request $request){
        $request->user()->token()->revoke(); 
        return response()->json([
            "success"=>"User logged out successfully"
        ], 200);
    }
 
    public function index(){
        echo "Hello World";
    }
 
}