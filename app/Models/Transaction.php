<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'consumer_name',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'code');
    }
}
