<?php

namespace App\Http\Resources;

use App\Models\Employment;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'gender' => $this->gender,
            'dob' => $this->dob?->toDateString(),
            'age' => Carbon::parse($this->dob)->age,
            'phone' => $this->phone,
            'email' => $this->email,
            'house' => HouseResource::make($this->house),
            'pollingStation' => PollingStationResource::make($this->pollingStation),
            'employment' => EmploymentResource::make($this->employment),
            'is_volunteer' => $this->is_volunteer,
            'is_witness' => $this->is_witness,
            'is_deceased' => $this->is_deceased,
            'interactions' => InteractionResource::collection($this->whenLoaded('interactions')),
            'creator' => UserResource::make($this->creator),
            'updater' => UserResource::make($this->updater),
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
        ];
    }
}
