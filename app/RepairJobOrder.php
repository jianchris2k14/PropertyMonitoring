<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairJobOrder extends Model
{
    //
    public $timestamps = false;
    
    protected $table = 'repair_job_orders';
    protected $primaryKey = 'repair_job_order_id';
	protected $fillable = [
		'equipment_id',
    	'repair_job_order_date_requested',
    	'repair_job_order_date_needed',
    	'repair_job_order_requestors_name',
    	'repair_job_order_date_breakdown',
    	'repair_job_order_for_maintenance_incharge_internal',
    	'repair_job_order_for_maintenance_incharge_external',
    	'repair_job_order_breakdown_type',
    	'repair_job_order_action_taken',
    	'repair_job_order_repair_results',
    	'repair_job_order_repair_started',
    	'repair_job_order_repair_ended',
    ];

}