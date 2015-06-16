<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionProject extends Model {

	protected $table = 'institution_project';

	public function institution() {
		return $this->belongsTo('App\Institution');
	}

	public function project() {
		return $this->belongsTo('App\Project');
	}
}
