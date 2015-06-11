<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('InstitutionsTableSeeder');
		$this->command->info('Institutions table seeded.');

		$this->call('TagsTableSeeder');
		$this->command->info('Tags table seeded.');

		$this->call('UsersTableSeeder');
		$this->command->info('Users table seeded.');

		$this->call('ProjectsTableSeeder');
		$this->command->info('Projects table seeded.');

		$this->call('MediaTableSeeder');
		$this->command->info('Media table seeded.');
	}

}
