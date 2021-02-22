<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestPaper extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slide_url',
        'passing_score',
        'number_of_questions'
    ];

    public function questions(){
        return $this->hasMany('HCES\TestPaperQuestion');
    }

    public function testpapers()
    {
        return $this->belongsToMany('HCES\Module', 'module_testpapers', 'test_paper_id', 'module_id');
    }
}
