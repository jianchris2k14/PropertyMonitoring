<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'user_roles';
    protected $primaryKey = 'user_role_id';
	protected $fillable = [
    	'user_role'
    ];

}
