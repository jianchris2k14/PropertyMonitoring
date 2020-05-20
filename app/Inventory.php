<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';
	protected $fillable = [
    	'inventory_item',
    	'inventory_description',
    ];

}
