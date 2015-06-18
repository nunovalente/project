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

	public function showCreateProject() {

		return view('adminpanel.adminpanelauthoraddproject');
	}

	public function submitCreatedProject(Request $request) {
		$name = $request->input('name');
		$resp_email = $request->input('responsibleemail');
		$acronym = $request->input('acronym');
		$type = $request->input('type');
		$description = $request->input('description');
		$thematic_area = $request->input('thematicarea');
		$elements_emails_string = $request->input('teamelements');
		$startdate = $request->input('startdate');
		$conclusiondate = $request->input('conclusiondate');
		$keywords = $request->input('keywords');
		$used_software = $request->input('software');
		$used_hardware = $request->input('hardware');
		$observations = $request->input('observations');
		$indicated_elements = false;
		$indicated_keywords = false;
		$indicated_software = false;
		$indicated_hardware = false;
		$indicated_observations = false;

		if (isset($used_software) && $used_software != '') {
			$indicated_software = true;
		}

		if (isset($used_hardware) && $used_hardware != '') {
			$indicated_hardware = true;
		}

		if (isset($observations) && $observations != '') {
			$indicated_observations = true;
		}

		if (isset($keywords) && $keywords != '') {
			$indicated_keywords = true;
		}

		if (isset($elements_emails_string) && $elements_emails_string != '') {
			$elements_emails_string = str_replace(' ', '', $elements_emails_string);
			$elements_emails_array = explode(',', $elements_emails_string);
	
			$mails = array();
			$mail_user_ids = array();
	
			foreach ($elements_emails_array as $elem_email) {
				$matched_users = User::where('email', '=', $elem_email)->get();
	
				foreach ($matched_users as $m_u) {
					$mails[] = $m_u->email;
					$mail_user_ids[] = $m_u->id;
				}
	
			}
	
			if (!isset($mails) || count($mails) != count($elements_emails_array)) {
				if (isset($mails)) {
					$wrong_emails = "";
					foreach ($elements_emails_array as $elem_email) {
						if (!in_array($elem_email, $mails)) {
							$wrong_emails .= ($elem_email . ', ');
						}
					}
					return \Redirect::back()->with('mailerror', "The following team elements emails are invalid: " . $wrong_emails);
				}
				return \Redirect::back()->with('mailerror', 'None of the team elements emails are valid in the platform');
			}

			$indicated_elements = true;
		}

		$rules = ['name' => 'required|max:255',
				  'acronym' => 'max:255',
				  'responsibleemail' => 'email|max:255|exists:users,email',
				  'type' => 'required|max:255',
				  'description' => 'required',
				  'thematicarea' => 'required|max:255',
				  'startdate' => 'required|date_format:Y-n-j',
				  'conclusiondate' => 'date_format:Y-n-j'];

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$users = User::all();
		$user = NULL;
		foreach ($users as $u) {
			if ($u->email == $resp_email) {
				$user = $u;
			}
		}

		$project = new Project;
		$project->name = $name;
		$project->acronym = $acronym;
		$project->type = $type;
		$project->created_by = $user->id;
		$project->updated_by = $user->id;
		$project->description = $description;
		$project->theme = $thematic_area;
		$project->started_at = $startdate;

		if ($indicated_keywords == true) {
			$project->keywords = $keywords;
		}

		if ($indicated_observations == true) {
			$project->observations = $observations;
		}

		if ($indicated_software == true) {
			$project->used_software = $used_software;
		}

		if ($indicated_hardware == true) {
			$project->used_hardware = $used_hardware;
		}

		if (isset($conclusiondate) && $conclusiondate != '') {
			$project->finished_at = $conclusiondate;
		}

		$project->save();

		if ($indicated_elements == true) {
			$project->users()->attach($mail_user_ids);
			$all_users = User::all();
			foreach ($all_users as $u) {
				if (in_array($u->id, $mail_user_ids)) {
					$project->institutions()->attach($u->institution_id);
				}
			}
		}

		return redirect()->route('authorpanel');
	}

	public function deletePendingProject($id) {
		$project = Project::findOrFail($id);

		foreach ($project->users as $user) {
			$project->users()->detach($user->id);
		}

		foreach ($project->institutions as $inst) {
			$project->institutions()->detach($inst->id);
		}

		$project->delete();

		return \Redirect::back();
	}
}
