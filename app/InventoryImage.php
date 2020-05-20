<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryImage extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'inventory_images';
    protected $primaryKey = 'inventory_image_id';
	protected $fillable = [
    	'inventory_id',
    	'inventory_image_file_path',
    ];

}
