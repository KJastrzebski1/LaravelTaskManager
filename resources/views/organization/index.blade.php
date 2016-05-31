@extends ('layouts.app')

@section ('content')

<div class="container">
    <div class="col-sm-offset-2 col-sm-8">
        <div class="panel panel-default">
            @if (Auth::user()->role == 'CEO')
            <div class="panel-heading">
                Your Organization
            </div>
            @else
            <div class="panel-heading">
                Your Organizations
            </div>
            <div class="panel-body">
                <table class="table table-striped task-table sortable">
                
                @if(!$organizations->isEmpty())
                <thead>
                    <th>Logo</th>
                    <th>Name</th>
                </thead>
                <tbody>
                    @foreach($organizations as $organization)
                    <tr>
                        <td><img src="{{ $organization->logo }}"></td>
                        <td>{{ $organization->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                You aren't in any organization. <a href="{{ url('/createorg')}}">Create new organization</a>
                @endif
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection