@extends ('layouts.app')

@section ('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Manage roles
            </div>
            <div class="panel-body">
                <form action="{{url('/organization/'.$organization->id.'/roles/save')}}" method="POST" >
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="role-name" class="col-sm-3 control-label">Role title</label>

                        <div class="col-sm-6">
                            <input type="text" name="role_name" id="role-name" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Capabilities</label>
                        <div class="col-sm-6" >
                            <div class="checkbox">
                                <input type="checkbox" name="task_manager" value="task_manager">Tasks
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="project_manager" value="project_manager">Projects
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" name="organization_manager" value="organization_manager">Organization
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="btn btn-default">
                                Save Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 