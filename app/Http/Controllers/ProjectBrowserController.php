<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Institution;
use App\User;
use App\Constants;
use App\Comment;

use Illuminate\Http\Request;

class ProjectBrowserController extends Controller {

	public function __construct() {
		$this->middleware('role_disabled');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$term = $request->input('searchbox');
		$filter = $request->input('pbrowserfilter');
		$sort = $request->input('pbrowserorder');
		$projects = NULL;
		$roles = NULL;
		$user = NULL;
		$error_msg = false;

		if (! \Auth::guest()) {
			$user_id = \Auth::user()->id;
			$user = User::findOrFail($user_id);
			$roles = array(Constants::$admin_role, Constants::$editor_role, Constants::$author_role);
		}

		if (!isset($term) || $term == '') {
			if (isset($sort)) {
				$projects = $this->sortPaginate(4, $sort);
			}
			else {
				$projects = $this->sortPaginate(4, 'titleab');
			}
			
		}
		else{
			
			if (!isset($filter)) {
				$filter = 'name';
			}

			if (!isset($sort)) {
				$sort = 'titleab';
			}

			switch ($filter) {
				case 'name':
					$projects = $this->sortWherePaginate('name', 'LIKE', "%$term%", 4, $sort);
					break;

				case 'description':
					$projects = $this->sortWherePaginate('description', 'LIKE', "%$term%", 4, $sort);
					break;

				case 'responsible':
					$people = User::where('name', 'LIKE', '%' . $term . '%')->get();
					$p_id = array();
					foreach ($people as $person) {
						if (!in_array($person->id, $p_id)) {
							$p_id[] = $person->id;
						}

					}

					$projects = $this->sortWhereInPaginate('created_by', $p_id, 4, $sort);
					break;

				case 'type':
					$projects = $this->sortWherePaginate('type', 'LIKE', "%$term%", 4, $sort);
					break;

				case 'startdate':
					$projects = $this->sortWherePaginate('started_at', '=', $term, 4, $sort);
					break;

				case 'thematicarea':
					$projects = $this->sortWherePaginate('theme', 'LIKE', "%$term%", 4, $sort);
					break;
			}
		}

		if (count($projects) < 1) {
			$error_msg = true;
		}

		return view('projects.projectbrowser', compact('projects', 'user', 'roles', 'error_msg'));
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
		$project_creator_id = User::findOrFail($project->created_by)->id;
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

		return view('projects.projectdetail', compact('project', 'project_creator', 'project_creator_id', 'institutions_involved_name', 'user', 'roles'));
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

	public function submitComment(Request $request, $id) {
		$project = Project::findOrFail($id);
		$text = $request->input('comment');
		$msg;

		$user = NULL;

		if (! \Auth::guest()) {
			$user = \Auth::user();
		}

		if (!isset($user)) {
			/*UN-AUTHENTICATED*/
			$comment = new Comment;
			$comment->comment = $text;
			$comment->project_id = $project->id;
			$comment->state = Constants::$notapproved_state;
			$comment->save();

			$msg = 'Comment submitted successfully but pending approval';
		}
		else {
			/* AUTHENTICATED */
			$comment = new Comment;
			$comment->comment = $text;
			$comment->project_id = $project->id;
			$comment->user_name = $user->name;
			$comment->user_id = $user->id;

			if ($user->role == Constants::$editor_role || $user->role == Constants::$admin_role) {
				$comment->approved_by = $user->id;
				$comment->state = Constants::$approved_state;
				$msg = 'Comment submitted succesfully';
			} else {
				$comment->state = Constants::$notapproved_state;
				$msg = 'Comment submitted successfully but pending approval';
			}

			$comment->save();
		}		

		return \Redirect::back()->with('message', $msg);

	}

	private function sortPaginate($perPageAmmount, $sortKey) {
		$projects = NULL;
		switch ($sortKey) {

			case 'responsibleab':
				$projects = Project::orderBy('created_by', 'asc')->paginate($perPageAmmount);
				break;

			case 'titleab':
				$projects = Project::orderBy('name', 'asc')->paginate($perPageAmmount);
				break;

			case 'datemrf':
				$projects = Project::orderBy('started_at', 'desc')->paginate($perPageAmmount);
				break;
		}

		return $projects;
	}

	private function sortWhereInPaginate($whereInA, $whereInB, $perPageAmmount, $sortKey) {
		$projects = NULL;
		switch ($sortKey) {

			case 'responsibleab':
				$projects = Project::whereIn($whereInA, $whereInB)->orderBy('created_by', 'asc')->paginate($perPageAmmount);
				break;

			case 'titleab':
				$projects = Project::whereIn($whereInA, $whereInB)->orderBy('name', 'asc')->paginate($perPageAmmount);
				break;

			case 'datemrf':
				$projects = Project::whereIn($whereInA, $whereInB)->orderBy('started_at', 'desc')->paginate($perPageAmmount);
				break;
		}

		return $projects;
	}

	private function sortWherePaginate($whereA, $whereB, $whereC, $perPageAmmount, $sortKey) {
		$projects = NULL;
		switch ($sortKey) {

			case 'responsibleab':
				$projects = Project::where($whereA, $whereB, $whereC)->orderBy('created_by', 'asc')->paginate($perPageAmmount);
				break;

			case 'titleab':
				$projects = Project::where($whereA, $whereB, $whereC)->orderBy('name', 'asc')->paginate($perPageAmmount);
				break;

			case 'datemrf':
				$projects = Project::where($whereA, $whereB, $whereC)->orderBy('started_at', 'desc')->paginate($perPageAmmount);
				break;
		}

		return $projects;
	}

}
