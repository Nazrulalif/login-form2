<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        if (Auth::check()){
            return redirect(route('welcome'));
            
        }
        return view('login');
    }

    public function registration(){
        if (Auth::check()){
            return redirect(route('welcome'));
        }
        return view('registration');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            return redirect()->intended(route('welcome'))->with("success", "Login successfully");
        }
        return redirect(route('login'))->with("error", "Login detail error");
    }
    

    public function registrationPost(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);

        $user = User::create($data);

        if(!$user){
            return redirect(route('registration'))->with("Error", "Registration Failed");
        }
        return redirect(route('login'))->with("success", "Registration successfully");
    }

    public function logout(){
        // Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
