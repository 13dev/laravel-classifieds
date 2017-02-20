<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Item;
use Auth;
use Hash;

class UserController extends Controller
{
	public function __construct() {
		$this->middleware('auth', ['except' => 'index']);
	}
	public function index($username) {
		$user = User::where('username','=',$username)->first();
		if (!$user) {
			return abort(404);
		}
		return view('user.index')
				->with('user',$user);
	}
	public function getEditar(){
		return view('user.edit')
				->with('user', Auth::user());
	}

	public function postEditar(request $request){

		$this->validate($request, [
			'name'      => 'min:3|max:20|alpha',
			'last_name' => 'min:3|max:20|alpha',
			'email'     => 'email|max:255|unique:users,email,'.\Auth::user()->id,
			'password'  => 'min:6|confirmed',
		]);

		$fields = [
			'name' 		=> htmlspecialchars($request->input('name')),
			'last_name' => htmlspecialchars($request->input('last_name')),
			'email' 	=> htmlspecialchars($request->input('email')),
			'password' 	=> $request->input('password'),
		];

		$fields = array_filter($fields, 'strlen');
		$fields = array_filter($fields, 'trim');
		
		// Atualizar utulizador
		Auth::user()->update($fields);
		

		return redirect('/perfil')
				->with(session()->flash('message', trans('messages.success.perfil.update')));

	}
}
