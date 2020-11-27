<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use CRUDBooster;
class FrontendRequestLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!CRUDBooster::myId() ) {
            Log::debug('FrontendRequestLogin /dangnhap?redirect_url = '.$request->url());
            return redirect('/dangnhap?redirect_url='.$request->url())->with('message', 'Bạn cần phải đăng nhập để tiếp tục.');
        }

        return $next($request);
    }
}
