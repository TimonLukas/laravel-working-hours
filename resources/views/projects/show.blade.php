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

    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Work units</h4>
            <p class="category">Work units done for {{ $project->name }}</p>
        </div>
        <div class="card-content">
            <table class="table table-hover" data-datatable>
                <thead>
                <tr>
                    <th>Done by</th>
                    <th>Start</th>
                    <th>Hours</th>
                    @if(Auth::check() && Auth::user()->isManager())
                        <th>Rate</th>
                        <th>Cost</th>
                    @endif
                    <th>Work done</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($project->works as $work)
                    <tr data-id="{{ $work->id }}">
                        <td>{{ $work->user->name }}</td>
                        <td>{{ $work->start->format('Y-m-d H:i') }}</td>
                        <td>{{ $work->hours }}</td>
                        @if(Auth::check() && Auth::user()->isManager())
                            <td>{{ $work->rate }}</td>
                            <td>{{ number_format($work->rate * $work->hours, 2) }}</td>
                        @endif
                        <td>
                            <ul>
                                @foreach(explode("\r\n", $work->work_done) as $unit)
                                    <li>{{ $unit }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if(Auth::check() && (Auth::user()->isManager() || Auth::id() === $work->user_id))
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
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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

    <script>
        $("table.dataTable").on("click", "tbody tr", (event) => {
            if (event.target.tagName === "TD") {
                const target = $(event.target);
                const tr = target.parent();
                const id = tr.data("id");

                location.href = `/works/${id}`;
            }
        });
    </script>
@endpush