<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_master_id',
        'question_image',
        'answer_image',
        'correct_option_id',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function quizMaster(): BelongsTo
    {
        return $this->belongsTo(QuizMaster::class, 'quiz_master_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizQuestionOption::class, 'quiz_question_id')->orderBy('sort_order');
    }

    public function correctOption(): BelongsTo
    {
        return $this->belongsTo(QuizQuestionOption::class, 'correct_option_id');
    }
}
