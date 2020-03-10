<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany('HCES\User', 'user_permissions', 'permission_id', 'user_id');
    }
}
