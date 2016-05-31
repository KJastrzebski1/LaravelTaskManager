<?php

namespace App;

use App\User;
use App\Organization;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $fillable = [
        'user_id',
        'org_id',
        
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

}
