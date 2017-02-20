<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function login(){
        if(Auth::guest()){
            return view('auth.login');
        }else{
            return redirect('/');
        }
    }

    public function postLogin(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            ]);
        
        if( Auth::attempt($this->getCredentials($request)) ) {
            if(Auth::user()->verified == 1){
                if(Auth::user()->is_admin == 1) {
                    return redirect()->intended('/admin');
                }
                session()->flash('message', 'You are logged in.');
                return redirect()->intended('/'); 
            }else {
                Auth::logout();
                session()->flash('message_email', trans('messages.errors.login.email'));
                return redirect()->back();   
            }
        }

        session()->flash('message_error', trans('messages.errors.login.pass_email'));
        return redirect()->back();

    }

    public function logout(){

        Auth::logout();
        session()->flash('message', trans('messages.success.login.logout'));

        return redirect('/');
    }

    public function getCredentials(Request $request){

        return [
        'email' => $request->input('email'),
        'password' => $request->input('password'),
            //'verified' => true,
        ];

    }
}
