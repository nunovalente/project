<?php namespace App\Http\Middleware;

use Closure;
use App\Constants;

class RoleEditorMiddleware {

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
		
		if (!($request->user()->role == Constants::$editor_role)) {
			return redirect()->route('authlanding');
		}
		
		return $next($request);
	}

}
