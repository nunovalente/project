<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

use App\User;
use App\Project;

use Illuminate\Http\Request;

class MailController extends Controller {

	public function sendContactRequest($contacteeid, $contacterid, $projectid)
	{
		$user_contactee = User::findOrFail($contacteeid);
		$user_contacter = User::findOrFail($contacterid);

		$project = Project::findOrFail($projectid);

		Mail::send('emails.contactrequest', ['projectname' => $project->name, 'contacteename' => $user_contactee->name, 'contactername' => $user_contacter->name, 'contacteremail' => $user_contacter->email],
			function ($m) use ($user_contactee, $project) {
				$m->to($user_contactee->email, $user_contactee->name)->subject('Contact Request: ' . $project->name);
			});

		return \Redirect::back()->with('message', 'Contact request submitted sucessfully');
	}

	public function sendAnonContactRequest(Request $request, $contacteeid, $projectid)
	{
		$user_contactee = User::findOrFail($contacteeid);
		$user_contacter_email = $request->input('email');

		$project = Project::findOrFail($projectid);

		Mail::send('emails.anoncontactrequest', ['projectname' => $project->name, 'contacteename' => $user_contactee->name, 'contacteremail' => $user_contacter_email],
			function ($m) use ($user_contactee, $project) {
				$m->to($user_contactee->email, $user_contactee->name)->subject('GUEST Contact Request: ' . $project->name);
			});

		return \Redirect::back()->with('message', 'Contact request submitted sucessfully');
	}

}
