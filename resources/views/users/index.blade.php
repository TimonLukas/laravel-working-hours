@extends('layouts.main')

@section('title')
    Users | @parent
@stop

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="title">All users</h4>
                        <p class="category">Every user (managers and employers)</p>
                    </div>
                    <div class="col-sm-6 align-right">
                        <a href="/users/create" class="btn btn-default">
                            <i class="material-icons">person_add</i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover" data-datatable>
                    <thead class="text-primary">
                    <tr>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Is manager</th>
                        <th>Rate</th>
                        <th>Registered on</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr data-id="{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><i class="material-icons">{{ $user->is_manager ? 'check' : 'close' }}</i></td>
                            <td>{{ $user->rate === 0 ? '' : number_format($user->rate, 2) }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="/users/{{ $user->id }}/edit" class="btn btn-default">
                                    <i class="material-icons">mode_edit</i>
                                </a>
                                <form action="/users/{{ $user->id }}" method="POST" class="inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </form>
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
        $("table.dataTable").on("click", "tbody tr", function (event) {
            if (event.target.tagName === "TD") {
                const target = $(event.target);
                const tr = target.parent();
                const id = tr.data("id");

                location.href = `/users/${id}`;
            }
        });
    </script>
@endpush