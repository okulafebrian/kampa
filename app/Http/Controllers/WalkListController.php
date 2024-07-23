<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalkListResource;
use App\Models\WalkList;
use Illuminate\Http\Request;

class WalkListController extends Controller
{
    public function index()
    {
        $walkLists = WalkList::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('WalkLists/Index', [
            'walkLists' => WalkListResource::collection($walkLists)
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $walkList = WalkList::create([
            'name' => $request->newWalkList['name'],
            'assigneeable_type' => 'App\Models\User',
            'assigneeable_id' => 3,
            'organization_id' => auth()->user()->organization_id,
            'created_by' => auth()->user()->id
        ]);

        foreach ($request->contacts as $contact) {
            $walkList->contacts()->attach($contact['id']);
        }

        return back()->with('success', 'Daftar berhasil ditambahkan');
    }

    public function show(WalkList $walkList)
    {
        //
    }

    public function edit(WalkList $walkList)
    {
        //
    }

    public function update(Request $request, WalkList $walkList)
    {
        //
    }

    public function destroy(WalkList $walkList)
    {
        //
    }
}
