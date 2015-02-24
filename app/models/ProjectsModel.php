<?php

namespace Webxity;

use 
DB,
Eloquent;

class ProjectsModel extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = array('password', 'remember_token');

   protected $fillable = array('project', 'description','user_id'); 
	
   public static function GetProjectrow($id)
   {
   		$row = DB::table('projects')->where('id', $id)->first();
		if(count($row) > 0)
		{
			return $row;
   		}
		else
		{
			return false;
		}		
   }		

}