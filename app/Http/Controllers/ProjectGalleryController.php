<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Media;
use App\Constants;

use Illuminate\Http\Request;

class ProjectGalleryController extends Controller {

	public function __construct()
	{
		$this->middleware('role_disabled');
	}

	public function showPhotos ($id)
	{
		$proj_name = Project::findOrFail($id)->name;
		$media = Media::where('project_id', '=', $id)->where('state', '=', Constants::$approved_state)->paginate(4);
		$gallery = 'Photo Gallery';

		return view('projects.projectgallery', compact('media', 'gallery', 'proj_name'));
	}

	public function showVideos ($id)
	{
		$proj_name = Project::findOrFail($id)->name;
		$media = Media::where('project_id', '=', $id)->where('state', '=', Constants::$approved_state)->paginate(4);
		$gallery = 'Video Gallery';

		return view('projects.projectgallery', compact('media', 'gallery', 'proj_name'));
	}
}
