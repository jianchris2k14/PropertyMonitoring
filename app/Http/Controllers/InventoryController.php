<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Http\Resources\Inventory as InventoryResource;
use App\InventoryImage;
use App\Http\Resources\InventoryImage as InventoryImageResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    //	Inventory API
	public function index(){
    	$inventory = Inventory::orderBy('inventory_id', 'DESC')->paginate(10);
    	return InventoryResource::collection($inventory);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$keyword = $request->all();
	    	$inventory = Inventory::where('inventory_item', 'like', '%'.$keyword['keyword'].'%')
	    		->orWhere('inventory_description', 'like', '%'.$keyword['keyword'].'%')
				->orderBy('inventory_id', 'DESC')
	    		->paginate(10);
	    	return InventoryResource::collection($inventory);
    	}else{
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($inventory_id){
    	$inventory = Inventory::findOrFail($inventory_id);
    	return new InventoryResource($inventory);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
        	'inventory_item'			=>		'required',
			'inventory_description'		=> 		'',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
        	if($request->isMethod('put')){
				// Update Inventory
				$inventory = Inventory::findOrFail($request->inventory_id);
				$inventory->update($data);
				return new InventoryResource($inventory);
			}else{
				// Insert Inventory
				$inventory_id = Inventory::create($data);
				return new InventoryResource($inventory_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($inventory_id){
		$inventory = Inventory::findOrFail($inventory_id);
		if($inventory->delete())
			return new InventoryResource($inventory);
	}

	//	Inventory Images API
	public function show_image($inventory_id){
    	$inventory_image = InventoryImage::where('inventory_id', $inventory_id)->get();
    	return new InventoryImageResource($inventory_image);
	}

	public function store_image(Request $request){
		// Decode Image
		$exploded = explode(',', $request->inventory_image_file_path);
		$extension = strpos($exploded[0], 'jpeg') ? 'jpeg':'png';
		$decoded = base64_decode($exploded[1]);
		// Count all images based on inventory id
		$count = InventoryImage::where('inventory_id', $request->inventory_id)->count() + 1;
		// Set Filepath
		$filename = 'inventory_image_'. $request->inventory_id .'_'. $count .'.'. $extension;
		$filepath = public_path('uploads/').$filename;
		file_put_contents($filepath, $decoded);
		// Replace Inventory Image File Path
    	$data = $request->all();
    	$data['inventory_image_file_path'] = $filename;
    	// Insert Inventory Image
		$inventory_image_id = InventoryImage::create($data);
		return new InventoryImageResource($inventory_image_id);
	}

	public function destroy_image($inventory_image_id){
		$inventory_image = InventoryImage::findOrFail($inventory_image_id);
		if($inventory_image->delete()){
			unlink(public_path('uploads/').$inventory_image->inventory_image_file_path);
			return new InventoryImageResource($inventory_image);
		}
	}

	//	Inventory PDF View
	public function inventory_pdf($inventory_id){
		$inventory = Inventory::findOrFail($inventory_id);
		$inventory_stocks = \App\InventoryStock::where('inventory_id',  $inventory_id)->get();
		// Load View
		$pdf = \App::make('dompdf.wrapper');
		$data = [
			'inventory_item' =>  $inventory->inventory_item,
			'inventory_description' =>  $inventory->inventory_description,
			'inventory_stocks' => $inventory_stocks
		];
		$pdf->loadView('system.inventory.inventory_pdf', $data);
		return $pdf->stream('stock_card_'. sprintf("%04d", $inventory_id) .'.pdf');
	}

}