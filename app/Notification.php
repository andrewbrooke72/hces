<?php

namespace HCES;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'message',
        'attachment',
        'attachment_disk',
        'color',
        'icon',
        'title',
        'has_viewed'
    ];
}
