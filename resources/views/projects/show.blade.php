@extends('layouts.main')

@section('title')
    {{ $project->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">{{ $project->name }}</h4>
            <p class="category">Show {{ $project->name }}'s properties and changes to them</p>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col-sm-2 align-right"><b>Name</b></div>
                <div class="col-sm-10">{{ $project->name }}</div>
            </div>
        </div>
    </div>

    @include('audit', ['resource' => $project])
@stop

@push('scripts')
    <style>
        .card-content .row {
            margin-top: 1em;
        }
    </style>
@endpush