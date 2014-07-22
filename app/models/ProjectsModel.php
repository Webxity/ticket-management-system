<?php
namespace Webxity;

use Eloquent; 

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

   protected $fillable = array('project', 'description') ; 

}