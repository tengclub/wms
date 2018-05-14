<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\SysMenu;
use App\Lib\SysKey;

class Wap
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
		if(Session::has('wapUser')) {
			$user = session('wapUser');
			view()->share('user', $user); //角色信息
	       }else{
				Header("Location: " . url('wap/pub/login') . '?reUrl=' . URL::full());
				exit;
	       }
        return $next($request);
    }
}
