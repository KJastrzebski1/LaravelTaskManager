<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'deadline',
        'priority',
        'status',
        'project_id',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * Get the user that owns the task.
     * public function user() {
        return $this->belongsTo(User::class);
    }
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function projects(){
        return $this->belongsTo(Project::class);
    }

}
