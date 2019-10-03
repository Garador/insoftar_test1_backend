<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Validator;
use DB;

class user_admin_controller extends BaseController
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skip = $request->query("skip", 0);
        $limit = $request->query("limit", 5);
        

        $users = User::offset($skip)->take($limit)->get();
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        //'name', 'email', 'first_name','last_name','ci','phone'
        $validator = Validator::make($input, [
            'email' => 'bail|required|email',
            'first_name' => array(
                'bail', 'required',
                'regex:/^[a-z ]{1,60}$/i'
            ),
            'last_name' => array(
                'bail', 'required',
                'regex:/^[a-z ]{1,60}$/i'
            ),
            'ci' => array(
                'bail','required',
                'regex:/^[\d]{6,10}$/'
            ),
            'phone' => array(
                'bail', 'required',
                'regex:/^[\d]{8,15}$/'
            )
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $records_count = User::where('email',$input['email'])->count();
        if($records_count > 0){
            return $this->sendError('Validation Error.', ["error" => "UNIQUE_FIELD_COLLIDED", "field" => 'email', "count" => $records_count], 409);
        }

        $records_count = User::where('ci',$input['ci'])->count();
        if($records_count){
            return $this->sendError('Validation Error.', ["error" => "UNIQUE_FIELD_COLLIDED", "field" => 'ci', "count" => $records_count], 409);
        }


        $user = User::create($input);
        return $this->sendResponse($user->toArray(), 'User created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.', null, 404);
        }
        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'email' => 'bail|nullable|email',
            'first_name' => array(
                'bail', 'required',
                'regex:/^[a-z ]{1,60}$/i'
            ),
            'last_name' => array(
                'bail', 'required',
                'regex:/^[a-z ]{1,60}$/i'
            ),
            'ci' => array(
                'bail','required',
                'regex:/^[\d]{6,10}$/'
            ),
            'phone' => array(
                'bail', 'required',
                'regex:/^[\d]{8,15}$/'
            )
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        DB::enableQueryLog();

        $records_count = User::where(
            [
                ["id", "<>", $user->id],
                ["email", "=", $input['email']],
            ]
        )->count();
        if($records_count > 0){
            return $this->sendError('Validation Error.', ["error" => "UNIQUE_FIELD_COLLIDED", "field" => 'email', "count" => $records_count], 409);
        }
        $records_count = User::where(
            [
                ["id", "<>", $user->id],
                ["ci", "=", $input['ci']],
            ]
        )->count();
        if($records_count){
            return $this->sendError('Validation Error.', ["error" => "UNIQUE_FIELD_COLLIDED", "field" => 'ci', "count" => $records_count], 409);
        }

        $edited = false;
        if($input['email']){
            $user->email =  $input['email'];
            $edited = true;
        }
        if($input['first_name']){
            $user->first_name =  $input['first_name'];
            $edited = true;
        }
        if($input['last_name']){
            $user->last_name =  $input['last_name'];
            $edited = true;
        }
        if($input['ci']){
            $user->ci =  $input['ci'];
            $edited = true;
        }
        if($input['phone']){
            $user->phone =  $input['phone'];
            $edited = true;
        }
        if($edited){
            $user->save();    
        }

        return $this->sendResponse($user->toArray(), 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    ///*
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse($user->toArray(), 'User deleted successfully.');
    }
    //*/
}
