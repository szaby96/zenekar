@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sikeres Bejelentkezés</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="dvCountDown" style="display: none">
                        <span id="lblCount"></span>&nbsp; másodperc múlva továbbirányítunk.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('jscripts')

    <script type="text/javascript">
    $(function () {
        var seconds = 5;
        $("#dvCountDown").show();
        $("#lblCount").html(seconds);
        setInterval(function () {
            seconds--;
            $("#lblCount").html(seconds);
            if (seconds == 0) {
                $("#dvCountDown").hide();
                window.location = "{{route('posts.home')}}";
            }
        }, 1000);
    });
    </script>

@endsection
