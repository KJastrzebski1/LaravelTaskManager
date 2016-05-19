<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Project;
use App\Repositories\TaskRepository;
use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{
    protected $projects;


    public function __construct(ProjectRepository $projects) {
        //$this->middleware('auth');
        
        $this->projects = $projects;
    }
    
    public function store(Request $request){
        $data = $request['data'];
        $project = new Project();
        $project->name = $data['name'];
        $project->save();
        return redirect('/tasks');
    }
}
