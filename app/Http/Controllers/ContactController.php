<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Http\Resources\EmploymentResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\PollingStationResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\WalkListResource;
use App\Models\Contact;
use App\Models\Employment;
use App\Models\House;
use App\Models\Interaction;
use App\Models\PollingStation;
use App\Models\Province;
use App\Models\WalkList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('organization_id', auth()->user()->organization_id)->get();
        $walkLists = WalkList::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Contacts/Index', [
            'contacts' => ContactResource::collection($contacts),
            'walkLists' => Inertia::lazy(fn () => WalkListResource::collection($walkLists)),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Contact $contact)
    {
        $interactions = $contact->interactions;

        return inertia('Contacts/Show', [
            'contact' => ContactResource::make($contact),
            'interactions' => Inertia::lazy(fn () => InteractionResource::collection($interactions))
        ]);
    }

    public function edit(Contact $contact)
    {
        $pollingStations = PollingStation::where('village_id', $contact->house->street->village_id)->get();

        return inertia('Contacts/Edit', [
            'contact' => ContactResource::make($contact),
            'employments' => EmploymentResource::collection(Employment::all()),
            'pollingStations' => PollingStationResource::collection($pollingStations)
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        //
    }

    public function destroy(Contact $contact)
    {
        //
    }
}
