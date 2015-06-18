<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Institution;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Support\Facades\Hash;
use App\Constants;
use App\Project;

use Illuminate\Http\Request;

class AdminController extends Controller {
	protected $registrar;
	public function __construct(Registrar $registrar)
	{
		$this->registrar = $registrar;
		$this->middleware('role_admin');
	}

	public function showAdministratorPanel(Request $request) {
		$users = NULL;
		$sort = $request->input('adminpanelorder');
		$term = $request->input('searchbox');
		$error_msg = false;

		if (!isset($term) || $term == '') {
			if (isset($sort)) {
				$users = $this->sortPaginate(10, $sort);
			}
			else {
				$users = $this->sortPaginate(10, 'az');
			}
			
		}
		else{
			$users = $this->sortWherePaginate('name', 'LIKE', "%$term%", 10, $sort);
		}

		return view('adminpanel.adminpanelindex', compact('users'));
	}

	public function showPasswordReset($id) {
		$user_id = $id;
		return view('adminpanel.adminpaneluserresetpassword', compact('user_id'));
	}

	public function showCreateUser() {
		$institutions = Institution::All();

		return view('adminpanel.adminpaneladduser', compact('institutions'));
	}

	public function showDeleteUser($id) {
		$user = User::findOrFail($id);
		$projects = Project::all();
		$error = false;

		return view('adminpanel.adminpanelconfirmdelete', compact('user', 'error'));
	}

	public function showEditUser($id) {
		$institutions = Institution::All();
		$user = User::findOrFail($id);

		return view('adminpanel.adminpaneledituser', compact('institutions', 'user'));
	}

	public function disableOrEnable($id) {
		$user = User::findOrFail($id);

		if ($user->flags == Constants::$disabled_flag) {
			$user->flags = Constants::$no_flag;
			$user->save();
			return redirect()->route('adminpanel');
		}

		$user->flags = Constants::$disabled_flag;
		$user->save();
		return redirect()->route('adminpanel');
	}

	public function delete($id)
	{ 
		$user = User::findOrFail($id);
		try {
			$user->delete();
			return redirect()->route('adminpanel');
		} catch (\Exception $e) {
			$error = true;
			return view('adminpanel.adminpanelconfirmdelete', compact('user', 'error'));
		}
		
	}

	public function edit($id, Request $request) {
		$user = User::findOrFail($id);
		$rules = ['name' => 'required|max:255',
				  'email' => 'required|email|max:255',
				  'alt_email' => 'email|max:255|different:email',
				  'password' => 'confirmed|min:6',
				  'institution' => 'required|exists:institutions,id',
				  'position' => 'required|max:255',
				  'profile_url' => 'max:255',
				  'status' => 'required'];

		if ($user->email != $request->get('email')) {
			$rules['email'] .= '|unique:users';
		}

		if ($request->input('password') != "") {
			$rules['password'] .= '|required';
		}

		$validator = \Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->alt_email = $request->input('alt_email');
		$user->institution_id = $request->input('institution');
		$user->position = $request->input('position');
		$user->profile_url = $request->input('profile_url');
		if ($request->input('password') != "") {
			$user->password = Hash::make($request->input('password'));
		}

		if ($request->input('status') == 'disabled') {
			$user->flags = Constants::$disabled_flag;
		}
		else {
			$user->flags = Constants::$no_flag;
		}

		$file = NULL;

		if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
			$file = $request->file('profile_pic');
			$extension = $file->getClientOriginalExtension();
			$file->move(storage_path() . '/app/profiles', $user->id . '.' . $extension);
			$user->photo_url = $user->id . '.' . $extension;
		}

		$user->save();

		return redirect()->route('adminpanel');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postCreateUser(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->registrar->create($request->all());

		return redirect()->route('adminpanel');
	}

	public function editPassword($id, Request $request) {
		$user = User::findOrFail($id);

		$validator = \Validator::make($request->all(),
			['password' => 'required|min:6|confirmed']
		);

		if ($validator->fails()) {
			$this->throwValidationException(
				$request, $validator
			);
		}

		$password = Hash::make($request->input('password'));
		$user->password = $password;
		$user->save();

		return redirect()->route('adminpanel');
	}

	private function sortWherePaginate($whereA, $whereB, $whereC, $perPageAmmount, $sortKey) {
		$users = NULL;
		switch ($sortKey) {

			case 'az':
				$users = User::where($whereA, $whereB, $whereC)->orderBy('name', 'asc')->paginate($perPageAmmount);
				break;

			case 'za':
				$users = User::where($whereA, $whereB, $whereC)->orderBy('name', 'desc')->paginate($perPageAmmount);
				break;
		}

		return $users;
	}

	private function sortPaginate($perPageAmmount, $sortKey) {
		$users = NULL;
		switch ($sortKey) {

			case 'az':
				$users = User::orderBy('name', 'asc')->paginate($perPageAmmount);
				break;

			case 'za':
				$users = User::orderBy('name', 'desc')->paginate($perPageAmmount);
				break;
		}

		return $users;
	}

}
