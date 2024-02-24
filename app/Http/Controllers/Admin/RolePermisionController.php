<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermisionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);
        $role->syncPermissions($request->permissions);
        toast(__('Created Successfully'), 'success');
        return redirect()->route('admin.role.index');
    }
}
