<?php

namespace App\Http\Controllers;

use App\UserRole;
use App\Http\Resources\UserRole as UserRoleResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserRoleController extends Controller
{
    //
    public function index(){
    	$user_roles = UserRole::orderBy('user_role_id', 'DESC')->paginate(10);
    	return UserRoleResource::collection($user_roles);
    }

    public function show($user_role_id){
    	$user_role = UserRole::findOrFail($user_role_id);
    	return new UserRoleResource($user_role);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
        	'user_role'		=>		'required',
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	//Replace Null to Space
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
        	if($request->isMethod('put')){
				// Update User Role
				$user_role = UserRole::findOrFail($request->user_role_id);
				$user_role->update($data);
				return new UserRoleResource($user_role);
			}else{
				// Insert User Role
				$user_role_id = UserRole::create($data);
				return new UserRoleResource($user_role_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($user_role_id){
		$user_role = UserRole::findOrFail($user_role_id);
		if($user_role->delete())
			return new UserRoleResource($user_role);
	}

	public function selection(){
		$user_roles = UserRole::get();
    	return UserRoleResource::collection($user_roles);
	}
    
}