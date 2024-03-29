<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	public function users() {
		return $this->belongsToMany('App\User');
	}

	public function tags() {
		return $this->hasMany('App\Tag');
	}

	public function medias() {
		return $this->hasMany('App\Media');
	}

	public function institutions() {
		return $this->belongsToMany('App\Institution');
	}
}
