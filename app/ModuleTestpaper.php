<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;

class ModuleTestpaper extends Model
{
    protected $fillable = [
        'module_id',
        'test_paper_id',
        'sort'
    ];
}
