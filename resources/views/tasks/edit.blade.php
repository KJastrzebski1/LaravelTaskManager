@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $task->name }}
            </div>

            <div class="panel-body">
                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Task Form -->
                <form action="/edit/{{ $task->id}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="task-name" class="col-sm-3 control-label">Task</label>

                        <div class="col-sm-6">
                            <input type="text" name="name" id="task-name" class="form-control" value="{{ $task->name }}">
                        </div>
                    </div>

                    <!-- Task Deadline -->
                    <div class="form-group">
                        <label for="task-deadline" class="col-sm-3 control-label">Deadline</label>
                        <div class="col-sm-6">
                            <input type='date' class="form-control" name="deadline" id='task-deadline' value="{{ $task->deadline }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-priority" class="col-sm-3 control-label">Priority</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="task-priority" name="priority">
                                <option @if ($task->priority == 'Low') selected="selected" @endif>Low</option>
                                <option @if ($task->priority == 'Normal') selected="selected" @endif>Normal</option>
                                <option @if ($task->priority == 'High') selected="selected" @endif>High</option>
                                <option @if ($task->priority == 'Urgent') selected="selected" @endif>Urgent</option>
                                <option @if ($task->priority == 'Immediate') selected="selected" @endif>Immediate</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="task-status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="task-status" name="status">
                                @for($i=0;$i<=100;$i+=10)
                                <option @if ($task->status == $i) selected="selected" @endif>{{$i}}</option>
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
    </div>
</div>
@endsection