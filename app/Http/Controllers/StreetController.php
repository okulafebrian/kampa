<?php

namespace App\Http\Controllers;

use App\Http\Requests\StreetRequest;
use App\Http\Resources\HouseResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\StreetResource;
use App\Models\Province;
use App\Models\Street;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StreetController extends Controller
{
    public function index()
    {
        $streets = Street::where('organization_id', auth()->user()->organization_id)->get();

        return inertia('Streets/Index', [
            'streets' => StreetResource::collection($streets)
        ]);
    }

    public function create()
    {
        return inertia('Streets/Create', [
            'provinces' => ProvinceResource::collection(Province::all()),
        ]);
    }

    public function store(StreetRequest $request)
    {
        $street = Street::where([
            ['village_id', $request->village_id],
            ['name', $request->name],
            ['organization_id', auth()->user()->organization_id]
        ])->first();

        if ($street) {
            return back()->with('failed', 'Data telah ada');
        }

        Street::create([
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'name' => $request->name,
            'organization_id' => auth()->user()->organization_id,
            'created_by' => auth()->user()->id
        ]);

        return redirect()->route('streets.index')->with('success', 'Jalan berhasil ditambahkan');
    }

    public function show(Street $street)
    {
        $houses = $street->houses;

        return inertia('Streets/Show', [
            'street' => StreetResource::make($street),
            'houses' => Inertia::lazy(fn () => HouseResource::collection($houses))
        ]);
    }

    public function edit(Street $street)
    {
        return inertia('Streets/Edit', [
            'street' => StreetResource::make($street),
            'provinces' => ProvinceResource::collection(Province::all()),
        ]);
    }

    public function update(StreetRequest $request, Street $street)
    {
        $street->update([
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'name' => $request->name,
            'updated_by' => auth()->user()->id
        ]);

        return redirect()->route('streets.show', $street)->with('success', 'Jalan berhasil diperbaharui');
    }

    public function destroy(Street $street)
    {
        $street->delete();

        return redirect()->route('streets.index')->with('success', 'Jalan berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        foreach ($request->streets as $street) {
            Street::find($street['id'])->delete();
        }

        return redirect()->route('streets.index')->with('success', count($request->streets) . ' jalan berhasil dihapus');
    }
}
