@extends('layouts.main')

@section('title')
    Edit work unit on {{ $work->project->name }} by {{ $work->user->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Edit work unit</h4>
            <p class="category">Edit details of this work unit</p>
        </div>
        <div class="card-content">
            <form action="/works/{{ $work->id }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                @include('works.form')
                <button type="submit" class="btn btn-default">Save</button>
            </form>
        </div>
    </div>
@stop