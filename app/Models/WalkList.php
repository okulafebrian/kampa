<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class WalkList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'organization_id',
        'created_by',
        'updated_by'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function assigneeable(): MorphTo
    {
        return $this->morphTo();
    }

    public function contacts(): MorphToMany
    {
        return $this->morphedByMany(Contact::class, 'walk_listable');
    }

    public function houses(): MorphToMany
    {
        return $this->morphedByMany(House::class, 'walk_listable');
    }
}
