<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function __construct()
	{
		$this->middleware('role_admin');
	}

	public function showAdministratorPanel() {
		return view('charisma.index');
	}

}
