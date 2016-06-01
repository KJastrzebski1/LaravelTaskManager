<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Organization;

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
}
