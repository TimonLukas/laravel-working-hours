@extends('layouts.main')

@section('title')
    Edit {{ $project->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Edit {{ $project->name }}</h4>
            <p class="category">Edit {{ $project->name }}'s properties</p>
        </div>
        <div class="card-content">
            <form action="/projects/{{ $project->id }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                @include('projects.form')
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@stop