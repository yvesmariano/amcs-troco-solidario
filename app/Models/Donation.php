<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Traits\HasUUIDAttribute;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasUUIDAttribute;

    protected $fillable = [
        'status',
        'amount',
        'customer_id',
        'campaign_id',
        'point_of_sale_id',
        'operator_id',
        'payment_method',
        'received_at',
        'purchase_id',
    ];

    public $hidden = [
        'id',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
        'created_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }
}
