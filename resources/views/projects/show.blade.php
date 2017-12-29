@extends('layouts.main')

@section('title')
    {{ $project->name }} | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="title">{{ $project->name }}</h4>
                    <p class="category">Show {{ $project->name }}'s properties and changes to them</p>
                </div>
                <div class="col-sm-6 align-right">
                    @if(Auth::user()->isManager())
                        <a href="/works/create" class="btn btn-default">
                            <i class="material-icons">add</i>
                        </a>
                        <a href="/projects/{{ $project->id }}/edit" class="btn btn-default">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        <form action="/projects/{{ $project->id }}" method="POST" class="inline-block">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-danger">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-content">
            <div class="row">
                <div class="col-sm-2 align-right"><b>Name</b></div>
                <div class="col-sm-10">{{ $project->name }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Assigned Workers</b></div>
                <div class="col-sm-10">{{ $project->users->count() }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Total work units</b></div>
                <div class="col-sm-10">{{ $project->works->count() }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2 align-right"><b>Total hours</b></div>
                <div class="col-sm-10">{{ $project->hours }}</div>
            </div>
            @if(Auth::user()->isManager())
                <div class="row">
                    <div class="col-sm-2 align-right"><b>Total cost</b></div>
                    <div class="col-sm-10">{{ $project->cost }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        @php
            $cols = Auth::user()->isManager() ? "col-md-4" : "col-md-6";
        @endphp
        <div class="{{ $cols }}">
            <div class="card">
                <div class="card-header card-chart" data-background-color="green">
                    <div class="ct-chart" id="hoursPerDayChart"></div>
                </div>
                <div class="card-content">
                    <h4 class="title">Hours per day</h4>
                    <p class="category">See at a glance how many hours this project had, per day, in the last month</p>
                </div>
            </div>
        </div>
        <div class="{{ $cols }}">
            <div class="card">
                <div class="card-header card-chart" data-background-color="orange">
                    <div class="ct-chart" id="devsPerDayChart"></div>
                </div>
                <div class="card-content">
                    <h4 class="title">Daily developers</h4>
                    <p class="category">How many developers worked on this per day?</p>
                </div>

            </div>
        </div>
        @if(Auth::user()->isManager())
            <div class="{{ $cols }}">
                <div class="card">
                    <div class="card-header card-chart" data-background-color="red">
                        <div class="ct-chart" id="costPerDayChart"></div>
                    </div>
                    <div class="card-content">
                        <h4 class="title">Cost</h4>
                        <p class="category">Keep the total cost at bay</p>
                    </div>
                </div>
            </div>
        @endif
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
                                @if($work->hours === (float)0)
                                    <a href="/works/create/end/{{ $work->id }}" class="btn btn-success">
                                        <i class="material-icons">check</i>
                                    </a>
                                @elseif(Auth::user()->isManager())
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

@push('styles')
    <style>
        .card-content .row {
            margin-top: 1em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("table.dataTable").on("click", "tbody tr", function (event) {
            if (event.target.tagName === "TD") {
                const target = $(event.target);
                const tr = target.parent();
                const id = tr.data("id");

                location.href = `/works/${id}`;
            }
        });
    </script>

    <script>
        /* HoursPerDayChart */
        const dataHoursPerDayChart = {
            labels: {!! json_encode($labels) !!},
            series: [
                {!! json_encode($hours) !!}
            ]
        };

        const optionsHoursPerDayChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 24,
            chartPadding: {top: 0, right: 0, bottom: 0, left: 0}
        };

        const hoursPerDayChart = new Chartist.Line('#hoursPerDayChart', dataHoursPerDayChart, optionsHoursPerDayChart);

        md.startAnimationForLineChart(hoursPerDayChart);


        /* UsersPerDayChart */
        const dataUsersPerDayChart = {
            labels: {!! json_encode($labels) !!},
            series: [
                {!! json_encode($users) !!}
            ]
        };

        const optionsUsersPerDayChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ $project->users->count() + 1 }},
            chartPadding: {top: 0, right: 0, bottom: 0, left: 0}
        };

        const usersPerDayChart = new Chartist.Line('#devsPerDayChart', dataUsersPerDayChart, optionsUsersPerDayChart);

        md.startAnimationForLineChart(usersPerDayChart);


        /* CostPerDayChart */
        const dataCostPerDayChart = {
            labels: {!! json_encode($labels) !!},
            series: [
                {!! json_encode($costs) !!}
            ]
        };

        const optionsCostPerDayChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ $highest_cost }},
            chartPadding: {top: 0, right: 0, bottom: 0, left: 0}
        };

        const costPerDayChart = new Chartist.Line('#costPerDayChart', dataCostPerDayChart, optionsCostPerDayChart);

        md.startAnimationForLineChart(costPerDayChart);
    </script>
@endpush