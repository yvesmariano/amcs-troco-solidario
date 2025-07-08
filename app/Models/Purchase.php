<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Traits\HasUUIDAttribute;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasUUIDAttribute;

    protected $fillable = [
        'amount',
        'point_of_sale_id',
        'operator_id',
        'payment_method',
        'transaction_id',
        'transaction_proof',
    ];

    public $hidden = [
        'id',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }
}
