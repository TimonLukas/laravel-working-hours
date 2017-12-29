@extends('layouts.main')

@section('title')
    Dashboard | @parent
@stop

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">All work units</h4>
                <p class="category">All work units created thus far</p>
            </div>
            <div class="card-content">
                <table class="table table-hover" data-datatable>
                    <thead>
                    <tr>
                        <th>Done by</th>
                        <th>Project</th>
                        <th>Start</th>
                        <th>Hours</th>
                        <th>Work done</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($works as $work)
                        <tr data-id="{{ $work->id }}">
                            <td>{{ $work->user->name }}</td>
                            <td>{{ $work->project->name }}</td>
                            <td>{{ $work->start->format('Y-m-d H:i') }}</td>
                            <td>{{ $work->hours }}</td>
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
    </div>
@stop

@push('scripts')
    <script>
        $(function () {
            $("table.dataTable").on("click", "tbody tr", function (event) {
                if (event.target.tagName === "TD") {
                    const target = $(event.target);
                    const tr = target.parent();
                    const id = tr.data("id");

                    location.href = `/works/${id}`;
                }
            });

            $("table[data-datatable]").each(function (key, value) {
                var table = $(this).DataTable();
                table.order([2, "desc"]).draw();
            });
        });
    </script>
@endpush