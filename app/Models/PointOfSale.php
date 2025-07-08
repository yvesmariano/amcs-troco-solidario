<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointOfSale extends Model
{
    protected $fillable = [
        'name',
        'business_name',
        'registration_number',
        'manager_id',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function operators()
    {
        return $this->belongsToMany(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
