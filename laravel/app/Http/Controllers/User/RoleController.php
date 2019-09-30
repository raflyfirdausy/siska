<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Access\Role;
use App\Models\Access\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions'])->get();

        return view('role.index', compact('roles'));
    }
    
    public function create()
    {
        $permissions = Permission::all();

        return view('role.tambah', compact('permissions'));
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('role.lihat', compact('show'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|max:25',
            'permission_ids' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $role = new Role;
            $role->name = $request->role_name;
            $role->save();
            $role->permissions()->sync($request->permission_ids, false);
        });

        return redirect('/role');
    }

    public function edit($id)
    {
        $role = Role::with(['permissions'])->whereId($id)->first();
        $permissionsInRole = $role->permissions->map(function($item) {
            return $item->id;
        })->toArray();

        $permissions = Permission::all();

        return view('role.ubah', compact('role', 'permissions', 'permissionsInRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required',
            'permission_ids' => 'required|array',
        ]);

        $role = Role::findOrFail($id);
            
        DB::transaction(function () use ($request, $role) {
            $role->name = $request->role_name;
            $role->save();
            $role->permissions()->sync($request->permission_ids, false);
        });

        return redirect('/role');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->users()->delete();
        $role->permissions()->detach();
        $role->delete();

        return redirect('/role');
    }
}
