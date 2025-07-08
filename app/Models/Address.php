<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street_address',
        'street_number',
        'complement',
        'city',
        'state',
        'zip_code',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
