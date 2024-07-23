<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'village' => VillageResource::make($this->village),
            'district' => DistrictResource::make($this->district),
            'regency' => RegencyResource::make($this->regency),
            'province' => ProvinceResource::make($this->province),
        ];
    }
}
