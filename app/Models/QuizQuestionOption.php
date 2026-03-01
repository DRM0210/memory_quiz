<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_question_id',
        'image',
        'label',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function quizQuestion(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }
}
