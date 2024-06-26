<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'department',
        'branch',
    ];

    public function assigns(): HasMany
    {
        return $this->hasMany(Assign::class);
    }
}
