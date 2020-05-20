<?php

namespace App\Http\Controllers;

use App\RepairJobOrder;
use App\Http\Resources\RepairJobOrder as RepairJobOrderResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairJobOrderController extends Controller
{
    //
	public function index($equipment_id){
    	$repair_job_orders = RepairJobOrder::where('equipment_id',  $equipment_id)
    			->orderBy('repair_job_order_id', 'DESC')->paginate(10);
    	return RepairJobOrderResource::collection($repair_job_orders);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
    		'equipment_id'	=> 		'',
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$values = $request->all();
	    	$repair_job_orders = RepairJobOrder::where('equipment_id',  $values['equipment_id'])
	    		->where(function ($query) use ($values){
	    			$query->where('repair_job_order_requestors_name', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('repair_job_order_breakdown_type', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('repair_job_order_action_taken', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('repair_job_order_repair_results', 'like', '%'.$values['keyword'].'%');
	    		})
	    		->orderBy('repair_job_order_id', 'DESC')
	    		->paginate(10);
	    	return RepairJobOrderResource::collection($repair_job_orders);
    	}else{
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($repair_job_order_id){
    	$repair_job_order = RepairJobOrder::findOrFail($repair_job_order_id);
    	return new RepairJobOrderResource($repair_job_order);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
			'equipment_id'											=>		'required',
        	'repair_job_order_date_requested'						=>		'required|date',
			'repair_job_order_date_needed'							=> 		'',
			'repair_job_order_requestors_name'						=>		'required',
			'repair_job_order_date_breakdown'						=>		'',
			'repair_job_order_for_maintenance_incharge_internal'	=> 		'',
			'repair_job_order_for_maintenance_incharge_external'	=>		'',
			'repair_job_order_breakdown_type'						=>		'',
			'repair_job_order_action_taken' 						=>		'',
			'repair_job_order_repair_results'						=>		'',
			'repair_job_order_repair_started' 						=>		'',
			'repair_job_order_repair_ended' 						=>		'',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space, Blank Date to Proper Date
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
			$data['repair_job_order_date_needed'] = empty($data['repair_job_order_date_needed']) ? '0001-01-01': $data['repair_job_order_date_needed'];
			$data['repair_job_order_date_breakdown'] = empty($data['repair_job_order_date_breakdown']) ? '0001-01-01': $data['repair_job_order_date_breakdown'];
			$data['repair_job_order_repair_started'] = empty($data['repair_job_order_repair_started']) ? '0001-01-01': $data['repair_job_order_repair_started'];
			$data['repair_job_order_repair_ended'] = empty($data['repair_job_order_repair_ended']) ? '0001-01-01': $data['repair_job_order_repair_ended'];
			//Check Method
        	if($request->isMethod('put')){
				// Update Repair Job Order
				$repair_job_order = RepairJobOrder::findOrFail($request->repair_job_order_id);
				$repair_job_order->update($data);
				return new RepairJobOrderResource($repair_job_order);
			}else{
				// Insert Repair Job Order
				$repair_job_order_id = RepairJobOrder::create($data);
				return new RepairJobOrderResource($repair_job_order_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($repair_job_order_id){
		$repair_job_order = RepairJobOrder::findOrFail($repair_job_order_id);
		if($repair_job_order->delete())
			return new RepairJobOrderResource($repair_job_order);
	}

	//	Repair Job Order PDF View
	public function repair_job_order_pdf($repair_job_order_id){
		$repair_job_order = RepairJobOrder::findOrFail($repair_job_order_id);
		//$repair_job_orders = \App\RepairJobOrder::where('repair_job_order_id',  $repair_job_order_id)->get();
		// Load View
		$pdf = \App::make('dompdf.wrapper');
		$data = [
			'repair_job_order' =>  $repair_job_order,
		// /	'repair_job_orders' => $repair_job_orders
		];
		$pdf->loadView('system.motorpol.repair_job_order_pdf', $data);
		return $pdf->stream('repair_job_order_'. sprintf("%04d", $repair_job_order_id) .'.pdf');
	}
    
}