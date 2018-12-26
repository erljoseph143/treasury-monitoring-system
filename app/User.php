<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

   // protected $table = "users_data";
    protected $primaryKey = "user_id";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function usertype()
	{
		return $this->belongsTo('App\Usertype','privilege','user_type_id');
	}
	
	/**
	 * My code
	 */
	public function businessunit()
	{
		return $this->belongsTo('App\Businessunit','bunitid','unitid');
	}
	
	public function findForPassport($identifier) {
		return $this->orWhere('email', $identifier)->orWhere('username', $identifier)->first();
	}
}
