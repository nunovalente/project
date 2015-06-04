<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Institution;

class InstitutionsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Institution::create(['name' => 'Instituto Politécnico de Leiria']);
		Institution::create(['name' => 'Instituto Politécnico de Santarém']);
		Institution::create(['name' => 'Instituto Politécnico de Lisboa']);
		Institution::create(['name' => 'Instituto Politécnico do Porto']);
		Institution::create(['name' => 'Instituto Politécnico de Tomar']);
		Institution::create(['name' => 'Instituto Politécnico de Beja']);
		Institution::create(['name' => 'Universidade de Lisboa']);
		Institution::create(['name' => 'Universidade de Coimbra']);
		Institution::create(['name' => 'Universidade de Porto']);
		Institution::create(['name' => 'Universidade de Aveiro']);
		Institution::create(['name' => 'Universidade do Minho']);
		Institution::create(['name' => 'Universidade do Algarve']);
		Institution::create(['name' => 'Universidade da Beira Interior']);
		Institution::create(['name' => 'Centro de Investigação em Informática e Comunicações']);
		Institution::create(['name' => 'INESC']);
		Institution::create(['name' => 'Instituto de Telecomunicações']);

	}

}
