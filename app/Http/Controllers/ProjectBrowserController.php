<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Institution;
use App\User;
use App\Constants;

use Illuminate\Http\Request;

class ProjectBrowserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = Project::paginate(4);
		$roles = NULL;
		$user = NULL;

		if (! \Auth::guest()) {
			$user_id = \Auth::user()->id;
			$user = User::findOrFail($user_id);
			$roles = array(Constants::$admin_role, Constants::$editor_role, Constants::$author_role);
		}

		return view('projects.projectbrowser', compact('projects', 'user', 'roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$project = Project::findOrFail($id);
		$project_creator = User::findOrFail($project->created_by)->name;
		$institutions_involved_id = array();
		$roles = NULL;
		$user = NULL;

		foreach ($project->users as $user) {
			$institutions_involved_id[] = $user->institution_id;
		}

		$institutions_involved_name = array();

		foreach ($institutions_involved_id as $inst) {
			$aux_inst = Institution::findOrFail($inst);
			if (!in_array($aux_inst, $institutions_involved_name)) {
				$institutions_involved_name[] = $aux_inst;
			}
		}

		if (! \Auth::guest()) {
			$user_id = \Auth::user()->id;
			$user = User::findOrFail($user_id);
			$roles = array(Constants::$admin_role, Constants::$editor_role, Constants::$author_role);
		}

		return view('projects.projectdetail', compact('project', 'project_creator', 'institutions_involved_name', 'user', 'roles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
