<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\EmploymentResource;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\PollingStationResource;
use App\Http\Resources\WalkListResource;
use App\Models\Contact;
use App\Models\Employment;
use App\Models\PollingStation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('organization_id', auth()->user()->organization_id)->get();
        $employments = Employment::all();

        return inertia('Contacts/Index', [
            'contacts' => ContactResource::collection($contacts),
            'employments' => EmploymentResource::collection($employments)
        ]);
    }

    public function create()
    {
        //
    }

    public function store(ContactRequest $request)
    {
        Contact::create([
            'house_id' => $request->house_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'polling_station_id' => $request->polling_station_id,
            'employment_id' => $request->employment_id,
            'is_volunteer' => $request->is_volunteer,
            'is_witness' => $request->is_witness,
            'is_deceased' => $request->is_deceased,
            'organization_id' => auth()->user()->organization_id,
            'created_by' => auth()->user()->id
        ]);

        return back()->with('success', 'Kontak berhasil ditambahkan');
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

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'polling_station_id' => $request->polling_station_id,
            'employment_id' => $request->employment_id,
            'is_volunteer' => $request->is_volunteer,
            'is_witness' => $request->is_witness,
            'is_deceased' => $request->is_deceased,
            'updated_by' => auth()->user()->id
        ]);

        return redirect()->route('contacts.show', $contact)->with('success', 'Kontak berhasil diperbaharui');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        foreach ($request->contacts as $contact) {
            Contact::find($contact['id'])->delete();
        }

        return redirect()->route('contacts.index')->with('success', count($request->contacts) . ' kontak berhasil dihapus');
    }
}
