<?php

namespace App\Policies;

use App\User;
use App\Organization;
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
    
    public function isManager(User $user)
    {
        return $user->role === 'Manager';
    }
    public function isCapable(User $user, Organization $org, $cap){
        $query = DB::table('user_roles')
                ->where('user_id', $user->id)
                ->where('org_id', $org->id)
                ->first();
        return in_array($cap, $query);
    }
    
}
