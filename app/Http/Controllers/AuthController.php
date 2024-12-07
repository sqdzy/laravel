<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function signup(){
        return view('auth.signup');
    }

    public function registr(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:\App\Models\User',
            'password'=>'required|min:6|max:10'
        ]);
        $response=[
            'name'=>$request->name,
            'email'=>request('email'),
            'password'=>request('password')
        ];
        // return response()->json($response);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'reader',
        ]);
        $user->remember_token = $user->createToken('MyAppToken')->plainTextToken;
        $user->save();
        return redirect()->route('login');
    }

    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:10'
        ]); 
        if(Auth::attempt($credentials, $request->remember))
        {
            $request->session()->regenerate();
            return redirect()->intended('/article');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
