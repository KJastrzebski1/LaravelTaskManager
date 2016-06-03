<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;
use App\Organization;
use App\Http\Requests;

class RoleController extends Controller
{
    
    public function assign(Request $request){
        $data = $request['data'];
        if($data['new']){
            DB::table('user_roles')->insert([
                'user_id' => $request->user()->id,
                'org_id' => $data['org_id'],
                'role_id' =>$data['role_id']
            ]);
        }else{
            DB::table('user_roles')
                    ->where('user_id', $request->user()->id)
                    ->where('org_id', $data['org_id'])
                    ->update(['role_id', $data['role_id']]);
            
        }
        
    }
    
    public function manage(Request $request, $id){
        $org = Organization::findOrFail($id);
        
        return view('organization.role', ['organization' => $org]);
    }
    public function store(Request $request, $id){
        $org = Organization::findOrFail($id);
        $capabilities = [
            $request->task_manager,
            $request->project_manager,
            $request->organization_manager,
        ];
       
        $role = Role::create([
            'name' => $request->role_name,
            'org_id' => $org->id,
            'capabilities' => serialize($capabilities),
        ]);
        return view('organization.role', ['organization' => $org]);
    }
}
