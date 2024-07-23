<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalkListResource extends JsonResource
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
            'status' => $this->status,
            'assignee' => $this->assigneeable->name ?? $this->assigneeable->first_name . ' ' . $this->assigneeable->last_name
        ];
    }
}
