<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Institution;

class UsersTableSeeder extends Seeder {

	/**
	 * !!! WARNING: this seeder downloads images to your box !!!
	 *
	 * @return void
	 */
	public function run()
	{
		$roles = [1, 2, 4];
		$institutionsCount = Institution::all()->count();

		$faker = Faker\Factory::create('pt_PT');
		for ($i=0; $i < 20; $i++) {
			$name = $faker->unique()->name();
			// create a username from the real name
			$username = \InternetFaker::usernameFromName($name);
			$email = $username.'@'.$faker->domainName;
			// create an alternative username in case we need it
			$altUsername = \InternetFaker::usernameFromName($name);

			// download and store the image
			$image = $faker->image;
			Storage::disk('local')->put($username.'.jpg', File::get($image) );

			// create the user record
			User::create([
				'name' => $name,
				'email' => $email,
				'password' => Hash::make($username),
				'institution_id' => rand(1, $institutionsCount),
				'position' => $faker->bs(),
				'photo_url' => $username.'.jpg',
				'profile_url' => $faker->url(),
				'role' => $roles[rand(0,2)],
				'alt_email' => rand(0,1)==0 ? ($altUsername.'@'.$faker->domainName) : null
				]);
		}
	}

}
