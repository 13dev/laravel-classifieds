<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'authorize']);
    }

    public function index()
    {
        $users = User::where('id', '<>', Auth::user()->id);
        $usersPagin = $users->paginate(10);
        $users = $users->get();

        return view('admin.index')->with(compact('users', 'usersPagin'));
    }

    public function create()
    {
        return view('admin.user.add');
    }

    public function store(Request $request)
    {
        $lastUser = User::all()->last();
        $lastUserIdPlusOne = ($lastUser->id + 1);

        $this->validate($request, [
            'name' => 'required|min:3|max:20|alpha',
            'last_name' => 'required|min:3|max:20|alpha',
            'email' => 'required|email|max:255|unique:users,email,'.$lastUserIdPlusOne,
            'password' => 'required|min:6|confirmed',
            'username' => 'required|min:3|max:13|unique:users|regex:/^[a-zA-Z0-9_]*$/',
        ]);

        $fields = [
            'name' => htmlspecialchars($request->input('name')),
            'last_name' => htmlspecialchars($request->input('last_name')),
            'email' => htmlspecialchars($request->input('email')),
            'password' => $request->input('password'),
            'verified' => $request->input('verified'),
            'username' => htmlspecialchars($request->input('username')),
        ];

        $fields = array_filter($fields, 'strlen');
        $fields = array_filter($fields, 'trim');

        // Atualizar utilizador
        $user = User::create($fields);

        session()->flash('message', trans('messages.success.perfil.create'));

        return redirect()->back();
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.user.edit')
                ->with(compact('user'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        $this->validate($request, [
            'name' => 'min:3|max:20|alpha',
            'last_name' => 'min:3|max:20|alpha',
            'email' => 'email|max:255|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
        ]);

        $fields = [
            'name'      => htmlspecialchars($request->input('name')),
            'last_name' => htmlspecialchars($request->input('last_name')),
            'email'     => htmlspecialchars($request->input('email')),
            'password'  => $request->input('password'),
            'verified'  => false,
        ];

        $fields = array_filter($fields, 'strlen');
        $fields = array_filter($fields, 'trim');

        // Atualizar utilizador
        $user->update($fields);

        return redirect('/admin/users')
                ->with(session()->flash('message', trans('messages.success.perfil.update')));
    }

    public function destroyView($id)
    {
        $user = User::find($id);
        if (! $user) {
            return redirect('/admin/users')
                    ->with(session()->flash('messageError', trans('messages.success.perfil.notFound')));
        }

        return view('admin.user.delete')->with(compact('user'));
    }

    public function destroy($id, Item $items)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect('/admin/users')
                    ->with(session()->flash('messageError', trans('messages.success.perfil.notFound')));
        }

        //Eliminar Anuncios do utilizador
        foreach ($user->items as $item) {
            $items->delete();
        }

        $user->delete();

        return redirect('/admin/users')
                ->with(session()->flash('message', trans('messages.success.perfil.delete')));
    }
}
