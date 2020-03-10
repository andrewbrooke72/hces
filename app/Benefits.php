<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Benefits extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'name'
    ];
}
