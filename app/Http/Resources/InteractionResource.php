<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
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
            'status' => $this->status,
            'support_level' => $this->support_level,
            'notes' => $this->notes,
            'user' => UserResource::make($this->user),
            'contact' => ContactResource::make($this->contact),
            'created_at' => $this->created_at->translatedFormat('d M Y')
        ];
    }
}
