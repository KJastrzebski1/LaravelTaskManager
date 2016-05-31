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
    </div>
</div>
@endsection