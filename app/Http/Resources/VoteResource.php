<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
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
            'vote_count' => $this->vote_count,
            'attachment' => $this->attachment,
            'witness' => UserResource::make($this->witness),
            'creator' => UserResource::make($this->creator)
        ];
    }
}
