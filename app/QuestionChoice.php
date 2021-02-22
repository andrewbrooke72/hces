<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionChoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_paper_question_id',
        'value',
        'points'
    ];
}
