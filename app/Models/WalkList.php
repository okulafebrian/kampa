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
        'assigneeable_id',
        'assigneeable_type',
        'organization_id',
        'created_by',
        'updated_by'
    ];

    protected $appends = ['totals'];

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

    public function getTotalsAttribute()
    {
        $interactions = $this->contacts->flatMap->interactions;

        return [
            'answered' => $interactions->where('status', 'answered')->count(),
            'call back' => $interactions->where('status', 'call back')->count(),
            'not interested' => $interactions->where('status', 'not interested')->count(),
            'not home' => $interactions->where('status', 'not home')->count(),
            'inaccessible' => $interactions->where('status', 'inaccessible')->count(),
        ];
    }
}
