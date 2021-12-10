<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions;

class UserController extends Controller {
    /*
     * Storing a new user in our database
     * Requests must firstName, lastName, and email
     * or will respond with approriate error response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required'
            ]);
            $user = new User([
                'firstName' => $request->get('firstName'),
                'lastName' => $request->get('lastName'),
                'email' => $request->get('email')
            ]);
            $user->save();
            return $user;
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Query Exception, email already exists',
            ], 409);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'firstName, lastName, and email are required fields',
            ], 400);
        }
    }

     /*
     * Updates user with matching id
     * Requests must have an id and at update at least one other field
     * or will respond with appropriate error response
     */
    public function update(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
                'firstName' => 'required_without_all:lastName,email',
                'lastName' => 'required_without_all:firstName,email',
                'email' => 'required_without_all:firstName,lastName',
            ]);
            $id = $request->get('id');
            $input = $request->all();
            $user = User::all()->where('id', '=', $id);
            if ($user == '[]') {
                return response()->json([
                'status' => 'error',
                'msg' => 'no user with that id',
                 ], 400);
            }
            User::whereId($id)->update($input);
            return $input;
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'id is required and at least one field must be updated',
            ], 400);
        }
    }

    // Retrieves columns firstName, lastName and email for all users
    public function getUsers() {
        $users = User::select('firstName', 'lastName', 'email')->get();
        return $users;
    }
}
