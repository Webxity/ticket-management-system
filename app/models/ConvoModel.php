<?php
namespace Webxity;

use Eloquent; 

class ConvoModel extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'conversations';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = array('password', 'remember_token');

   protected $fillable = array('message', 'user_name' ,'user_id' , 'ticket_id' ,  'user_id');

}