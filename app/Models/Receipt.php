<?php

namespace App\Models;

use App\Traits\HasUUIDAttribute;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasUUIDAttribute;

    protected $fillable = [
        'point_of_sale_id',
        'operator_id',
        'paid_at',
        'external_id',
        'qr_code_content',
        'description',
        'total',
    ];

    public $hidden = [
        'id',
    ];

    public function donations()
    {
        return $this->belongsToMany(Donation::class);
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }
}
