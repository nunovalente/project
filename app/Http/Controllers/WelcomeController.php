<?php namespace App\Http\Controllers;

use App\Media;
use App\User;
use App\Project;

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
		$projectscarousel = Project::where('featured_until', '>', \Carbon\Carbon::now())->get();
		$recentprojects = Project::orderBy('updated_at', 'desc')->take(3)->get();
		$media = Media::all();
		$users = User::all();

		return view('projects.index', compact('users', 'projectscarousel', 'recentprojects', 'media'));
	}
}
