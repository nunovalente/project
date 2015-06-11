<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Project;
use App\Media;

class MediaTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$projectsCount = Project::all()->count();
		$usersCount = User::all()->count();

		$faker = Faker\Factory::create('pt_PT');
		for ($i=0; $i < 20; $i++) {

			$project = Project::find(rand(1,$projectsCount));
			// download and store the image
			$image = $faker->image;
			Storage::disk('local')->put('projects/'.$project->acronym.$i.'.jpg', File::get($image) );

			// create the media record
			$project = Media::create([
				'project_id' => $project->id,
				'title' => $faker->sentence(4),
				'description' => $faker->text(rand(10,200)),
				'alt' => $faker->sentence(4),
				'mime_type' => 'image/jpg',
				'int_file' => 'projects/'.$project->acronym.$i.'.jpg',
				'public_name' => $project->acronym.$i.'.jpg',
				'created_by' => rand(1, $usersCount),
				'approved_by' => rand(1, $usersCount),
				'state' => 1,
				]);

		}
	}

}
