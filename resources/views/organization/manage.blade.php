@extends('layouts.app')

@section ('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                You organization: {{ $org->name }}
            </div>
            <div class="panel-body">
                <img src="/{{ $org->logo }}">
                @if( isset($message))
                {{ $message }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-8">
        @if ( $members)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current members <a href="{{ url('organization/'.$org->id.'/roles')}}">Manage Roles</a>
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
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->role}}</td>
                            <td></td>
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
                <form action="/organization/{{$org->id}}/invite" method="POST">
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