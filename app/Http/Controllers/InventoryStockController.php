<?php

namespace App\Http\Controllers;

use App\InventoryStock;
use App\Http\Resources\InventoryStock as InventoryStockResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryStockController extends Controller
{
    //
    public function index($inventory_id){
    	$inventory_stocks = InventoryStock::where('inventory_id',  $inventory_id)
    			->orderBy('inventory_stock_id', 'DESC')->paginate(10);
    	return InventoryStockResource::collection($inventory_stocks);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
    		'inventory_id'	=> 		'',
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$values = $request->all();
	    	$inventory_stocks = InventoryStock::where('inventory_id',  $values['inventory_id'])
	    		->where(function ($query) use ($values){
	    			$query->where('inventory_stock_source', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('inventory_stock_purpose', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('inventory_stock_withdrawn_by', 'like', '%'.$values['keyword'].'%')
	    				->orWhere('inventory_stock_unit_location', 'like', '%'.$values['keyword'].'%');
	    		})
	    		->orderBy('inventory_stock_id', 'DESC')
	    		->paginate(10);
	    	return InventoryStockResource::collection($inventory_stocks);
    	}else{
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($inventory_stock_id){
    	$inventory_stock = InventoryStock::findOrFail($inventory_stock_id);
    	return new InventoryStockResource($inventory_stock);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
			'inventory_id'						=>		'required',
        	'inventory_stock_date'				=>		'required|date',
			'inventory_stock_source'			=> 		'required',
			'inventory_stock_in'				=>		'',
			'inventory_stock_out'				=>		'',
			'inventory_stock_purpose'			=> 		'required',
			'inventory_stock_withdrawn_by'		=>		'required',
			'inventory_stock_unit_location'		=>		'',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space, Blank Integer to Zero
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
			$data['inventory_stock_in'] = empty($data['inventory_stock_in']) ? '0': $data['inventory_stock_in'];
			$data['inventory_stock_out'] = empty($data['inventory_stock_out']) ? '0': $data['inventory_stock_out'];
			//Check Method
        	if($request->isMethod('put')){
				// Update Inventory Stock
				$inventory_stock = InventoryStock::findOrFail($request->inventory_stock_id);
				$inventory_stock->update($data);
				return new InventoryStockResource($inventory_stock);
			}else{
				// Insert Inventory Stock
				$inventory_stock_id = InventoryStock::create($data);
				return new InventoryStockResource($inventory_stock_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($inventory_stock_id){
		$inventory_stock = InventoryStock::findOrFail($inventory_stock_id);
		if($inventory_stock->delete())
			return new InventoryStockResource($inventory_stock);
	}

	public function stock_balance($inventory_id){
		$stock_in = InventoryStock::where('inventory_id', $inventory_id)
			->sum('inventory_stock_in');
		$stock_out = InventoryStock::where('inventory_id', $inventory_id)
			->sum('inventory_stock_out');
		return response()->json(['stock_balance' => ($stock_in - $stock_out)]);
	}

}
