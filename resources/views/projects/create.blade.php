@extends('layouts.main')

@section('title')
    Create a project | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Create a project</h4>
            <p class="category">Create a new project to be worked on!</p>
        </div>
        <div class="card-content">
            <form action="/projects" method="post">
                {{ csrf_field() }}
                @include('projects.form')
                <button type="submit" class="btn btn-default">Create</button>
            </form>
        </div>
    </div>
@stop