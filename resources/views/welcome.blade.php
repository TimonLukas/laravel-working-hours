@extends("layouts.auth")

@section("title")
    Welcome | @parent
@stop

@section("content")
    <div class="title m-b-md">
        <img src="{{ asset("/images/logo.png") }}">
    </div>
    <span class="subtitle">Take your time.</span>
@stop

@push("scripts")
    <script>
        document.querySelector(".content").addEventListener("click", () => {
            location.href = "/home";
        });
    </script>
@endpush

@push("styles")
    <style>
        .title img {
            max-width: 70vw;
        }

        .subtitle {
            font-size: 4rem;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endpush