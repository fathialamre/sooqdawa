<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'iso',
    ];

    /**
     * Get the users that belong to the country.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
