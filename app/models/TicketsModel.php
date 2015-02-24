<?php
namespace Webxity;

use 
DB,
Eloquent; 

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

   protected $fillable = array('title', 'description', 'status', 'url' , 'project' , 'priority' , 'developer','owner_id' ,'due_date');

    public static function GetTickets($user_id)
    {
        $GetRowsByUserId = DB::table('tickets')->where('owner_id', $user_id)->get();
        if(count($GetRowsByUserId) > 0)
        {
            return $GetRowsByUserId;
        }
        else
        {
            return false;
        }   
    }
    
}