<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolePermisionController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function create()
    {
        return view('admin.role.create');
    }
}
