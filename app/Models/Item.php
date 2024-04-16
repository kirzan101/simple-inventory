<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand',
        'model',
    ];

    /**
     * Return list of Inventory
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
