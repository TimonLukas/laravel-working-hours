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

    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Audit log</h4>
            <p class="category">Any and all changes done to this user</p>
        </div>
        <div class="card-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Done by</th>
                    <th>Done on</th>
                    <th>Change</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->audits as $audit)
                    <tr>
                        <td>{{ ucfirst($audit->event) }}</td>
                        <td>{{ \App\User::find($audit->user_id)->name }}</td>
                        <td>{{ $audit->created_at->format("Y-m-d h:i:s") }}</td>
                        <td>{{ json_encode($audit->old_values) }} &rarr; {{ json_encode($audit->new_values) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('scripts')
    <style>
        .card-content .row {
            margin-top: 1em;
        }
    </style>
@endpush