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
                @if($organizations)
                    @foreach($organizations as $organization)
                    <div>
                        {{ $organization }}
                    </div>
                    @endforeach
                @else
                You aren't in any organization. <a href="{{ url('/createorg')}}">Create new organization</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@endsection