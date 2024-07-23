<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('organization_id', auth()->user()->organization_id)->get();
        $groups = Group::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Users/Index', [
            'users' => UserResource::collection($users),
            'roles' => RoleResource::collection(Role::all()),
            'groups' => GroupResource::collection($groups),
        ]);
    }

    public function create()
    {
        $roles = Role::whereNot('code', 'owner')->get();
        $groups = Group::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Users/Create', [
            'roles' => RoleResource::collection($roles),
            'groups' => GroupResource::collection($groups)
        ]);
    }

    public function store(UserRequest $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 'invited',
            'organization_id' => auth()->user()->organization_id,
            'role_id' => $request->role_id,
            'invited_by' => auth()->user()->id,
            'group_id' => $request->group_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Anggota berhasil diundang');
    }

    public function show(User $user)
    {
        return inertia('Users/Show', [
            'user' => UserResource::make($user),
            'interactions' => InteractionResource::collection($user->interactions)
        ]);
    }

    public function edit(User $user)
    {
        $groups = Group::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Users/Edit', [
            'user' => UserResource::make($user),
            'roles' => RoleResource::collection(Role::all()),
            'groups' => GroupResource::collection($groups)
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        dd($request->all());
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 'invited',
            'organization_id' => auth()->user()->organization_id,
            'role_id' => $request->role_id,
            'invited_by' => auth()->user()->id,
            'group_id' => $request->group_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Anggota berhasil diundang');
    }

    public function destroy(User $user)
    {
        //
    }
}
