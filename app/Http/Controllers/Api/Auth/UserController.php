<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->only('name', 'email', 'password');
            $user['password'] = Hash::make($user['password']);
            User::create($user);


            $emailVerify = EmailVerify::updateOrCreate(
                ['email' => $user['email']],
                [
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







    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
