@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-warning" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Warning!</strong> You are in offline mode. Your data will be stored locally and synchronized after getting online.
    </div>
    <div class="alert alert-success" >
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Your data has been synchronized with server.
    </div>
    @if ($permission)
    
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Task
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form <form action="/task" method="POST" class="form-horizontal">-->
                <div class="form-horizontal">
                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="task-name" class="col-sm-3 control-label">Task</label>

                        <div class="col-sm-6">
                            <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                        </div>
                    </div>

                    <!-- Task Deadline -->
                    <div class="form-group">
                        <label for="task-deadline" class="col-sm-3 control-label">Deadline</label>
                        <div class='input-group date col-sm-6' id='datetimepicker1'>
                            <input type='text' name="deadline" id="task-deadline" class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-priority" class="col-sm-3 control-label">Priority</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="task-priority" name="priority">
                                <option>Low</option>
                                <option>Normal</option>
                                <option>High</option>
                                <option>Urgent</option>
                                <option>Immediate</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="task-status" name="status">
                                @for($i=0;$i<=100;$i+=10)
                                <option>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-project" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="task-project" name="task_project">
                                @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="btn btn-default new-task">
                                <i class="fa fa-btn fa-plus"></i>Save Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-sm-offset-2 col-sm-8">
        <!-- Current Tasks -->
        <script>
            localStorage.taskRepo = "";
            var task = [];
            permission = {{ $permission ? 1 : 0 }};
        </script>
        @foreach ($projects as $project)
        @if (count($tasks[$project->id]) > 0)
        <div class="panel panel-default" id="project-{{$project->id}}">
            <div class="panel-heading">
                {{ $project->name }}
                
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table sortable">
                    <thead>
                    <th>Task</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Priority</th>
                    @if($permission)
                    <th>User</th>
                    @endif
                    <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($tasks[$project->id] as $task)
                        <script>
                            
                            if(localStorage.taskRepo){
                               task = JSON.parse(localStorage.taskRepo);
                            }
                            var tmp = {
                                "id": {{ $task->id }},
                                "name": "{{ $task->name }}",
                                "deadline": "{{ $task->deadline }}",
                                "status": {{ $task->status }},
                                "priority": "{{ $task->priority}}"
                            }
                            if(permission){
                                tmp["user_id"] = {{ $task->user_id}};
                            }
                            task.push(tmp);
                            localStorage.taskRepo = JSON.stringify(task);
                        </script>
                        @include('tasks.task', ['task' => $task])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
