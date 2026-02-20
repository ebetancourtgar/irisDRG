<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('branch', 'roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all(); // Para el select
        $roles = Role::all();      // Para el select de roles 
        return view('users.create', compact('branches', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado y rol asignado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $branches = Branch::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'branches', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'branch_id' => $request->branch_id,
        ];

        // Solo actualizamos password si lo enviaron
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // 2. Sincronizar roles (quita el anterior y pone el nuevo)
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }
}
