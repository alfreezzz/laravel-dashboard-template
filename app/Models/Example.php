<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Example extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'price',
        'quantity',
        'status',
        'is_active',
        'category_id',
        'featured_image',
        'document',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->slug) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}
