<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'unit',
        'neighborhood_rt',
        'neighborhood_rw',
        'street_id',
        'organization_id',
        'created_by',
        'updated_by'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function walkLists(): MorphToMany
    {
        return $this->morphToMany(WalkList::class, 'walk_listables');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function interactions()
    {
        return $this->hasManyThrough(Interaction::class, Contact::class);
    }
}
