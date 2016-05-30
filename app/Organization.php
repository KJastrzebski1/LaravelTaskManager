<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'ceo_id',
        'logo'
    ];
    
    public function users(){
        return $this->hasMany(User::class);
    }
    
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
