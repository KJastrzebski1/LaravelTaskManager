<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller {

    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks) {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request["data"];
        $task = $request->user()->tasks()->create([
            "name" => $data["name"],
            "deadline" => $data["deadline"],
            "priority" => $data["priority"],
            "status" => $data["status"],
        ]);
        return ['view' => (string)view('tasks.task', ['task' => $task]), 'id' => $task['id']];//redirect('/tasks');
    }
    
    /*
     * 
     */

    public function update(Request $request, Task $task) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'deadline' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ]);
        $task->name = $request->name;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();
        return redirect('/tasks');
    }

    /*
     * 
     */

    public function save(Request $request) {
        $data = $request['data'];
        $task = Task::findOrFail($data['id']);
        $task->name = $data['name'];
        $task->deadline = $data['deadline'];
        $task->priority = $data['priority'];
        $task->status = $data['status'];
        $task->save();
        return response()->json($task);
    }

    public function destroyAjax(Request $request) {
        $data = $request['data'];
        $task = Task::findOrFail($data);
        $this->authorize('destroy', $task);
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
