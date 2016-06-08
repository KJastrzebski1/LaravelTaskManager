<?php

namespace App\Repositories;

use App\User;
use App\Task;
use App\Project;

class TaskRepository {

    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user, Project $project) {
        return Task::where('user_id', $user->id)
                        ->where('project_id', $project->id)
                        ->orderBy('created_at', 'asc')
                        ->get();
    }

    public function forProject(Project $project) {
        return Task::where('project_id', $project->id)
                        ->orderBy('created_at', 'asc')
                        ->get();
    }
    
    public static function deleteTasks(Project $project) {
        Task::where('project_id', $project->id)->forceDelete();
    }

}
