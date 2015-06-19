<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Comment;
use App\Media;
use App\Project;
use App\Constants;
use App\User;

class EditorController extends Controller {

	public function __construct()
	{
		$this->middleware('role_editor');
	}

	public function showEditorPanel()
	{

		$pending_comments = Comment::where('state', '=', Constants::$notapproved_state)->get();
		$pending_media = Media::where('state', '=', Constants::$notapproved_state)->get();
		$pending_projects = Project::where('state', '=', Constants::$notapproved_state)->get();

		return view('adminpanel.adminpaneleditorpending', compact('pending_projects', 'pending_media', 'pending_comments'));
	}

	public function showEditorPanelApproved()
	{
		$approved_comments = Comment::where('state', '=', Constants::$approved_state)->get();
		$approved_media = Media::where('state', '=', Constants::$approved_state)->get();
		$approved_projects = Project::where('state', '=', Constants::$approved_state)->get();

		return view('adminpanel.adminpaneleditorapproved', compact('approved_projects', 'approved_media', 'approved_comments'));
	}

	public function showEditorPanelRefused()
	{
		$refused_comments = Comment::where('state', '=', Constants::$refused_state)->get();
		$refused_media = Media::where('state', '=', Constants::$refused_state)->get();
		$refused_projects = Project::where('state', '=', Constants::$refused_state)->get();

		return view('adminpanel.adminpaneleditorrefused', compact('refused_projects', 'refused_media', 'refused_comments'));
	}

	public function showApproveProject($id)
	{
		$project = Project::findOrFail($id);

		return view('adminpanel.adminpaneleditorapproveproject', compact('project'));
	}

	public function showRefuseProject($id)
	{
		$project = Project::findOrFail($id);

		return view('adminpanel.adminpaneleditorrefuseproject', compact('project'));
	}

	public function showRefuseMedia($id)
	{
		$media = Media::findOrFail($id);

		return view('adminpanel.adminpaneleditorrefusemedia', compact('media'));
	}

	public function showRefuseComment($id)
	{
		$comment = Comment::findOrFail($id);

		return view('adminpanel.adminpaneleditorrefusecomment', compact('comment'));
	}

	public function showEditProject($id)
	{
		$project = Project::findOrFail($id);
		$mails = array();

		foreach ($project->users as $u)
		{
			$mails[] = $u->email;
		}

		return view('adminpanel.adminpaneleditoreditproject', compact('project', 'mails'));
	}

	public function removeComment($id)
	{
		$comment = Comment::findOrFail($id);

		$comment->delete();

		return \Redirect::back();
	}

	public function removeProject($id)
	{
		$project = Project::findOrFail($id);

		$comments = Comment::where('project_id', '=', $project->id)->get();
		$media = Media::where('project_id', '=', $project->id)->get();

		foreach ($comments as $c)
		{
			$c->delete();
		}

		foreach ($media as $m)
		{
			$m->delete();
		}

		foreach ($project->institutions as $inst)
		{
			$project->institutions()->detach($inst->id);
		}

		foreach ($project->users as $user)
		{
			$project->users()->detach($user->id);
		}

		$project->delete();

		return \Redirect::back();
	}

	public function removeMedia($id)
	{
		$media = Media::findOrFail($id);

		$media->delete();

		return \Redirect::back();
	}

	public function editProject(Request $request, $id)
	{
		$project = Project::findOrFail($id);
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

		if (isset($used_software) && $used_software != '')
		{
			$indicated_software = true;
		}

		if (isset($used_hardware) && $used_hardware != '')
		{
			$indicated_hardware = true;
		}

		if (isset($observations) && $observations != '')
		{
			$indicated_observations = true;
		}

		if (isset($keywords) && $keywords != '')
		{
			$indicated_keywords = true;
		}

		if (isset($elements_emails_string) && $elements_emails_string != '')
		{
			$elements_emails_string = str_replace(' ', '', $elements_emails_string);
			$elements_emails_array = explode(',', $elements_emails_string);
	
			$mails = array();
			$mail_user_ids = array();

	
			foreach ($elements_emails_array as $elem_email)
			{
				$matched_users = User::where('email', '=', $elem_email)->get();
	
				foreach ($matched_users as $m_u)
				{
					$mails[] = $m_u->email;
					$mail_user_ids[] = $m_u->id;
				}
	
			}
	
			if (!isset($mails) || count($mails) != count($elements_emails_array))
			{
				if (isset($mails))
				{
					$wrong_emails = "";
					foreach ($elements_emails_array as $elem_email)
					{
						if (!in_array($elem_email, $mails))
						{
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

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$users = User::all();
		$user = NULL;
		foreach ($users as $u)
		{
			if ($u->email == $resp_email)
			{
				$user = $u;
			}
		}

		$project->name = $name;
		$project->acronym = $acronym;
		$project->type = $type;
		$project->created_by = $user->id;
		$project->updated_by = $user->id;
		$project->description = $description;
		$project->theme = $thematic_area;
		$project->started_at = $startdate;

		foreach ($project->users as $u_aux)
		{
			$project->users()->detach($u_aux->id);
		}

		foreach ($project->institutions as $i_aux)
		{
			$project->institutions()->detach($i_aux->id);
		}

		if ($indicated_keywords == true)
		{
			$project->keywords = $keywords;
		}

		if ($indicated_observations == true)
		{
			$project->observations = $observations;
		}

		if ($indicated_software == true)
		{
			$project->used_software = $used_software;
		}

		if ($indicated_hardware == true)
		{
			$project->used_hardware = $used_hardware;
		}

		if (isset($conclusiondate) && $conclusiondate != '')
		{
			$project->finished_at = $conclusiondate;
		}

		$project->save();

		if ($indicated_elements == true)
		{
			$project->users()->attach($mail_user_ids);
			$all_users = User::all();
			$existent_ids = array();
			foreach ($all_users as $u)
			{
				if (in_array($u->id, $mail_user_ids) && !in_array($u->institution_id, $existent_ids))
				{
					$project->institutions()->attach($u->institution_id);
					$existent_ids[] = $u->institution_id;
				}
			}
		}

		return redirect()->route('editorpanelapproved');
	}

	public function approveComment($id)
	{
		$comment = Comment::findOrFail($id);

		$comment->state = Constants::$approved_state;
		$comment->approved_by = \Auth::user()->id;;
		$comment->save();

		return redirect()->route('editorpanel');
	}

	public function refuseComment(Request $request, $id)
	{
		$c = Comment::findOrFail($id);
		$reason = $request->input('reason');

		$rules = ['reason' => 'max:255'];

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$c->state = Constants::$refused_state;

		if (isset($reason) && $reason != '')
		{
			$c->refusal_msg = $reason;
		}

		$c->save();

		return redirect()->route('editorpanel');
	}

	public function refuseMedia(Request $request, $id)
	{
		$m = Media::findOrFail($id);
		$reason = $request->input('reason');

		$rules = ['reason' => 'max:255'];

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$m->state = Constants::$refused_state;

		if (isset($reason) && $reason != '')
		{
			$m->refusal_msg = $reason;
		}

		$m->save();

		return redirect()->route('editorpanel');
	}

	public function approveMedia($id)
	{
		$m = Media::findOrFail($id);

		$m->state = Constants::$approved_state;
		$m->approved_by = \Auth::user()->id;
		$m->save();

		return redirect()->route('editorpanel');
	}

	public function refuseProject(Request $request, $id)
	{
		$reason = $request->input('reason');
		$project = Project::findOrFail($id);

		$rules = ['reason' => 'max:255'];

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$project->state = Constants::$refused_state;

		if (isset($reason) && $reason != '')
		{
			$project->refusal_msg = $reason;
		}

		$project->save();

		return redirect()->route('editorpanel');

	}

	public function approveProject($id)
	{
		$project = Project::findOrFail($id);

		foreach ($project->medias as $m)
		{
			$m->state = Constants::$approved_state;
			$m->approved_by = \Auth::user()->id;
			$m->save();
		}

		$project->state = Constants::$approved_state;
		$project->approved_by = \Auth::user()->id;
		$project->save();

		return redirect()->route('editorpanel');
	}

}
