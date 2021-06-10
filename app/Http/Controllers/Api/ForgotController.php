<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request){

        $email = $request->input('email');
        if (User::where('email',$email)->doesntExist()){
            return response([
               'message' => 'User doesnt exists !'
            ] , 404);
        }
        $token = Str::random(10);
        dd($token);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            //send email
            return response([
                'message'=> 'Check your email !'
            ]);

        }catch (\Exception $exception){
            return response([
                'message'=>$exception->getMessage(),
                400
            ]);
        }
    }

    public function reset(ResetRequest $request){

        $token = $request->input('token');
    if (!$passwordResets = DB::table('password_resets')->where('token',$token)->first()){
        return response([
            'massage'=>'Invalid token!'
        ], 400);
    }
    if($user = User::where('email',$passwordResets->email)->first()){
        return response([
            'message'=>'User doesnt exist!'
        ],404);
    }
    $user->password = Hash::make($request->input('password'));
    $user->save();

    return response([
       'message'=>'success'
    ]);

    }

}
