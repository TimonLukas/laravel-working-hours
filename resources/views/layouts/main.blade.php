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
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>

    <link href="{{ asset("/css/style.css") }}" rel="stylesheet">
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-color="green">
        <div class="logo">
            <a href="/home" class="simple-text">
                <img src="{{ asset("/images/logo.png") }}"/>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                <li data-active-if="/dashboard">
                    <a href="dashboard.html">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="user.html">
                        <i class="material-icons">person</i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a href="table.html">
                        <i class="material-icons">content_paste</i>
                        <p>Projects</p>
                    </a>
                </li>
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
        @yield('content')
    </div>
</div>

</body>
<script src="{{ asset('/js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/material.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/chartist.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap-notify.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/material-dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/util.js') }}" type="text/javascript"></script>
</html>
