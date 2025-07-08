<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'document',
        'phone',
        'is_phone_verified',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
