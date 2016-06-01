<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'org_id'
    ];
    
    public function tasks(){
        return $this->hasMany(Task::class);
    }
    
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
