<?php

namespace App\Http\Resources;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->election_type === 'presidential') {
            $region = 'Nasional';
        } else if ($this->election_type === 'governor') {
            $region = Province::find($this->region_id)->name;
        } else if ($this->election_type === 'regent' || $this->election_type === 'mayor') {
            $region = Regency::find($this->region_id)->name;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'election_type' => $this->election_type,
            'region' => $region,
            'users_count' => $this->users_count,
            'contacts_count' => $this->contacts_count,
            'houses_count' => $this->houses_count,
            'interactions_count' => $this->interactions_count,
        ];
    }
}
