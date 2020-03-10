<?php

/**
 * Created by PhpStorm.
 * User=> admin
 * Date=> 2018-11-22
 * Time=> 5=>54 PM
 */
namespace App\Traits;

trait ArrayHelpers
{
    public function convertMapperTextToArray($mapper){
        $trimmed =  trim(preg_replace('/\s\s+/', ' ', $mapper));
        $arrayed = explode(',',str_replace(['{', '}'],['',''],$trimmed));
        $converted_data = [];
        foreacH($arrayed as $index => $value){
            $arrayed_value = explode(':',str_replace('"', '', preg_replace('/\s+/', '', $value)));
            $converted_data[$arrayed_value[0]] = $arrayed_value[1];
        }
        return $converted_data;
    }
}