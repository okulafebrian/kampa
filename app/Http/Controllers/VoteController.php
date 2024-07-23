<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\RegencyResource;
use App\Http\Resources\UserResource;
use App\Models\District;
use App\Models\PollingStation;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function index()
    {
        $electionType = auth()->user()->organization->election_type;

        if ($electionType === 'presidential') {
            $provinces = ProvinceResource::collection(Province::all());
        }

        if ($electionType === 'governor') {
            $region = ProvinceResource::make(Province::find(auth()->user()->organization->region_id));

            $regencies = Regency::with('districts')->where('province_id', auth()->user()->organization->region_id)->get();
        }

        $regencyVotes = DB::table('polling_stations')
            ->leftJoin('villages', 'polling_stations.village_id', '=', 'villages.id')
            ->leftJoin('districts', 'villages.district_id', '=', 'districts.id')
            ->leftJoin('regencies', 'districts.regency_id', '=', 'regencies.id')
            ->leftJoin('votes', 'polling_stations.id', '=', 'votes.polling_station_id')
            ->where('regencies.province_id', 31)
            ->groupBy('regencies.id', 'regencies.name')
            ->select('regencies.id', 'regencies.name', DB::raw('SUM(votes.vote_count) as total_votes'))
            ->get();

        return inertia('Votes/Index', [
            'region' => $region,
            'provinces' => $provinces ?? null,
            'regencies' => RegencyResource::collection($regencies),
            'election_type' => $electionType,
            'regencyVotes' => $regencyVotes
        ]);
    }

    public function store(VoteRequest $request)
    {
        DB::beginTransaction();

        $attachment = $request->attachment;

        if ($request->hasFile('attachment')) {
            $pollingStation = PollingStation::find($request->polling_station_id);

            $filename =  $pollingStation->village->id . '_' . $pollingStation->name . '.' . $attachment->getClientOriginalExtension();

            Storage::putFileAs('votes', $request->file('attachment'), $filename);
        }

        Vote::create([
            'polling_station_id' => $request->polling_station_id,
            'vote_count' => $request->vote_count,
            'attachment' => $filename ?? null,
            'witness_id' => $request->witness_id ?? null,
            'organization_id' => auth()->user()->organization_id,
            'created_by' => auth()->user()->id
        ]);

        DB::commit();

        return back();
    }

    public function show(District $district)
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('code', 'witness');
        })->get();

        return inertia('Votes/Show', [
            'district' => DistrictResource::make($district->load('villages')),
            'users' => Inertia::lazy(fn () => UserResource::collection($users))
        ]);
    }
}
