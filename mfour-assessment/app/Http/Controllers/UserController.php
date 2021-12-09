<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

// use DB;
// use App\Http\Requests;
// use App\Http\Controllers\Controller;

class UserController extends Controller {
    public function createUser() {
        DB::insert('insert into users (firstName, lastName, email) values (?, ?)', ['example', 'test', 'example@gmail.com']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName'=>'required',
            'lastName'=>'required',
            'email'=>'required'
        ]);
        $user = new User([
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email')
        ]);
        $user->save();
    }

    public function getUsers() {
        $users = User::all();
        foreach ($users as $user) {
            echo $user;
        }
    }
}
