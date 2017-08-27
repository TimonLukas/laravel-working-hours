@extends('layouts.main')

@section('title')
    Work unit on {{ $work->project->name }} by {{ $work->user->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="title">Work unit</h4>
                    <p class="category">Detailed information about this specific work unit</p>
                </div>
                <div class="col-sm-6 align-right">
                    <a href="/works/{{ $work->id }}/edit" class="btn btn-default">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <form action="/works/{{ $work->id }}" method="POST" class="inline-block">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">
                            <i class="material-icons">delete</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col-sm-2 align-right"><b>Project</b></div>
                <div class="col-sm-10">{{ $work->project->name }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>User</b></div>
                <div class="col-sm-10">{{ $work->user->name }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Started on</b></div>
                <div class="col-sm-10">{{ $work->start->format('Y-m-d H:i') }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Hours worked</b></div>
                <div class="col-sm-10">{{ number_format($work->hours, 2) }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Hourly rate</b></div>
                <div class="col-sm-10">{{ number_format($work->rate, 2) }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Total cost</b></div>
                <div class="col-sm-10">{{ number_format($work->rate * $work->hours, 2) }}</div>
            </div>
        </div>
    </div>

    @include('audit', ['resource' => $work])
@stop

@push('scripts')
    <style>
        .card-content .row {
            margin-top: 1em;
        }
    </style>
@endpush