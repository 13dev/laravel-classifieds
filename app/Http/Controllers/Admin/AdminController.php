<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Controlle the WebSite / Admin Panel! 
     */

    public function index()
    {
    	return view('admin.index');
    }
}
