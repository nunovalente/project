<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Institution;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function __construct()
	{
		$this->middleware('role_admin');
	}

	public function showAdministratorPanel() {
		$users = User::paginate(10);

		return view('adminpanel.adminpanelindex', compact('users'));
	}

	public function showCreateUser() {
		$institutions = Institution::All();

		return view('adminpanel.adminpaneladduser', compact('institutions'));
	}

}
