<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		/*return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'institution' => 'required|exists:institutions,id',
		]);*/
		
		return Validator::make($data, ['name' => 'required|max:255',
				  'email' => 'required|email|max:255',
				  'alt_email' => 'email|max:255|different:email',
				  'password' => 'required|confirmed|min:6',
				  'institution' => 'required|exists:institutions,id',
				  'position' => 'required|max:255',
				  'profile_url' => 'max:255']);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		if ($data['alt_email'] == '') {
			$data['alt_email'] = NULL;
		}
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'institution_id' => $data['institution'],
			'alt_email' => $data['alt_email'],
			'position' => $data['position'],
			'profile_url' => $data['profile_url'],
			'role' => \App\Constants::$author_role,
		]);
	}

}
