@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        @if( isset($message))
        <div class="alert alert-info" style="display: block;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $message }}
        </div>
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading">
                Organization: {{ $org->name }}
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <img src="{{ url($org->logo) }}">
                </div>
                <div class="col-sm-6">
                    
                </div>
                <div class="col-sm-3">
                    <form action="{{ url('/organization/'.$org->id.'/delete')}}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-8">
        @if ( $members)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current members <a href="{{ url('/organization/'.$org->id.'/roles')}}">Manage Roles</a>
            </div>
            <div class="panel-body">
                <table class="table table-striped members-table sortable">
                    <thead>
                    <th>Name</th>
                    <th>Role</th>
                    <th></th>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr id="member-{{$member->id}}">
                            <td class="member-name">{{$member->name}}</td>
                            <td class="member-role">{{$member->role}}</td>
                            <td><button id='set-role-{{$member->id}}' class="btn set-role">Edit</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                Invite new members
            </div>
            <div class="panel-body">
                <form action="{{ url('/organization/'.$org->id.'/invite')}}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="member-email" class="col-sm-3 control-label">E-mail</label>

                        <div class="col-sm-6">
                            <input type="text" name="member_email" id="member-email" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="btn btn-default">
                                Invite new member
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                New Project
            </div>
            <div class="panel-body">

                <form class="form-horizontal" action="{{ url('/project/'.$org->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="project-name" class="col-sm-3 control-label">Project</label>

                        <div class="col-sm-6">
                            <input type="text" name="project_name" id="project-name" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="btn btn-default new-project">
                                <i class="fa fa-btn fa-plus"></i>Save Project
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection