<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions;
use App\Http\Requests;

class UserController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

    public function getUsers() {
        $users = User::all();
        foreach ($users as $user) {
            echo $user;
        }
    }
}
