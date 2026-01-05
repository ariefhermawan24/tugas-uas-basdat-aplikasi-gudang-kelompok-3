<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'parent_order_id',
        'user_id',
        'order_code',
        'item_name',
        'item_type',
        'item_size',
        'quantity',
        'pallet_estimated',
        'storage_duration',
        'estimated_delivery',
        'storage_end_date',
        'bukti_bayar',
        'status_bayar',
        'status_keluar',
        'renew_end_date',
        'renew_extend_days',
        'renew_price',
        'destination',
        'price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
