<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResource;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function general()
    {
        return inertia('Settings/General', [
            'organization' => OrganizationResource::make(auth()->user()->organization),
        ]);
    }

    public function role()
    {
        return inertia('Settings/Role', [
            'roles' => RoleResource::collection(Role::all())
        ]);
    }
}
