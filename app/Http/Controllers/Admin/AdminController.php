<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'authorize']);
    }

    /**
     * Controlle the WebSite / Admin Panel!
     */
    public function index()
    {
        return view('admin.index');
    }
}
