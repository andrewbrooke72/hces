<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rank',
        'name',
        'description',
        'employment_status',
        'rate',
        'rate_type',
    ];

    public function employees()
    {
        return $this->hasMany('HCES\Employee');
    }
}
