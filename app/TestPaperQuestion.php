<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestPaperQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_paper_id',
        'is_star',
        'type',
        'file_page_reference',
        'name',
        'question'
    ];

    public function choices(){
        return $this->hasMany('HCES\QuestionChoice');
    }
}
