<?php

namespace App\Enums;


abstract class DataListVariables
{
    const KEYS_TO_REMOVE = [
        'id',
        'has_been_downloaded',
        'is_duplicate',
        'list_upload_id',
        'uploader_id',
        'uploader',
        'data_list_id',
        'data_list_group_id',
        'data_tier_id',
        'owner',
        'supplier_name',
        'opted_in',
        'opted_in_method',
        'paf_validated',
        'upload_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
