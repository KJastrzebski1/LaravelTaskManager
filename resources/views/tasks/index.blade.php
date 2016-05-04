@extends('layouts.app')

@section('content')
<div class="container">
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
                            <input type='date' class="form-control" name="deadline" id='task-deadline' value="{{ old('task') }}"/>
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
                        <tr>
                            <td class="table-text"><div>{{ $task->name }}</div></td>
                            <td class="table-text"><div>{{ $task->deadline }}</div></td>
                            <td class="table-text"><div>{{ $task->status}}%</div></td>
                            <td class="table-text"><div>{{ $task->priority}}</div></td>
                            <!-- Task Delete Button -->
                            <td>
                                <form action="/task/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                </form>
                                <form action="/task/{{ $task->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    
                                    <button type="submit" id="edit-task-{{ $task->id }}" class="btn">
                                        <i class="fa fa-btn fa-pencil"></i> Edit
                                    </button>
                                </form>
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
