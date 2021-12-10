<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions;

    /**
     * UserController class handles querying the users table in the database
     * and responding to the client if their request was successful
     * or if there was an error
     */

class UserController extends Controller {
    /**
     * Stores a new user in the database
     * Requests must have a firstName, lastName, and email
     * or will respond with approriate error response
     *
     * @param Request $request, the client's request
     *
     * @return Response either success or error message
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
            return response()->json([
                'status' => 'success',
                'msg' => 'User created',
            ], 201);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'This email already exits, email must be unique',
            ], 409);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'firstName, lastName, and email are required fields',
            ], 400);
        }
    }

     /**
      * Updates the user with matching id
      * Requests must have an id and update at least one other field
      * or will respond with appropriate error response
      * @param Request $request, the client's request
      *
      * @return
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
            return response()->json([
                'status' => 'success',
                'msg' => 'User updated',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'id is required and at least one field must be updated',
            ], 400);
        }
    }

    /**
     * Retrieves columns firstName, lastName, and email for all users
     *
     * @return $users, array of users
     */
    public function getUsers() {
        $users = User::select('firstName', 'lastName', 'email')->get();
        return $users;
    }
}
