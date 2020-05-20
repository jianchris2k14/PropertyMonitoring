<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'persons';
    protected $primaryKey = 'person_id';
	protected $fillable = [
    	'firstname',
    	'middlename',
    	'lastname',
    	'gender',
    	'birthdate',
    	'address',
    	'mobile',
    	'email_address',
    	'password_code'
    ];
    
}
