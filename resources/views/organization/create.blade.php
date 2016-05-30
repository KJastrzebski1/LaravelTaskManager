@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Organization
            </div>
            <div class="panel-body">
                <form action="{{ url('/neworg')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="organization-name" class="col-sm-3 control-label">Name</label>

                        <div class="col-sm-6">
                            <input type="text" name="organization_name" id="organization-name" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Logo</label>
                        <div class="col-sm-6">
                            <input type="file" name="organization_logo" class="filestyle">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button class="btn btn-default">
                                Create Organization
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection