@extends('layouts.main')

@section('title')
    Projects | @parent
@stop

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="title">All projects</h4>
                        <p class="category">Every project that has been created thus far</p>
                    </div>
                    <div class="col-sm-6 align-right">
                        @if(Auth::user()->isManager())
                            <a href="/projects/create" class="btn btn-default">
                                <i class="material-icons">content_paste</i>
                                <i class="material-icons">add</i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover" data-datatable>
                    <thead class="text-primary">
                    <tr>
                        <th>Name</th>
                        <th>Assigned workers</th>
                        <th>Hours worked thus far</th>
                        @if(Auth::user()->isManager())
                            <th>Cost thus far</th>
                            <th>Created on</th>
                            <th>Actions</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr data-id="{{ $project->id }}">
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->users->count() }}</td>
                            <td>{{ $project->hours }}</td>
                            @if(Auth::user()->isManager())
                                <td>{{ $project->cost }}</td>
                                <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                <td>
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
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $("table.dataTable").on("click", "tbody tr", function (event) {
            if (event.target.tagName === "TD") {
                const target = $(event.target);
                const tr = target.parent();
                const id = tr.data("id");

                location.href = `/projects/${id}`;
            }
        });
    </script>
@endpush