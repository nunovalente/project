<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function __construct()
	{
		$this->middleware('role_admin');
	}

	public function showAdministratorPanel() {
		$users = User::paginate(10);

		return view('adminpanel.index', compact('users'));
	}

}
