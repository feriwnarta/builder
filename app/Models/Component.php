<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Component extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'categories_id',
        'label',
        'media',
        'content',
    ];

    protected $casts = [
        'media' => 'array',
    ];

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
