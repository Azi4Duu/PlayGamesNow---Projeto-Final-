<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
        ];
        $credentials = $request->validate($rules, $messages);

        $user = User::where('email',$request->email)->first();

        if(!$user||!Hash::check($request->password, $user->password)){
            return back()->withErrors([
                'credentials' => 'Email or Password is incorrect',
            ])->onlyInput('email');
        }

        if(!$user->email_verified_at){
            return back()->withErrors([
                'credentials' => 'Please verify your email address before logging in',
            ])->onlyInput('email');
        }

        if(!$user->active){
            return back()->withErrors([
                'credentials' => 'Your account is not active'
            ])->onlyInput('email');
        }

        $code = random_int(100000, 999999);

        session([
            '2fa_user_id' => $user->id,
            '2fa_code' => $code,
            '2fa_expires_at' => now()->addMinutes(10),
            '2fa_remember' => $request->boolean('remember'),
        ]);

        Mail::raw("Your authentication code is: {$code}", function ($message) use ($user) {
            $message->to($user->email)->subject("Play Games Now - Authentication code");
        });

        return redirect()->route('2fa.show');
    }

    public function showRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
        $messages = [
            'name.required' => 'Name is required',
            'username.required' => 'Username is required',
            'username.unique' => 'Username is already taken',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'confirm_password.required' => 'Confirm Password is required',
            'confirm_password.same' => 'Confirm Password and Password does not match',
        ];
        $request->validate($rules, $messages);
        if($user=User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'active' => false
        ])){
            $user->assignRole('customer');
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice');
        }
        return back()->withInput(['name', 'username', 'email']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out');
    }

    public function showForgotPassword(){
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Password reset link sent to your email.'
            );
        }

        return back()->withErrors([
            'email' => 'We could not find a user with that email address.',
        ]);
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'confirm_password.required' => 'Confirm Password is required',
            'confirm_password.same' => 'Confirm Password and Password does not match',
        ]);

        $status = Password::reset(
            [
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->confirm_password,
                'token' => $request->token,
            ],
            function ($user, $password) {

                $user->password = Hash::make($password);

                $user->setRememberToken(
                    Str::random(60)
                );

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login.show')
                ->with('success', 'Password reset successfully.');
        }

        return back()->withErrors([
            'email' => 'The password reset link is invalid or has expired.',
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::withTrashed()->where('email', $googleUser->getEmail())->first();

        if ($user && $user->trashed()) {
            return redirect()->route('login.show')
                ->withErrors(['credentials' => 'This account has been deleted.',]);
        }

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'username' => $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(32)),
                'role' => 'customer',
                'active' => true,
            ]);

            $user->email_verified_at = now();
            $user->save();
            $user->assignRole('customer');
        }

        if (!$user->active) {
            return redirect()
                ->route('login.show')
                ->withErrors([
                    'credentials' => 'Your account is inactive.',
                ]);
        }

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'You are now logged in with Google.');
    }

    public function showTwoFactor(){
        if (!session('2fa_user_id')) {
            return redirect()->route('login.show');
        }

        return view('auth.two-factor');
    }

    public function verifyTwoFactor(Request $request){
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if(!session('2fa_user_id')){
            return redirect()->route('login.show');
        }

        if($request->code != session('2fa_code') || now()->greaterThan(session('2fa_expires_at'))) {
            return back()->withErrors([
                'code' => 'Invalid or expired two factor code.',
            ]);
        }

        $user = User::find(session('2fa_user_id'));

        Auth::login($user, session('2fa_remember', false));

        session()->forget([
            '2fa_user_id',
            '2fa_code',
            '2fa_expires_at',
            '2fa_remember',
        ]);

        return redirect()->route('home')->with('success', 'You are now logged in.');
    }
}
