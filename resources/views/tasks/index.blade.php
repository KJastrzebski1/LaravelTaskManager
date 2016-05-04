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
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Task
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="/task" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

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
                        <div class="col-sm-6">
                            <input type='date' class="form-control" name="deadline" id='task-deadline' value="rrrr-mm-dd"/>
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
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i>Save Task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Tasks -->
        @if (count($tasks) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table sortable">
                    <thead>
                    <th>Task</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                    <script>
                        localStorage.setItem('TaskRepo{{ $task->id }}', [
                            {{ $task->id }},
                            '{{ $task->name }}',
                            '{{ $task->deadline }}',
                            {{ $task->status}},
                            '{{ $task->priority}}'
                        ]);
                        
                    </script>
                        <tr id='task-{{ $task->id }}'>
                            <td class="table-text tname"><div>{{ $task->name }}</div></td>
                            <td class="table-text tdeadline"><div>{{ $task->deadline }}</div></td>
                            <td class="table-text tstatus"><div>{{ $task->status}}%</div></td>
                            <td class="table-text tpriority"><div>{{ $task->priority}}</div></td>
                            <!-- Task Delete Button -->
                            <td>
                                <!-- <form action="/task/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form> -->
                                    <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger delete">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                
                                <!-- <form action="/task/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }} 
                                </form>  -->  
                                    <button type="submit" id="edit-task-{{ $task->id }}" class="btn edit">
                                        <i class="fa fa-btn fa-pencil"></i> Edit
                                    </button>
                                    <button id="save-task-{{ $task->id }}" class="btn save">Save</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
