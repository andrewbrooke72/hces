<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'is_active',
        'employee_id',
        'shift_id',
        'department_id',
        'position_id',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'age',
        'permanent_address',
        'length_of_service_years',
        'length_of_service_years_months',
        'length_of_service',
        'contact_number',
        'other_contact_number',
    ];

    public function position()
    {
        return $this->belongsTo('HCES\Position');
    }

    public function benefits()
    {
        return $this->hasMany('HCES\Benefits');
    }

    public function shift()
    {
        return $this->belongsTo('HCES\Shift');
    }

    public function department()
    {
        return $this->belongsTo('HCES\Department');
    }
}
