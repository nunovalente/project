<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Constants extends Model {

	public static $admin_role = 4;
	public static $editor_role = 2;
	public static $author_role = 1;
	public static $no_role = 0;
}
