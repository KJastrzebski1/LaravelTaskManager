<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Project;
use App\User;
use App\Organization;

class OrgRepository {

    public function getMembers(Organization $org) {
        if ($org->user_ids) {
            $ids = unserialize($org->user_ids);
        }else{
            $ids = [];
        }
        $users = [];
        foreach ($ids as $id) {
            $users[] = User::findOrFail($id);
        }
        return $users;
    }

    public function forUser(User $user) {
        $orgs = Organization::get();
        $organizations = [];
        foreach ($orgs as $org) {
            if ($org->user_ids) {
                $ids = unserialize($org->user_ids);
                if (in_array($user->id, $ids)) {
                    $organizations[$org->id] = $org;
                }
            } 
            if ($org->ceo_id === $user->id) {
                $organizations[$org->id] = $org;
            }
        }

        return $organizations;
    }

}
