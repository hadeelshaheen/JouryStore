<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
            's_phone' => 'required|string|min:7|max:10',
//            's_image' => 'nullable|image',
//            's_address' => 'nullable|string'
        ]);
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            's_phone' => $request->s_phone,
            //  's_image' => $request->s_image,
            //'s_address' => $request->s_address

        ]);

//        $user->save();
//        return response()->json([
//            'message' => 'Successfully created user!'
//        ], 201);

        return response()->json(
            [
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'Successfully created user!'
                ],
                'user'=>$user]);
        /***/
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required|string|unique:users',
//            'password' => 'required|string',
//            's_phone' => 'required|string|min:7|max:10',
////            's_image' => 'nullable|image',
////            's_address' => 'nullable|string'
//        ]);
//        $user = new User([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->password),
//            's_phone' => $request->s_phone,
//          //  's_image' => $request->s_image,
//            //'s_address' => $request->s_address
//
//        ]);
//
////        $user->save();
////        return response()->json([
////            'message' => 'Successfully created user!'
////        ], 201);
//
//        return response()->json(
//            [
//                'status'=>[
//                    'success'=>true,
//                    'code'=> 1,
//                    'message'=>'Successfully created user!'
//                ],
//                'user'=>$user]);
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'User Not Found'
            ], 422);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token')->accessToken;
      //  dd($tokenResult);
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'message'=>'success login',
            'data' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),

        ],200);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function userProfile(Request $request){
        return response()->json(
            [
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'User Profile'
                ],
                'user'=>$request->user()]);
    }


    public function updateProfile(Request $request,User $user){
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                's_phone' => 'nullable|string|min:10|max:14',
                's_image' => 'nullable|image',
                's_address' => 'nullable|string'
            ]);
//            dd($request->get('name'));
//            dd($request->paramStr('name'));
            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false',
                    'message' => $error,
                    'data' => []], 422);
            } else {

                $user = User::find(Auth::user()->id);
//                dd($user);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->s_phone = $request->s_phone;
                $user->s_address = $request->s_address;

                if ($request->hasFile('s_image') && $request->file('s_image')->isValid()) {
                    $user['s_image'] = $request->file('s_image')->store('/', 'public');
                    //dd('anything');
                }
                $user->save();

                return response()->json(
                    [
                        'status'=>[
                            'success'=>true,
                            'code'=> 1,
                            'message'=>'profile updated !'
                        ],
                        'user'=>$user]);
//
//                return response()->json(['status' => 'true',
//                    'message' => 'profile updated !',
//                    'user' => $user]);
      }
        }catch (\Exception $exception){
            return response()->json(
                [

                    'status'=>[
                        'success'=>false,
                        'code'=> 0,
                        'message'=>$exception->getMessage()
                    ],
                    'user'=>[]]);

//
//            return response()->json(['status' => 'false',
//                'message' => $exception->getMessage(),
//                'data' => []],500);
        }

        /******************/





    }





}
