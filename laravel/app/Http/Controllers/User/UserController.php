<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Access\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role'])->paginate(15);

        return view('pengguna.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('pengguna.tambah', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:30',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'name' => 'required|max:30',
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = new User;

            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->role_id = $request->role_id;

            $user->save();
        });

        return redirect('/pengguna')->with('success', 'Berhasil menambahkan pengguna baru!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('pengguna.ubah', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:30',
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable',
            'name' => 'required|max:30',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::findOrFail($id);

        DB::transaction(function () use ($request, $user) {
            $user->username = $request->username;
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->name = $request->name;
            $user->role_id = $request->role_id;
            $user->save();
        });

        return redirect('/pengguna')->with('success', 'Berhasil mengubah data pengguna!');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/pengguna');
    }
}
