<?php

namespace App\Http\Controllers;

use App\Http\Requests\InteractionRequest;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(InteractionRequest $request)
    {
        Interaction::create([
            'status' => $request->status,
            'support_level' => $request->support_level,
            'notes' => $request->notes,
            'contact_id' => $request->contact_id,
            'user_id' => auth()->user()->id,
            'organization_id' => auth()->user()->organization_id
        ]);

        return redirect()->back();
    }

    public function show(Interaction $interaction)
    {
        //
    }

    public function edit(Interaction $interaction)
    {
        //
    }

    public function update(Request $request, Interaction $interaction)
    {
        //
    }

    public function destroy(Interaction $interaction)
    {
        //
    }
}
