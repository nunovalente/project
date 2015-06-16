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
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = \Auth::user()->id;
		$role = User::findOrFail($user_id)->role;

		if ($role == Constants::$admin_role) {
			return redirect()->route('adminpanel');
		}

		return view('projects.index');

	}

	public function landingPage() {
		return view('projects.index');
	}

}
