<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'inventory_stocks';
    protected $primaryKey = 'inventory_stock_id';
	protected $fillable = [
    	'inventory_id',
    	'inventory_stock_date',
    	'inventory_stock_source',
    	'inventory_stock_in',
    	'inventory_stock_out',
    	'inventory_stock_purpose',
    	'inventory_stock_withdrawn_by',
    	'inventory_stock_unit_location',
    ];

}
