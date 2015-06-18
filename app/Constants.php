<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Constants extends Model {

	/* ROLES */

	public static $admin_role = 4;
	public static $editor_role = 2;
	public static $author_role = 1;
	public static $no_role = 0;

	/* FLAGS */

	public static $disabled_flag = 1;
	public static $no_flag = 0;

	/* STATES */

	public static $approved_state = 1;
	public static $notapproved_state = 0;
}
