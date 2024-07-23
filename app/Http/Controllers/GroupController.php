<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('users')->where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Groups/Index', [
            'groups' => GroupResource::collection($groups)
        ]);
    }

    public function create()
    {
        $users = User::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->get();

        return inertia('Groups/Create', [
            'users' => UserResource::collection($users),
            'roles' => RoleResource::collection(Role::all())
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $group = Group::create([
            'name' => $request->newGroup['name'],
            'organization_id' => auth()->user()->organization_id,
            'created_by' => auth()->user()->id
        ]);

        foreach ($request->users as $user) {
            User::find($user['id'])->update([
                'group_id' => $group->id
            ]);
        }

        DB::commit();

        return redirect()->route('groups.index')->with('success', 'Grup berhasil ditambahkan');
    }

    public function show(Group $group)
    {
        //
    }

    public function edit(Group $group)
    {
        $users = User::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'active')
            ->get();

        return inertia('Groups/Edit', [
            'group' => GroupResource::make($group->load('users')),
            'users' => UserResource::collection($users),
            'roles' => RoleResource::collection(Role::all())
        ]);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update([
            'updated_by' => auth()->user()->id
        ]);

        foreach ($request->users as $user) {
            $group->users()->sync($user['id']);
        }

        return redirect()->route('groups.index')->with('success', 'Grup berhasil diperbaharui');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Grup berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        foreach ($request->groups as $group) {
            Group::find($group['id'])->delete();
        }

        return redirect()->route('groups.index')->with('success', 'Grup berhasil dihapus');
    }
}
