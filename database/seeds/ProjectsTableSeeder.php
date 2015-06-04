<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Institution;
use App\Project;
use App\Tag;

class ProjectsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$institutionsCount = Institution::all()->count();
		$usersCount = User::all()->count();
		$tagsCount = Tag::all()->count();

		$faker = Faker\Factory::create('pt_PT');
		for ($i=0; $i < 5; $i++) {
			$name = $faker->unique->catchPhrase;
			$startDate = $faker->dateTimeThisDecade;
			$endDate = $faker->optional->dateTimeBetween($startDate);
			$featuredUntil = new DateTime('today + '.rand(500,1000).' days');

			// create the user record
			$project = Project::create([
				'name' => $name,
				'acronym' => $this->createAcronym($name),
				'description' => $faker->text(rand(200,400)),
				'type' => $faker->sentence(4),
				'theme' => $faker->word,
				'keywords' => implode(', ', $faker->words(rand(2,5))),
				'started_at' => $startDate,
				'finished_at' => $endDate,
				'featured_until' => rand(1,2)==1?$featuredUntil:null,
				'used_software' => $faker->optional->userAgent,
				'observations' => $faker->optional->text(rand(20,100)),
				'created_by' => rand(1, $usersCount),
				'updated_by' => rand(1, $usersCount),
				]);

				// 'state'
				// 'refusal_msg'

			// add people to the project
			for ($personI = 0 ; $personI < rand(1,5) ; $personI++) {
				do {
					$userID = rand(1,$usersCount);
				} while ($project->users()->find($userID)!=null);

				$project->users()->attach($userID);
			}

		}
	}

	private function createAcronym($name)
	{
		$acronym = "";
		$words = explode(' ', $name);
		foreach ($words as $word) {
			if (preg_match('/^[aeiou]|\d+/i', $word, $matches)) {
				$acronym = $acronym.$matches[0];
			}
			elseif (preg_match('/^.[aeiou]/i', $word, $matches)) {
				$acronym = $acronym.$matches[0];
			}
			else {
				$acronym = $acronym.$word[0];
			}
		}
		return $acronym;
	}

}
