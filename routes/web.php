<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
//Login/logout Routes
Route::get('/login', 'Auth\SessionsController@login');
Route::post('/login', 'Auth\SessionsController@postLogin');
Route::get('/logout', 'Auth\SessionsController@logout');

// Registration routes...
Route::get('/register', 'Auth\RegistrationController@register');
Route::post('/register', 'Auth\RegistrationController@postRegister');
Route::get('/register/confirm/{emailtoken}', 'Auth\RegistrationController@confirmEmail');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::group(['middleware' => ['auth', 'authorize']], function(){
    Route::get('admin', 'Admin\AdminController@index');
});


Route::group(['middleware'=> ['auth', 'authorize']], function(){


    //Route::get('admin', 'Admin\DashboardController@index');
    /**
     * Categories!
     */
    Route::get('/admin/category',[
        'uses' => 'CategoriesController@manageCategory'
    ]);
    Route::post('/admin/add-category',[
        'uses' => 'CategoriesController@addCategory'
    ])->name('addCategory');
    
    Route::post('/admin/delete-category',[
    'uses' => 'CategoriesController@deleteCategory'
    ])->name('deleteCategory');
});

  /*  
    Route::get('admin/users', 'Admin\UsersController@index');
    Route::get('admin/user/add',  'Admin\UsersController@create');
    Route::post('admin/user/add',  'Admin\UsersController@store');
    Route::get('admin/user/edit/{id}',  'Admin\UsersController@edit');
    Route::post('admin/user/edit/{id}',  'Admin\UsersController@update');
    Route::get('admin/user/delete/{id}',  'Admin\UsersController@destroy');

    
    Route::get('admin/roles', 'Admin\RoleController@index');
    Route::get('admin/role/add', 'Admin\RoleController@create');
    Route::post('admin/role/add', 'Admin\RoleController@store');
    Route::get('admin/role/edit/{id}', 'Admin\RoleController@edit');
    Route::post('admin/role/edit/{id}', 'Admin\RoleController@update');
    Route::get('admin/role/delete/{id}', 'Admin\RoleController@destroy');

  
    Route::get('admin/permissions', 'Admin\PermissionController@index');
    Route::get('admin/permission/add', 'Admin\PermissionController@create');
    Route::post('admin/permission/add', 'Admin\PermissionController@store');
    Route::get('admin/permission/edit/{id}', 'Admin\PermissionController@edit');
    Route::post('admin/permission/edit/{id}', 'Admin\PermissionController@update');
    Route::get('admin/permission/delete/{id}', 'Admin\PermissionController@destroy');
    */
Route::get('/u/{username}', 'UserController@index');
Route::get('/a/{slug}', 'AnuncioController@show');


Route::group(['middleware' => 'auth'], function(){
    Route::get('/perfil', 'UserController@getEditar');
    Route::post('/perfil', 'UserController@postEditar');
    /*
    Routes Anuncios!
     */
    Route::get('/a/criar/anuncio', 'AnuncioController@getCriar');
    Route::post('/a/criar/anuncio', 'AnuncioController@postCriar');
    Route::get('/a/{id_anuncio}/editar', 'AnuncioController@getEditar');
    Route::post('/a/{id_anuncio}/editar', 'AnuncioController@postEditar');
    Route::get('/a/{id_anuncio}/eliminar', 'AnuncioController@getEliminar');
    Route::post('/a/{id_anuncio}/eliminar', 'AnuncioController@postEliminar');
    /*
    Routes messagens
     */
    Route::get('/m', 'MessagesController@index');
    Route::post('/m/show', 'MessagesController@getChat');
    Route::post('/m/send', 'MessagesController@Send');
    Route::post('/m/inbox', 'MessagesController@getInbox');

    /*
    Category routes
     */
    
    //Route::resource('categories', 'CategoriesController@index');
});

//Route::resource('categories', 'CategoriesController@index');

//Route::get('test',['uses'=>'TestController@index']);
