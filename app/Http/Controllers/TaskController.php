<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Project;
use App\User;
use App\Organization;
use App\Role;
use App\Repositories\ProjectRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TaskRepository;

class TaskController extends Controller {

    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;
    protected $roles;
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks, RoleRepository $roles) {
        $this->middleware('auth');
        $this->roles = $roles;
        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request, $id) {
        $user = $request->user();
        $org = Organization::findOrFail($id);
        $projects = Project::where('org_id', $id)->get();
        $role = $this->roles->getRole($user, $org);
        $permission = in_array( 'project_manager', unserialize($role->capabilities));
        $p = new Project();
        $p->name = 'Default';
        $p->id = 0;
        $projects[] = $p;
        $users[0] = new User();
        $users[0]->name = 'No Worker';
        $users[0]->id = 0;
        $u = User::get();
        
        foreach($u as $ut){
            $users[$ut->id] = $ut;
        }
        $tasks = [];
        if ($permission) {
            foreach ($projects as $project) {
                $tasks[$project->id] = $this->tasks->forProject($project);
            }
        }else{
            foreach ($projects as $project) {
                $tasks[$project->id] = $this->tasks->forUser($user, $project);
            }
        }
        $args = [
            'tasks' => $tasks,
            'projects' => $projects,
            'permission' => $permission,
            'organization' => $org
            
        ];
        if($permission){
            $args['users'] = $users;
        }
        return view('tasks.index', $args);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        //$this->authorize('isManager', $request->user());
        
        $data = $request["data"];
        $task = Task::create([
            "name" => $data["name"],
            "deadline" => $data["deadline"],
            "priority" => $data["priority"],
            "status" => $data["status"],
            "project_id" => $data["project_id"],
            "user_id" => 0,
        ]);
        $users[0] = new User();
        $users[0]->name = 'No Worker';
        $users[0]->id = 0;
        $u = User::get();
        
        foreach($u as $ut){
            $users[$ut->id] = $ut;
        }
        return ['task' => $task]; //redirect('/tasks');
    }

    /*
     * 
     */


    public function edit(Request $request) {
        $data = $request['data'];
        $task = Task::findOrFail($data['id']);
        $task->name = $data['name'];
        $task->deadline = $data['deadline'];
        $task->priority = $data['priority'];
        $task->status = $data['status'];
        $user = $request->user();
        //if($user->role == 'Manager'){
            $task->user_id = $data['user_id'];
        //}
        
        $task->save();
        return response()->json($task);
    }

    public function destroyAjax(Request $request) {
        //$this->authorize('isManager', $request->user());
        $data = $request['data'];
        $task = Task::findOrFail($data);
        
        $task->delete();
        return 'deleted';
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task) {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

}
