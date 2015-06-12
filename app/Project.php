<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	public function users() {
		return $this->belongsToMany('App\User');
	}

	public function tags() {
		return $this->hasMany('App\Tag');
	}

}
