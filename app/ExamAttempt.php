<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'test_paper_id',
        'score',
        'score_percent',
        'passing_percent',
        'total_points',
        'status'
    ];
}
