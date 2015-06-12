<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model {

	protected $table = 'project_tag';

	public function project()
	{
		return $this->belongsTo('App\Project');
	}

	public function tag()
	{
		return $this->belongsTo('App\Tag');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'added_by');
	}

	public function editor()
	{
		return $this->belongsTo('App\User', 'approved_by');
	}

}
