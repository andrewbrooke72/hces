<?php

/**
 * Created by PhpStorm.
 * User=> admin
 * Date=> 2018-11-22
 * Time=> 5=>54 PM
 */
namespace HCES\Traits;

use HCES\DiallerConnection;
use HCES\DiallerTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

trait DataMapperHelperTrait
{
    public function removeUnwantedColumns($columns, $keys_to_remove)
    {
        foreach ($keys_to_remove as $key) {
            if (($key = array_search($key, $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        return $columns;
    }
}