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
        /**
        * @OA\Post(
        *      path="/api/auth/login",
        *      operationId="userLogin",
        *      tags={"User"},
        *      summary="Login to your account",
        *      description="Returns a token",
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Successful operation",
        *          @OA\JsonContent(ref="#/components/schemas/User")
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Bad Request"
        *      ),
        * )
        */
        public function login(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        /**
        * @OA\Post(
        *      path="/api/auth/register",
        *      operationId="registerUser",
        *      tags={"User"},
        *      summary="Register a new user",
        *      description="Returns user information and token",
        *      @OA\RequestBody(
        *          required=true,
        *          @OA\JsonContent(ref="#/components/schemas/RegisterUserRequest")
        *      ),
        *      @OA\Response(
        *          response=201,
        *          description="Successful operation",
        *          @OA\JsonContent(ref="#/components/schemas/User")
        *       ),
        *      @OA\Response(
        *          response=400,
        *          description="Bad Request"
        *      ),
        * )
        */
        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

       /**
        * @OA\Get(
        *      path="/api/auth/profile",
        *      operationId="getUserInfo",
        *      tags={"User"},
        *      summary="Get the information of logged in user",
        *      description="Returns object of user information",
        *       security={
        *           {"bearerAuth": {}}
        *       },
        *      @OA\Response(
        *          response=200,
        *          description="Successful operation",
        *          @OA\JsonContent(ref="#/components/schemas/User")
        *       ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      )
        *     )
        */
        public function userProfile(Request $request)
            {
                $user_profile = $request->instance()->query('user');
                return response($user_profile);
            }
}
