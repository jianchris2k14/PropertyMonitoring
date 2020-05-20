<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentImage extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'equipment_images';
    protected $primaryKey = 'equipment_image_id';
	protected $fillable = [
    	'equipment_image_file_path',
    	'equipment_id',
    ];
    
}
