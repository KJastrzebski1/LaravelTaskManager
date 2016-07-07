<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Organization;
use App\Role;
use DB;
use App\Http\Requests;

class UserController extends Controller
{
    public function getUsers(Request $request, $id){
        $org = Organization::findOrFail($id);
        
        $args = [
            1 => $request->user(),
            0 => $org,
        ];
        
        //$this->authorize('isManager');
        $users = User::get();
        foreach($users as $user){
            $u[$user->id] = $user; 
        }
        $u[0] = new User();
        $u[0]->name = 'No Worker';
        $u[0]->id = 0;
        $users = $u;
        return response()->json($users);
    }
    
    
}
