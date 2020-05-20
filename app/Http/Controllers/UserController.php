<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
    	$users = User::leftJoin('persons', 'users.person_id', '=', 'persons.person_id')
    		->leftJoin('user_roles', 'users.user_role_id', '=', 'user_roles.user_role_id')
    		->orderBy('user_id', 'DESC')->paginate(10);
    	return UserResource::collection($users);
    }

    public function search(Request $request){
    	$validator = Validator::make($request->all(), [
        	'keyword' 		=> 		'required|min:2'
        ]);
    	if(!$validator->fails()){
    		$keyword = $request->all();
	    	$users = User::where('username', 'like', '%'.$keyword['keyword'].'%')
	    		->orWhere('firstname', 'like', '%'.$keyword['keyword'].'%')
				->orWhere('lastname', 'like', '%'.$keyword['keyword'].'%')
				->leftJoin('persons', 'users.person_id', '=', 'persons.person_id')
	    		->orderBy('users.user_id', 'DESC')
	    		->paginate(10);
	    	return UserResource::collection($users);
    	}else{
    		return response()->json(['errors' => $validator->errors()]);
    	}
    }

    public function show($user_id){
    	$user = User::leftJoin('persons', 'users.person_id', '=', 'persons.person_id')
    		->leftJoin('user_roles', 'users.user_role_id', '=', 'user_roles.user_role_id')
    		->findOrFail($user_id);
    	return new UserResource($user);
	}

	public function store(Request $request){
		$validator = Validator::make($request->all(), [
        	 'username'			=>		'required|alpha_dash|min:6',
        	 'password'			=>		'required|alpha_dash|min:6',
        	 'confirm_password'	=>		'required|alpha_dash|min:6|same:password',
        	 'user_role_id'		=>		'required|numeric',
        	 'person_id'		=>		'required|numeric'
        ]);
        if(!$validator->fails()){
        	$data = $request->all();
        	$data['password'] = Hash::make($data['password']);
        	//Replace Null to Space
        	array_walk_recursive($data, function(&$item, $key){
				$item = $item == null ? '':$item;
			});
        	if($request->isMethod('put')){
				// Update User
				$user = User::findOrFail($request->user_id);
				$user->update($data);
				return new UserResource($user);
			}else{
				// Insert User
				$user_id = User::create($data);
				return new UserResource($user_id);
			}
        }else{
        	return response()->json(['errors' => $validator->errors()]);
        }
	}

	public function destroy($user_id){
		$user = User::findOrFail($user_id);
		if($user->delete())
			return new UserResource($user);
	}

}
