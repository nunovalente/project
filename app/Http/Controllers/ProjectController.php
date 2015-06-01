<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$projects = Project::all();
		return view('projects.index', compact('projects'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$project = ['title' => null,
		'description' => null,
		'homepage' => null];
		return view('projects.add', $project);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$title = $request->input('title');
		$description = $request->input('description');
		$homepage = $request->input('homepage');

		$validator = \Validator::make(
			['title' => $title,
			 'description' => $description,
			 'homepage' => $homepage],
			['title' => 'required|between:10,250|unique:projects',
			'description' => 'required|min:20',
			'homepage' => 'url']);

		if ($validator->fails()) {
			return redirect(route('projects.create'))->withErrors($validator)->withInput();
		}
		else {
			$project = new Project;
			$project->user()->associate(\Auth::user());
			$project->title = $title;
			$project->description = $description;
			if ($homepage) {
				$project->homepage = $homepage;
			}

			$project->save();

			return redirect(route('projects.index'))->with('message', 'Project created successfully');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$project = Project::find($id);
		return view('projects.edit', $project);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$project = Project::findOrFail($id);
		$rules = ['title' => 'required|between:10,250',
			'description' => 'required|min:20',
			'homepage' => 'url'];

		if ($project->title != $request->get('title')) {
			$rules['title'] .= '|unique:projects';
		}

		$validator = \Validator::make(
			['title' => $request->input('title'),
			 'description' => $request->input('description'),
			 'homepage' => $request->input('homepage')],
			$rules);

		if ($validator->fails()) {
			return redirect(route('projects.edit', [$id]))->withErrors($validator)->withInput();
		}
		else {
			
			$project->title = $request->input('title');
			$project->description = $request->input('description');
			$homepage = $request->input('homepage');
			if ($homepage) {
				$project->homepage = $homepage;
			}

			$project->save();

			return redirect(route('projects.index'))->with('message', 'Project saved successfully');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$project = Project::findOrFail($id);
		$project->delete();
		return redirect(route('projects.index'))->with('message', 'Project deleted successfully');
	}

}
