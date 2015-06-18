<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Project;
use App\Comment;
use App\Media;
use App\Constants;
use App\User;

class AuthorController extends Controller {

	public function __construct()
	{
		$this->middleware('role_author');
	}

	public function showAuthorPanel(Request $request) {
		$user = \Auth::user();

		$pending_comments = Comment::where('state', '=', Constants::$notapproved_state)->where('user_id', '=', $user->id)->get();
		$pending_media = Media::where('state', '=', Constants::$notapproved_state)->where('created_by', '=', $user->id)->get();
		$pending_projects = Project::where('state', '=', Constants::$notapproved_state)->where('created_by', '=', $user->id)->get();

		return view('adminpanel.adminpanelauthorpending', compact('pending_projects'));
	}
}
