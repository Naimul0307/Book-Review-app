<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    //This method will show register page
   
    public function register(){
        return view('account.register');
    }

    //This method will register user
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' =>  'required|min:4',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
        
        //Now Register User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('account.login')->with('success','You have registered successfully.');
    }

    public function login(){
        return view('account.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' =>'required|email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error','Either email/password is incorrect!');
        }
    }

    public function profile(){
        return view('account.profile');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
}