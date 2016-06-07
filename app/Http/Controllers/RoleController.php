<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;
use App\Organization;
use App\Http\Requests;

class RoleController extends Controller {

   

    public function manage(Request $request, $id) {
        $org = Organization::findOrFail($id);

        return view('organization.role', ['organization' => $org]);
    }

    public function store(Request $request, $id) {
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
