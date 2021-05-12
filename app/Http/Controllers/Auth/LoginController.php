<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function verifyUser(Request $request)
    {
        // validation
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'            
        ]);

        //sign in the user
        if (Auth::attempt($request->only('email', 'password'), $request->remember))
         {
             //success
            //redirect on dashboard
             return redirect()->route('dashboard');
         }else{
             return redirect()->route('login')->with('status', 'Login failed');
         }
    }
}
