<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017-08-02
 * Time: 6:21 PM
 */

namespace HCES\Enums;


abstract class DupeChecks
{
    const methods = [
        ['name' => 'NO DUPLICATE CHECK', 'code' => 'none'],
        ['name' => 'LISTS IN A PARTICULAR GROUP', 'code' => 'DUPGROUP'],
        ['name' => 'LISTS USED', 'code' => 'DUPLISTUSED'],
    ];
}