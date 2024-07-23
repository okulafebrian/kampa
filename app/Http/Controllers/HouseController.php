<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\InteractionResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\StreetResource;
use App\Models\House;
use App\Models\Interaction;
use App\Models\Province;
use App\Models\Street;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        if (is_string($request->street)) {
            $street = Street::create([
                'name' => $request->street,
                'province_id' => $request->province_id,
                'regency_id' => $request->regency_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'created_by' => auth()->user()->id,
                'organization_id' => auth()->user()->organization_id
            ]);
        } else {
            $street = Street::find($request->street['id']);
        }

        if ($request->neighborhood) {
            list($rt, $rw) = explode('/', $request->neighborhood);
        }

        $street->houses()->create([
            'number' => $request->house_number,
            'name' => $request->house_name,
            'unit' => $request->house_unit,
            'neighborhood_rt' => $rt ?? null,
            'neighborhood_rw' => $rw ?? null,
            'street_id' => $request->street_id,
            'created_by' => auth()->user()->id,
            'organization_id' => auth()->user()->organization_id
        ]);

        DB::commit();

        return redirect()->route('houses.index');
    }

    public function show(House $house)
    {
        $contacts = $house->contacts;
        $interactions = $house->interactions;

        return inertia('Houses/Show', [
            'house' => HouseResource::make($house),
            'contacts' => Inertia::lazy(fn () => ContactResource::collection($contacts)),
            'interactions' => Inertia::lazy(fn () => InteractionResource::collection($interactions))
        ]);
    }

    public function edit(House $house)
    {
        //
    }

    public function update(Request $request, House $house)
    {
        //
    }

    public function destroy(House $house)
    {
        //
    }
}
