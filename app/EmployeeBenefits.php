<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBenefits extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'benefits_id',
        'value',
    ];
}
