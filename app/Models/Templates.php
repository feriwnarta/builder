<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Templates extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'data', 'title', 'subtitle',
        'category_template_id',
        'user_id', 'thumbnail', 'type',
        'template_id'
    ];

    protected $casts = [
        'thumbnail' => 'array',
    ];

    public function templateRepository(): HasOne
    {
        return $this->hasOne(TemplateRepository::class, 'template_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryTemplate::class, 'category_template_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
