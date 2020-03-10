<?php

namespace App\Http\Middleware;

use App\SystemSetting;
use Closure;

class SystemInfoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $system_setting = SystemSetting::first();
        if(!$system_setting->finished_setup){
            return redirect()->route('getSystemSetup');
        }
        return $next($request);
    }
}
