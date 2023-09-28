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
        'component_categories_id',
        'label',
        'media',
        'content',
    ];

    public function category() : BelongsTo {
        return $this->belongsTo(ComponentCategory::class, 'component_categories_id');
    }
}
