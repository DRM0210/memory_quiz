<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'time_duration',
        'no_of_questions',
        'image',
        'status',
    ];

    protected $casts = [
        'time_duration' => 'integer',
        'no_of_questions' => 'integer',
        'status' => 'integer',
    ];
}
