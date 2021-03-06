<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>
        @section('title')
            Working Hours
        @show
    </title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <link href="{{ asset("/css/bootstrap.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/material-dashboard.css") }}" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>

    <link rel="stylesheet" href="{{ asset("/css/bootstrap-select.min.css") }}">

    <link rel="stylesheet" href="{{ asset("/css/style.css") }}">
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-color="green">
        <div class="logo">
            <a href="/" class="simple-text">
                <img src="{{ asset("/images/logo.png") }}"/>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                @if(Auth::check() && Auth::user()->isManager())
                    <li data-active-if="/dashboard">
                        <a href="/dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li data-active-if="/users">
                        <a href="/users">
                            <i class="material-icons">person</i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                <li data-active-if="/projects">
                    <a href="/projects">
                        <i class="material-icons">content_paste</i>
                        <p>Projects</p>
                    </a>
                </li>
                <li data-active-if="/works/create/start">
                    <a href="/works/create/start">
                        <i class="material-icons">add</i>
                        <p>Start new work unit</p>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->isManager())
                    <li data-active-if="/works/create">
                        <a href="/works/create">
                            <i class="material-icons">add</i>
                            <p>New manual work unit</p>
                        </a>
                    </li>
                @endif
                <li class="logout">
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="material-icons">perm_identity</i>
                        <p>Log out</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

</body>
<script src="{{ asset('/js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/material.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/chartist.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap-notify.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/material-dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/util.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/main.js') }}" type="text/javascript"></script>
@stack('scripts')
</html>
