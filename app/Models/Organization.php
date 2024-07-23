<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'election_type',
        'region_id'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class);
    }

    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function walkLists(): HasMany
    {
        return $this->hasMany(WalkList::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
