<?php

namespace App\Http\Middleware;

use App\Exceptions\CommandNotFoundException;
use Closure;

class ExistsCommand
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


        // pgpdumpの有無　return 0正常値，それ以外異常値
        // hint https://github.com/kazu-yamamoto/pgpdump
        exec('pgpdump -v', $opt, $return_ver);
        if ($return_ver) throw new CommandNotFoundException('pgpdump');

        return $next($request);
    }
}
