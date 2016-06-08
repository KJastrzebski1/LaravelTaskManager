<?php

namespace App\Policies;

use App\User;
use DB;
use App\Role;
use App\Task;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given task.
     *
     * @param  User  $user
     * @param  Task  $task
     * @return bool
     */
    public function destroy(User $user)
    {
        exit();
        return 1===2;
    }
    
    public function ismanager(User $user, Organization $org)
    {
        /*$query = DB::table('user_roles')
                ->where('user_id', $user->id)
                ->where('org_id', $org->id)
                ->first();
        $role = Role::where('id', $query->role_id)->first();
        */
        return true;//in_array('project_manager', $role);
    }
}
