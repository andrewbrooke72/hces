<?php

namespace HCES;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo', 'first_name', 'employee_id', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function employee()
    {
        return $this->belongsTo('HCES\Employee');
    }

    public function permissions()
    {
        return $this->belongsToMany('HCES\Permission', 'user_permissions', 'user_id', 'permission_id');
    }

    public function hasAnyPermission($required_permissions)
    {
        if (is_array($required_permissions)) {
            foreach ($required_permissions as $required_permission) {
                if ($this->hasPermission($required_permission)) {
                    return true;
                }
            }
        } else {
            if ($this->hasPermission($required_permissions)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($required_permission)
    {
        $permissions = $this->permissions;

        foreach ($permissions as $permission) {
            if ($permission->name == $required_permission) {
                return true;
            }
        }

        return false;
    }

    public function notifications()
    {
        return $this->hasMany('HCES\Notification');
    }
}
