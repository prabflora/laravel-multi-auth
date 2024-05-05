<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //this method will show user login page for customer
    public function index(){
     return view('login');    

    }
     
    //This method authenticate the user
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){

            if(Auth::attempt(['email' => $request->email , 'password' => $request->password] )){
             return  redirect()->route('account.dashboard');

            }
        else{
         return  redirect()->route('account.login')->with('error','Either email or password incorrect');
        }
    }
        else{
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }


     public function register(){
        return view('register');
     }

    //This method used for user register
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);

        if($validator->passes()){
           $user= new User();
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = Hash::make($request->password);
           $user->role= 'customer';
           $user->save();
           return redirect()->route('account.login')->with('success','you have register successfuly');            
    }
        else{
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
       
        return view('register');
    }

    //This method is for user logout

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
}
