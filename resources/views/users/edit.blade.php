@extends('layouts.main')

@section('title')
    Edit {{ $user->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Edit {{ $user->name }}</h4>
            <p class="category">Edit {{ $user->name }}'s properties</p>
        </div>
        <div class="card-content">
            <form action="/users/{{ $user->id }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                @include('users.form')
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@stop