@extends('layouts.main')

@section('title')
    Create a user | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Create a new user</h4>
            <p class="category">Create an employee or another manager</p>
        </div>
        <div class="card-content">
            <form action="/users" method="post">
                {{ csrf_field() }}
                @include('users.form')
                <button type="submit" class="btn btn-default">Create</button>
            </form>
        </div>
    </div>
@stop