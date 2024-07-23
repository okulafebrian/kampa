<?php

namespace App\Http\Controllers;

use App\Http\Resources\StreetResource;
use App\Models\Street;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Street $street)
    {
        //
    }

    public function edit(Street $street)
    {
        //
    }

    public function update(Request $request, Street $street)
    {
        //
    }

    public function destroy(Street $street)
    {
        //
    }
}
