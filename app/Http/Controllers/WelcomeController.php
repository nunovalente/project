<?php namespace App\Http\Controllers;

use App\Media;
use App\User;
use App\Project;
use App\Constants;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$projectscarousel = Project::where('state', '=', Constants::$approved_state)->where('featured_until', '>', \Carbon\Carbon::now())->get();
		$recentprojects = Project::where('state', '=', Constants::$approved_state)->orderBy('updated_at', 'desc')->take(3)->get();
		$media = Media::where('state', '=', Constants::$approved_state)->get();
		$users = User::all();

		return view('projects.index', compact('users', 'projectscarousel', 'recentprojects', 'media'));
	}
}
