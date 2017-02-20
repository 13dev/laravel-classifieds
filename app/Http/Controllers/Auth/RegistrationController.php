<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mailers\AppMailer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function register(){
        if(Auth::guest()){
            return view('auth.register');
        }else{
            return redirect('/');
        }
    }

    public function postRegister(Request $request, AppMailer $mailer) {
        // validate user input - request
        $this->validate($request, [
            'name'      => 'required|min:3|max:20|alpha',
            'last_name' => 'required|min:3|max:20|alpha',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|confirmed',
            'username'  => 'required|min:3|max:13|unique:users|regex:/^[a-zA-Z0-9_]*$/',
            ]);

        // create user
        $user = User::create($request->all());

        //['name','last_name','email','password','username']
        
        // email them a confirmation link
        $mailer->sendEmailConfirmationTo($user);

        //flash message
        session()->flash('message', trans('messages.success.registration.email_send'));

        return redirect()->back();

    }

    public function confirmEmail($emailtoken) {

        $user = User::whereEmailtoken($emailtoken)->first();

        if($user == null) {
            session()->flash('message', trans('messages.error.registration.confirm_email'));
            return redirect('login');
        }else{
            $user->confirmEmail();
            session()->flash('message', trans('messages.success.registration.confirm_email'));
            return redirect('login');
        }
    }
}
