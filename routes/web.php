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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authorize']], function() {
    
    // Index do painel de admin.
    Route::get('/', 'Admin\AdminController@index');
    Route::get('/', 'Admin\UsersController@index');
    
    // Categorias
    Route::get('/category', [
        'uses' => 'CategoriesController@manageCategory'
    ]);
    Route::post('/add-category', [
        'uses' => 'CategoriesController@addCategory'
    ])->name('addCategory');

    Route::post('/delete-category', [
        'uses' => 'CategoriesController@deleteCategory'
    ])->name('deleteCategory');
    
    // Admin Users
    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/user/add', 'Admin\UsersController@create');
    Route::post('/user/add', 'Admin\UsersController@store')->name('addUser');
    Route::get('/user/edit/{id}', 'Admin\UsersController@edit');
    Route::post('/user/edit/{id}', 'Admin\UsersController@update')->name('editUser');
    Route::get('/user/delete/{id}', 'Admin\UsersController@destroyView');
    Route::post('/user/delete/{id}', 'Admin\UsersController@destroy')->name('deleteUser');
});

/*



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

Route::get('/a/{slug}', 'ItemController@show');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/perfil', 'UserController@getEditar');
    Route::post('/perfil', 'UserController@postEditar');
    /*
      Routes Anuncios!
     */
    Route::post('/category/getChilds', 'ItemController@selectCategory');
    Route::get('/a/view/myitems', 'ItemController@getMyItems');
    Route::get('/a/select/category', 'ItemController@create')->name('selectCategory');
    Route::post('/a/select/category', 'ItemController@SelectCategory')->name('selectedCategory');
    Route::get('/a/add/item/{category?}', 'ItemController@create');
    Route::post('/a/add/item/{category}', 'ItemController@store')->name('addItem');
    Route::get('/a/edit/{id}', 'ItemController@edit');
    Route::post('/a/edit/{id}', 'ItemController@update')->name('editItem');
    Route::post('/a/delete/{id}', 'ItemController@destroy')->name('deleteItem');
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

//

//Route::get('test',['uses'=>'ItemController@test']);
