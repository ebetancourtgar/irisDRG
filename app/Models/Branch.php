<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    /** @use HasFactory<\Database\Factories\BranchFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
    ];

    public function users():hasMany
    {
        return $this->hasMany(User::class);
    }
}
