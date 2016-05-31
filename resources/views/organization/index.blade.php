@extends ('layouts.app')

@section ('content')

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Your Organizations
            </div>
            <div class="panel-body">
                <table class="table table-striped task-table sortable">

                    @if($organizations)
                    <thead>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Manage</th>
                    </thead>
                    <tbody>
                        @foreach($organizations as $organization)
                        <tr>
                            <td><img src="{{ $organization->logo }}"></td>
                            <td>{{ $organization->name }}</td>
                            <td><a href="/organization/{{$organization->id}}" class="btn">Manage</a></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td><a href="{{ url('/createorg')}}">Create new organization</a></td>
                        </tr>
                    </tbody>

                    @else
                    You aren't in any organization. <a href="{{ url('/createorg')}}">Create new organization</a>
                    @endif
                </table>
            </div>
        </div>
    </div>
    @if($messages)
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Your Messages
            </div>
            <div class="panel-body">
                <table class="table table-striped task-table sortable">
                    <thead>
                        <th>From</th>
                        <th> </th>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{$organizations[$message->org_id]->name}}</td>
                            <td>
                                <button class="btn"><i class="fa fa-check" aria-hidden="true"></i></button>
                                <button class="btn"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
               
        </div>
    </div>
    @endif
</div>

@endsection