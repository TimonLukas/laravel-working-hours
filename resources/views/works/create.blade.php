@extends('layouts.main')

@section('title')
    Enter new work | @parent
@stop

@section('content')
    <div class="card">
        <div class="card-header" data-background-color="green">
            <h4 class="title">Enter new work</h4>
            <p class="category">Enter work that you have done for a project</p>
        </div>
        <div class="card-content">
            <form action="/works" method="post">
                {{ csrf_field() }}
                @include('works.form')
                <button type="submit" class="btn btn-default">Create</button>
            </form>
        </div>
    </div>
@stop