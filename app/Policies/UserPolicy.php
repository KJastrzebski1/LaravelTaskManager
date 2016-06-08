<?php

namespace App\Policies;

use App\User;
use App\Organization;
use App\Role;
use DB;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function isManager(User $user, Organization $org)
    {
        $query = DB::table('user_roles')
                ->where('user_id', $user->id)
                ->where('org_id', $org->id)
                ->first();
        $role = Role::where('id', $query->role_id)->first();
        return true;//in_array('project_manager', $role);
    }
    
    
}
