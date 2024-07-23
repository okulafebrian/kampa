<?php

namespace App\Http\Resources;

use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
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
            'unit' => $this->unit,
            'number' => $this->number,
            'neighborhood_rt' => $this->neighborhood_rt,
            'neighborhood_rw' => $this->neighborhood_rw,
            'street' => StreetResource::make($this->street),
            'address' => $this->street->name . ' No. ' . $this->number,
            'contacts_count' => $this->contacts_count,
            'interactions' => InteractionResource::collection($this->whenLoaded('interactions')),
            'creator' => UserResource::make($this->creator),
            'updater' => UserResource::make($this->updater),
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
        ];
    }
}
