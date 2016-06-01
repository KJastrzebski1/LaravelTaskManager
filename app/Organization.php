<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Project;
use App\Role;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'ceo_id',
        'logo',
        'user_ids',
    ];
    
    protected $casts = [
        'ceo_id' => 'int'
    ];
    
    public function users(){
        return $this->hasMany(User::class);
    }
    
    public function projects(){
        return $this->hasMany(Project::class);
    }
    
    public function roles(){
        return $this->hasMany(Role::class);
    }
}
