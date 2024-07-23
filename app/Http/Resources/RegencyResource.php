<?php

namespace App\Http\Resources;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegencyResource extends JsonResource
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
            'name' => ucwords(strtolower($this->name)),
            'slug' => $this->slug,
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
            'districts_count' => $this->districts_count,
            'total_villages_count' => $this->total_villages_count
        ];
    }
}
