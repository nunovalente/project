<?php namespace App\Http\Middleware;

use Closure;
use App\Constants;

class RoleAuthorMiddleware {

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
			return redirect()->route('guestlanding');
		}
		
		if (!($request->user()->role == Constants::$author_role)) {
			return redirect()->route('authlanding');
		}
		
		return $next($request);
	}

}
