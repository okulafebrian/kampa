<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'model' => 'App\Models\Group',
            'name' => $this->name,
            'label' => $this->name,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'users_count' => $this->users_count
        ];
    }
}
