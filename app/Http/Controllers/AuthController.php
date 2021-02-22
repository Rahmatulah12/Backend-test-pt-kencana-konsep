<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{

    private $user;

    public function __construct()
    {
      $this->user = new User();
    }

    public function registration(Request $request)
    {
      
      $data = [
            "username" => strtolower($request->username),
            "email" => strtolower($request->email),
            "password" => $request->password,
            "password_confirmation" => $request->password_confirmation,
      ];

      // validation with Validator
      $validator = Validator::make($data, [
            "username" => 'required|unique:users|max:30',
            'email' => 'required|email|unique:users|max:35',
            'password' => 'required|confirmed|string| min:8',
            'password_confirmation' => 'required|same:password'
      ]);

      // check validaton
      if($validator->fails())
      {
          return response()->json([
              'error' => true,
              'message' => $validator->errors(),
          ], 400);
      }

      // delete password confirmation
      unset($data['password_confirmation']);

      // insert data user
      $this->user->username = $data["username"];
      $this->user->email = $data["email"];
      $this->user->password = Hash::make($data['password']);
      $this->user->save();

      if(!$this->user){
            return response()->json([
                  "error" => true,
                  "message" => "Something went wrong."
            ], 500);
      }

      return response()->json([
            "message" => "User has been saved",
            "data" => $data
      ], 201);

    }

    public function login(Request $request)
    {

      $data = [
            "username" => strtolower($request->username),
            "password" => $request->password,
      ];

      $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
      ]);
      
      // check validation
      if($validator->fails())
      {
            return response()->json([
                  'error' => true,
                  'message' => $validator->errors()
            ], 401);
      }

      // fetch user base request username
      $user = $this->user->where('username', $data['username'])->first();

      // check username if not exist
      if(!$user){
            return response()->json([
                  'error' => true,
                  'message' => "User not found."
            ], 401);
      }

      // check password
      if(!Hash::check($request->password, $user->password)){
            return response()->json([
                  'error' => true,
                  'message' => "Password doesn't match."
            ], 401);
      }

      // Generate token
      $token = $user->createToken('users')->accessToken;
      $user->key = $token;
      $user->save();

      return response()->json([
            "message" => "Login success.",
            "token" => $token,
      ], 200);

    }

    public function logout(){
      $user = $this->user->where('username', Auth::user()->username)->first();
      $user->key = null;
      $user->save();
      $client_id = Auth::user()->token()->id;
      $revoke = DB::table('oauth_access_tokens')->where('client_id', $client_id)->update(['revoked' => true]);
      if (!$user && !$revoke) {
            return response()->json([
                  "error" => true,
                  "message" => "Something went wrong."
            ], 500);
      }
      return response()->json([
            "error" => false,
            "message" => "Logout successfuly."
      ], 200);

    }

}
