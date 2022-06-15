<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register()
    {
        $data['title'] = 'Register';
        return view('user/register', $data);
    }
    public function register_action(Request $request)
    {
        $UserData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:tb_user',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        $UserData['password'] = Hash::make($UserData['password']);
        User::create($UserData);
    
        return redirect('/login')->with('succes', 'Registration Succes');
    }
    public function login()
    {
        $data['title'] = 'Login';
        return view('user/login', $data);
    }

    public function login_action(Request $request)
    {
        $UserData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if(Auth::attempt($UserData))
        {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors('login')->with('password', 'Wrong username or password');
    }
}
