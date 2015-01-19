<?php
namespace Webxity;

use Eloquent; 

class LoginHistory extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'login_history';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = array('password', 'remember_token');

   protected $fillable = array('user_id', 'login_time', 'logout_time');

}