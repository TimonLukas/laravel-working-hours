@extends('layouts.main')

@section('title')
    {{ $user->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">{{ $user->name }}</h4>
            <p class="category">Show {{ $user->name }}'s properties and changes to them</p>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col-sm-2 align-right"><b>Name</b></div>
                <div class="col-sm-10">{{ $user->name }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>E-Mail</b></div>
                <div class="col-sm-10">{{ $user->email }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Hourly rate</b></div>
                <div class="col-sm-10">{{ number_format($user->rate, 2) }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Is manager</b></div>
                <div class="col-sm-10">
                    <i class="material-icons">{{ $user->is_manager ? 'check' : 'close' }}</i>
                </div>
            </div>
        </div>
    </div>

    @if(!$user->is_manager)
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Projects</h4>
                <p class="category">Projects to which {{ $user->name }} has access</p>
            </div>
            <div class="card-content">
                @if(count($user->projects) > 0)
                    <ul>
                        @foreach($user->projects as $project)
                            <li>{{ $project->name }}</li>
                        @endforeach
                    </ul>
                @else
                    None
                @endif
            </div>
        </div>
    @endif

    @include('audit', ['resource' => $user])
@stop

@push('scripts')
    <style>
        .card-content .row {
            margin-top: 1em;
        }
    </style>
@endpush