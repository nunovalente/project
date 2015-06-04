<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Tag;

class TagsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Tag::create(['tag' => 'Web']);
		Tag::create(['tag' => 'Engenharia de Software']);
		Tag::create(['tag' => 'Computação Móvel']);
		Tag::create(['tag' => 'Cloud']);
		Tag::create(['tag' => 'Segurança']);
		Tag::create(['tag' => 'Programação']);
		Tag::create(['tag' => 'Investigação']);
		Tag::create(['tag' => 'Licenciatura']);
		Tag::create(['tag' => 'Mestrado']);
		Tag::create(['tag' => 'Curso de Especialização Tecnológica']);

	}

}
