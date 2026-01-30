<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    protected $table = 'items';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected $fillable = [
        'code',
        'name',
        'selling_price',
        'buying_price',
        'unit',
        'category_id',
    ];

    use SoftDeletes;
}
