<?php

namespace HCES\Http\Controllers;

use HCES\DataList;
use HCES\DynamicDataList;
use HCES\Traits\DupeCheckTrait;
use HCES\Traits\PAFCheckerTrait;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception\RuntimeException;

class PlayGroundController extends Controller
{
    use PAFCheckerTrait;

    public function index()
    {
        dd(Carbon::parse('8/5/2019 01:00pm')->format('Y-m-d H:i:s'));
    }
}
