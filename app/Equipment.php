<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'equipments';
    protected $primaryKey = 'equipment_id';
	protected $fillable = [
    	'equipment_name',
    	'equipment_model_no',
    	'equipment_serial_no',
    	'equipment_chassis_no',
    	'equipment_plate_no',
    	'equipment_engine_no',
    	'equipment_manufacturer',
    	'equipment_date_purchased',
    ];

}
