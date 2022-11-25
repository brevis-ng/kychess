<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhiteListIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // @brevis-ng: Retrieving IP whitelist from DB
        $config = DB::table('configs')->where('meta_key', '=', 'ip_whitelist')->first(['meta_value']);
        $ips_whitelist = explode(',', $config->meta_value);

        if ( ! in_array($request->ip(), $ips_whitelist) ) {

            abort(403, trans('auth.restricted', ['ip' => $request->ip()]));

        }

        return $next($request);
    }
}
