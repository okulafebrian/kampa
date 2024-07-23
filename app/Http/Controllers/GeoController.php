<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\PollingStationResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\RegencyResource;
use App\Http\Resources\StreetResource;
use App\Http\Resources\VillageResource;
use App\Models\District;
use App\Models\PollingStation;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Street;
use App\Models\Village;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function provinces()
    {
        $provinces = Province::all();

        return ProvinceResource::collection($provinces);
    }

    public function regencies(Province $province = null)
    {
        $regencies = $province
            ? Regency::where('province_id', $province->id)->get()
            : Regency::all();

        return RegencyResource::collection($regencies);
    }

    public function districts(Regency $regency)
    {
        $districts = District::where('regency_id', $regency->id)->get();

        return DistrictResource::collection($districts);
    }

    public function villages(District $district)
    {
        $villages = Village::where('district_id', $district->id)->get();

        return VillageResource::collection($villages);
    }

    public function pollingStations(Village $village)
    {
        $pollingStations = PollingStation::where('village_id', $village->id)->get();

        return PollingStationResource::collection($pollingStations);
    }

    public function streets(Village $village)
    {
        $streets = Street::where('organization_id', auth()->user()->organization_id);

        if ($village) {
            $streets = $streets->where('village_id', $village->id);
        }

        return StreetResource::collection($streets->get());
    }
}
