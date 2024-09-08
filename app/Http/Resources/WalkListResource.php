<?php

namespace App\Http\Resources;

use App\Models\Group;
use App\Models\User;
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
        $assignee = null;

        if ($this->assigneeable instanceof User) {
            $assignee = UserResource::make($this->assigneeable);
        }

        if ($this->assigneeable instanceof Group) {
            $assignee = GroupResource::make($this->assigneeable);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'assignee' => $assignee,
            'totals' => $this->totals
        ];
    }
}
