<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use App\Models\User;

class AuthController extends Controller 
{

    public function _construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }


    public function register(Request $request){
        $validator =  Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|string|confirmed|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        return response()->json([
            'message'=>'User successfully created',
            'user'=>$user
        ],200);
    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }else{
        $email = $request['email'];
        $password = $request['password'];


        $user = User::where('email', '=', $email)->first();   
        if(Hash::check($password, $user->password)) {
            
            
            $token=auth()->attempt($validator->validated());
            return response()->json(['message'=>'password is correct','token'=>$this->createNewToken($token)],200);

         } else {
            return response()->json(['message'=>'Please check your credentials'],400);
        }
        }
    }

    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60,
            'user'=>auth()->user()
        ]);
    }

    public function profile(){
        $result =(auth()->user());
        if($result){
            return response()->json([$result],200);
        }else{
            return response()->json(['message'=>'Token not found, please login again'],400);
        }
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'message'=>'User logged out'
        ],201);
    }

}
