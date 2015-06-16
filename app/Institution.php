<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model {

	public $timestamps = false;

	public function users() {
		return $this->hasMany('App\User');
	}

	public function projects() {
		return $this->hasMany('App\Project');
	}
}
