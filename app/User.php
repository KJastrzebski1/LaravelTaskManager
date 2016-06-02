<?php

namespace App;

use App\Task;
use App\Organization;
use App\Message;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the tasks for the user.
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }
    public function roles(){
        return $this->hasMany(Role::class);
    }
    public function organizations() {
        return $this->belongsTo(Organization::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}
