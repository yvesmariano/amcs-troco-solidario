<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
        'user_id',
        'point_of_sale_id',
        'commission_percentage',
        'commission_amount',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }
}
