<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request ){
        // validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed'            
        ]);

       //store on database
       User::create([
           'name' => $request->name,
           'username' => $request->username,
           'email' => $request->email,
           'password' => Hash::make($request->password)
       ]);

    //    if (Auth::attempt([
    //        'email' => $request->email, 
    //        'password' => $request->password
    //        ]))
    //     {
    //          dd(Auth::attempt($request->only('email', 'password')));
    //         // return redirect()->route('dashboard');
    //     }

        //sign in the user
        if (Auth::attempt($request->only('email', 'password')))
         {
             //success
            //redirect on dashboard
             return redirect()->route('dashboard');
         }       
    }
}
