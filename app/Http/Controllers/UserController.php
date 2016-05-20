<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
    public function getUsers(){
        $users = User::get();
        $u = new User();
        $u->name = 'No Worker';
        $u->id = 0;
        $users[] = $u;
        return response()->json($users);
    }
    
    
}
