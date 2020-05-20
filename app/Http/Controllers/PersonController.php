<?php

namespace App\Http\Controllers;

use App\Person;
use App\Http\Resources\Person as PersonResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    //
    public function index(){
    	// Get All Persons
    	$persons = Person::orderBy('person_id', 'DESC')->paginate(10);
    	// Return Collection of Persons
    	return PersonResource::collection($persons);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$keyword = $request->all();
	    	$persons = Person::where('firstname', 'like', '%'.$keyword['keyword'].'%')
	    		->orWhere('middlename', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('lastname', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('email_address', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('address', 'like', '%'.$keyword['keyword'].'%')
	    		->orderBy('person_id', 'DESC')
	    		->paginate(10);
	    	//Return Collection of Persons
	    	return PersonResource::collection($persons);
    	}else{
    		//Return Validation Errors
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($person_id){
    	// Get Single Person
    	$person = Person::findOrFail($person_id);
    	// Return Single Person
		return new PersonResource($person);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
        	'firstname'		=>		'required',
			'middlename'	=> 		'',
			'lastname'		=>		'required',
			'gender'		=>		'required',
			'birthdate'		=> 		'required',
			'address'		=>		'',
			'mobile'		=>		'required|numeric',
			'email_address' =>		'required|email',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
        	if($request->isMethod('put')){
				// Update Person
				$person = Person::findOrFail($request->person_id);
				$person->update($data);
				return new PersonResource($person);
			}else{
				// Insert Person
				$person_id = Person::create($data);
				return new PersonResource($person_id);
			}
        }else{
        	//Return Validation Errors
    		return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($person_id){
		// Find Person
		$person = Person::findOrFail($person_id);
		// Delete Person
		if($person->delete())
			return new PersonResource($person);
	}

	public function selection(){
		$persons = Person::select('person_id', 'firstname', 'middlename', 'lastname')->get();
    	return PersonResource::collection($persons);
	}

}