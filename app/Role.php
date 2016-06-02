<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;
use App\User;

class Role extends Model
{
    protected $fillable = [
        'name',
        'org_id',
        'capabilities'
    ];
    
    public function organizations(){
        return $this->belongsTo(Organization::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
