<?php

namespace App\Repositories;

use App\Repositories\TaskRepository;
use App\Organization;
use App\Project;

class ProjectRepository {

    /**
     * Get all of the projects for a given organization.
     *
     * @param  Organization $org
     * @return Collection
     */
    public static function forOrg(Organization $org) {
        return Project::where('org_id', $org->id)
                        ->orderBy('created_at', 'asc')
                        ->get();
    }

    public function forAll() {
        return Project::orderBy('created_at', 'asc')->get();
    }

    /**
     * Deletes all projects for organization
     * 
     * @param Organization $org
     * 
     */
    public static function deleteProjects(Organization $org) {
        $projects = self::forOrg($org);
        foreach ($projects as $project) {
            TaskRepository::deleteTasks($project);
        }
        Project::where('org_id', $org->id)->forceDelete();
    }

}
