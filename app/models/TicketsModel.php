<?php
namespace Webxity;

use Eloquent; 

class TicketsModel extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = array('password', 'remember_token');

   protected $fillable = array('title', 'description', 'status', 'url' , 'project' , 'priority');

}