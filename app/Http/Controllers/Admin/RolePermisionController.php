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

        /* Create A Role */
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);

        /* Assign Multiple Permissions To A Role */
        $role->syncPermissions($request->permissions);
        toast(__('Created Successfully'), 'success');
        return redirect()->route('admin.role.index');
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions;
        $rolePermissions = $rolePermissions->pluck('name')->toArray();
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        $role = Role::findOrFail($id);

        /* Update A Role */
        $role->update(['guard_name' => 'admin', 'name' => $request->role]);

        /* Assign Multiple Permissions To A Role */
        $role->syncPermissions($request->permissions);
        toast(__('Updated Successfully'), 'success');
        return redirect()->route('admin.role.index');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if($role->name === 'Super Admin')
        {
            return response(['status' => 'error', 'message' => __('Can\'t delete the Super Admin')]);
        }
        $role->delete();
        return response(['status' => 'success', 'message' => __('Deleted Successfully')]);

    }
}
