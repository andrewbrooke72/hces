<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePositionHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'position_id',
        'type',
    ];
}
