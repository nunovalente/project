<?php namespace App\Http\Controllers;

use App\User;
use App\Constants;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = \Auth::user()->id;
		$user = User::findOrFail($user_id);
		$role = $user->role;

		if ($role == Constants::$admin_role) {
			return redirect()->route('adminpanel');
		}

		$roles = array(Constants::$admin_role, Constants::$editor_role, Constants::$author_role);
		return view('projects.index', compact('user', 'roles'));

	}

	public function landingPage() {
		$user_id = \Auth::user()->id;
		$user = User::findOrFail($user_id);
		$roles = array(Constants::$admin_role, Constants::$editor_role, Constants::$author_role);

		return view('projects.index', compact('user', 'roles'));
	}

	public function disabledAccount() {
		return view('projects.disabledindex');
	}

}
