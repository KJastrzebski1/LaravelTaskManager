@extends ('layouts.app')

@section ('content')

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Your Organizations
            </div>
            <div class="panel-body">
                <table class="table table-striped organization-table sortable">

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
                            @if($organization->ceo_id === Auth::user()->id)
                            <td><a href="organization/{{$organization->id}}"><button class="btn btn-info">Manage</button></a></td>
                            @else
                            <td><a href="organization/{{$organization->id}}/leave"><button class="btn btn-danger">Leave</button></a></td>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a href="{{ url('/createorg')}}">Create new organization</a></td>
                        </tr>
                    </tfoot>

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
                <table class="table table-striped message-table sortable">
                    <thead>
                    <th>From</th>
                    <th> </th>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->org_name }}</td>
                            <td>
                                <div class="btn-group">
                                    <form action="message/accept/{{$message->id}}" method="POST">
                                        {{ csrf_field() }}
                                        <button  class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </form>
                                    <form action="message/remove/{{$message->id}}" method="POST">
                                        {{ csrf_field() }}
                                        <button  class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </form>
                                </div>
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