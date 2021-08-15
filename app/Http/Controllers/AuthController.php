<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
        public function login(Request $request)
        {
                $credentials = $request->only('email', 'password');

                try {
                        if (!$jwt_token = JWTAuth::attempt($credentials)) {
                                return response()->json(['error' => 'invalid_credentials'], 400);
                        }
                } catch (JWTException $e) {
                        return response()->json(['error' => 'could_not_create_token'], 500);
                }
               
                $token = 'Bearer '. $jwt_token;
                return response()->json(compact('token'));
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                        'name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6|confirmed',
                ]);

                if ($validator->fails()) {
                        return response()->json($validator->errors(), 400);
                }

                $user = User::create([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => Hash::make($request->get('password')),
                ]);

                $jwt_token = JWTAuth::fromUser($user);
                $token = 'Bearer '. $jwt_token;

                return response()->json(compact('user', 'token'), 201);
        }

        public function userProfile()
        {
                try {

                        if (!$user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                }
                catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                
                        return response()->json(['token_expired'], $e->getStatusCode());
                
                } 
                catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());
                
                } 
                catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());
                
                }

                return response()->json(compact('user'));
        }
}
