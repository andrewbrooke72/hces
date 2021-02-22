<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name'
    ];

    public function testpapers()
    {
        return $this->belongsToMany('HCES\TestPaper', 'module_testpapers', 'module_id', 'test_paper_id');
    }
}
