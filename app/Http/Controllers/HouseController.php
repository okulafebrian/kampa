<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\EmploymentResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\PollingStationResource;
use App\Http\Resources\ProvinceResource;
use App\Models\Employment;
use App\Models\House;
use App\Models\PollingStation;
use App\Models\Province;
use App\Models\Street;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Houses/Index', [
            'houses' => HouseResource::collection($houses)
        ]);
    }

    public function create()
    {
        return inertia('Houses/Create', [
            'provinces' => ProvinceResource::collection(Province::all()),
        ]);
    }

    public function bulkCreate()
    {
        return inertia('Houses/BulkCreate', [
            'provinces' => ProvinceResource::collection(Province::all()),
        ]);
    }

    public function store(HouseRequest $request)
    {
        $street = Street::find($request->street_id);

        if ($request->neighborhood) {
            list($rt, $rw) = explode('/', $request->neighborhood);
        }

        $house = House::where([
            ['street_id', $street->id],
            ['number', $request->number],
            ['unit', $request->unit],
            ['neighborhood_rt', $rt ?? null],
            ['neighborhood_rw', $rw ?? null],
            ['organization_id', auth()->user()->organization_id]
        ])->first();

        if ($house) {
            return back()->with('failed', 'Data telah ada');
        }

        House::create([
            'street_id' => $street->id,
            'number' => $request->number,
            'name' => $request->name,
            'unit' => $request->unit,
            'neighborhood_rt' => $rt ?? null,
            'neighborhood_rw' => $rw ?? null,
            'created_by' => auth()->user()->id,
            'organization_id' => auth()->user()->organization_id
        ]);

        return redirect()->route('houses.index')->with('success', 'Rumah berhasil ditambahkan');
    }

    public function show(House $house)
    {
        $contacts = $house->contacts;
        $pollingStations = PollingStation::where('village_id', $house->street->village_id)->get();

        return inertia('Houses/Show', [
            'house' => HouseResource::make($house),
            'contacts' => Inertia::lazy(fn () => ContactResource::collection($contacts)),
            'employments' => Inertia::lazy(fn () => EmploymentResource::collection(Employment::all())),
            'pollingStations' => Inertia::lazy(fn () => PollingStationResource::collection($pollingStations))
        ]);
    }

    public function edit(House $house)
    {
        return inertia('Houses/Edit', [
            'house' => HouseResource::make($house),
            'provinces' => ProvinceResource::collection(Province::all()),
        ]);
    }

    public function update(HouseRequest $request, House $house)
    {
        if ($request->neighborhood) {
            list($rt, $rw) = explode('/', $request->neighborhood);
        }

        $house->update([
            'street_id' => $request->street_id,
            'number' => $request->number,
            'name' => $request->name,
            'unit' => $request->unit,
            'neighborhood_rt' => $rt ?? null,
            'neighborhood_rw' => $rw ?? null,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('houses.show', $house)->with('success', 'Rumah berhasil diperbaharui');
    }

    public function destroy(House $house)
    {
        $house->delete();

        return redirect()->route('houses.index')->with('success', 'Rumah berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        foreach ($request->houses as $house) {
            House::find($house['id'])->delete();
        }

        return redirect()->route('houses.index')->with('success', count($request->houses) . ' rumah berhasil dihapus');
    }
}
