<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_type_id',
        'name',
        'memory_page_image',
        'quiz_time',
        'status',
    ];

    protected $casts = [
        'quiz_time' => 'integer',
        'status' => 'integer',
    ];

    public function quizType(): BelongsTo
    {
        return $this->belongsTo(QuizType::class, 'quiz_type_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_master_id')->orderBy('sort_order');
    }
}
