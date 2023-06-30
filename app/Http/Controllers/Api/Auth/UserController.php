<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Models\EmailVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function register(RegisterUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->all();
            $user['password'] = Hash::make($user['password']);
            User::create($user);

            $emailVerify = EmailVerify::updateOrCreate(
                ['email' => $user['email'],
                'token' => Str::random(255), 
                'expired_at' => Carbon::now()->addMinutes(5)
                ]
            );
            Mail::to($user['email'])->send(
                new EmailVerificationMail(route('mail.verify', ['token' => $emailVerify->token]))
            );
            DB::commit();
            return response()->json([ 'success' => true ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**************************************************************************************/

    public function verifyEmail(Request $request)
    {
        $emailVerify = EmailVerify::where('token', $request->token)->first();
        if (!$emailVerify) {
            return response()->json([ 'message' => 'Invalid verification link' ]);
        }
        if (Carbon::now()->greaterThan($emailVerify->expired_at)) {
            return response()->json([ 'message' => 'Verification link expired' ]);
        }
        $user = User::where('email', $emailVerify->email)->first();
        $user->update(['email_verified_at' => Carbon::now()]);
        $emailVerify->delete();
        return response()->json([ 'message' => 'Your account has been verified' ]);
    }

    /**********************************************************************************************/
    
    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            if ($user->email_verified_at === null) {
                return response()->json(['message' => 'Email not verified'], 401);
            }
            $user ['token'] = $user->createtoken('A7med')->accessToken;
            return response()->json(['msg'=>'User login successfully' ,'user'=>$user  ], 200);
        }
        else{
            return response()->json(['email or password are wrong , please try again'],404 );
        }
    }
}
