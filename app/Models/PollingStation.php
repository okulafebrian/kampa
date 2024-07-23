<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PollingStation extends Model
{
    use HasFactory;

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }
}
