<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Http\Resources\Equipment as EquipmentResource;
use App\EquipmentImage;
use App\Http\Resources\EquipmentImage as EquipmentImageResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Log;

class EquipmentController extends Controller
{
    // Equipments API
    public function index(){
    	$equipments = Equipment::orderBy('equipment_id', 'DESC')->paginate(10);
    	return EquipmentResource::collection($equipments);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$keyword = $request->all();
	    	$equipments = Equipment::where('equipment_name', 'like', '%'.$keyword['keyword'].'%')
	    		->orWhere('equipment_model_no', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('equipment_serial_no', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('equipment_chassis_no', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('equipment_plate_no', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('equipment_engine_no', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('equipment_manufacturer', 'like', '%'.$keyword['keyword'].'%')
	    		->orderBy('equipment_id', 'DESC')
	    		->paginate(10);
	    	return EquipmentResource::collection($equipments);
    	}else{
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($equipment_id){
    	$equipment = Equipment::findOrFail($equipment_id);
    	return new EquipmentResource($equipment);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
        	'equipment_name'			=>		'required',
			'equipment_model_no'		=> 		'',
			'equipment_serial_no'		=>		'',
			'equipment_chassis_no'		=>		'',
			'equipment_plate_no'		=> 		'',
			'equipment_engine_no'		=>		'',
			'equipment_manufacturer'	=>		'',
			'equipment_date_purchased' 	=>		'required|date',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
        	if($request->isMethod('put')){
				// Update Equipment
				$equipment = Equipment::findOrFail($request->equipment_id);
				$equipment->update($data);
				return new EquipmentResource($equipment);
			}else{
				// Insert Equipment
				$equipment_id = Equipment::create($data);
				return new EquipmentResource($equipment_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($equipment_id){
		$equipment = Equipment::findOrFail($equipment_id);
		if($equipment->delete())
			return new EquipmentResource($equipment);
	}

	//	Equipment Images API
	public function show_image($equipment_id){
    	$equipment_image = EquipmentImage::where('equipment_id', $equipment_id)->get();
    	return new EquipmentImageResource($equipment_image);
	}

	public function store_image(Request $request){
		// Decode Image
		$exploded = explode(',', $request->equipment_image_file_path);
		$extension = strpos($exploded[0], 'jpeg') ? 'jpeg':'png';
		$decoded = base64_decode($exploded[1]);
		// Count all images based on equipment id
		$count = EquipmentImage::where('equipment_id', $request->equipment_id)->count() + 1;
		// Set Filepath
		$filename = 'equipment_image_'. $request->equipment_id .'_'. $count .'.'. $extension;
		$filepath = public_path('uploads/').$filename;
		file_put_contents($filepath, $decoded);
		// Replace Equipment Image File Path
    	$data = $request->all();
    	$data['equipment_image_file_path'] = $filename;
    	// Insert Equipment Image
		$equipment_image_id = EquipmentImage::create($data);
		return new EquipmentImageResource($equipment_image_id);
	}

	public function destroy_image($equipment_image_id){
		$equipment_image = EquipmentImage::findOrFail($equipment_image_id);
		if($equipment_image->delete()){
			unlink(public_path('uploads/').$equipment_image->equipment_image_file_path);
			return new EquipmentImageResource($equipment_image);
		}
	}

	//	Equipment PDF View
	public function equipment_pdf($equipment_id){
		$equipment = Equipment::findOrFail($equipment_id);
		$repair_job_orders = \App\RepairJobOrder::where('equipment_id',  $equipment_id)->get();
		// Load View
		$pdf = \App::make('dompdf.wrapper');
		$data = [
			'equipment' =>  $equipment,
			'repair_job_orders' => $repair_job_orders
		];
		$pdf->loadView('system.motorpol.equipment_pdf', $data);
		return $pdf->stream('equipment_history_record_'. sprintf("%04d", $equipment_id) .'.pdf');
	}

}