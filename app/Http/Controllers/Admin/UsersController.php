<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function __construct() {
		$this->middleware(['auth', 'authorize']);
	}

	public function getUsers() {
		$users = User::where('id','<>', Auth::user()->id)->get();
		return view('admin.index')->with(compact('users'));
	}
}
