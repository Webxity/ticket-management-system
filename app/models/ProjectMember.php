<?php

namespace Webxity;

use Eloquent; 

class ProjectMember extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_member';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = array('password', 'remember_token');

   protected $fillable = array('developer_email','project_id','project_owner_id') ;
    
 
}