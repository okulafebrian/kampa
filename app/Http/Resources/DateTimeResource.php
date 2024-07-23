<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DateTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'time' => $this->translatedFormat('H:i'),
            'date' => $this->translatedFormat('d M Y'),
            'day' => $this->translatedFormat('d'),
            'month' => $this->translatedFormat('M'),
            'year' => $this->translatedFormat('Y'),
        ];
    }
}
