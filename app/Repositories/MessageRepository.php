<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\User;
use App\Message;
use App\Organization;


class MessageRepository {
    
    public function isInvited(User $user, Organization $org){
        $msg = Message::get()->where('user_id', $user->id)->where('org_id', $org->id);
        
        return !$msg->isEmpty();
    }
    
}
