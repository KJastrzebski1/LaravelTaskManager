@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Select organization to see your tasks</div>

                <div class="panel-body">
                    @if (Auth::guest())
                    <h4>Hi! Please <a href="{{ url('/login') }}">Login</a> or <a href="{{ url('/register') }}">Register</a></h4>
                    @else
                    @foreach ($organizations as $org)
                    <div class="col-sm-6">
                        <a href="{{ url('tasks/'.$org->id)}}">
                            <img src="{{$org->logo }}">
                            {{ $org -> name }}
                        </a>

                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
