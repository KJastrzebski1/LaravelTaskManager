<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\User;
use App\Organization;
use App\Role;
use DB;

class RoleRepository {

    public function getRole(User $user, Organization $org) {
        $query = DB::table('user_roles')
                ->where('user_id', $user->id)
                ->where('org_id', $org->id)
                ->first();
        if ($query) {
            $role = Role::findOrFail($query->role_id);
        } else {
            $capabilities = [
                null,
                null,
                null,
            ];

            $role = Role::create([
                        'name' => 'No role',
                        'org_id' => $org->id,
                        'capabilities' => serialize($capabilities),
            ]);
        }

        return $role;
    }

}
