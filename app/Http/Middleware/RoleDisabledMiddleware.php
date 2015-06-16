<?php namespace App\Http\Middleware;

use Closure;
use App\Constants;

class RoleDisabledMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (\Auth::guest()) {
			return $next($request);
		}
		
		if (($request->user()->role == Constants::$disabled_role)) {
			return redirect('/disabled');
		}
		
		return $next($request);
	}

}
