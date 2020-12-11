@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12 col-xl-11">
        <div class="row justify-content-between">
            <div class="col-md-6 col-sm-12 md-5">
                <h1>Esemény létrehozása</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            {!! Form::open(['action' => 'EventsController@store', 'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('visibility', 'Láthatóság')}}
                    @if(Auth::user()->right_id == 3)
                    {{ Form::select('visibility',  ['1' => 'Publikus', '2' => 'Privát', '3' => Auth::user()->instrument->name .' szólam'], NULL, ['class' => 'form-control']) }}
                    @elseif(Auth::user()->instrument_id == NULL)
                    {{ Form::select('visibility',  ['2' => 'Privát'], NULL, ['class' => 'form-control']) }}
                    @else
                    {{ Form::select('visibility',  ['2' => 'Privát', '3' => Auth::user()->instrument->name .' szólam'], NULL, ['class' => 'form-control']) }}
                    @endif
                </div>
                <div class="form-group">
                    {{Form::label('title', 'Cím')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholer' => 'Cím'])}}
                </div>
                <div class="form-group">
                        {{Form::label('body', 'Leírás')}}
                        {{Form::textarea('body', '', ['class' => 'form-control', 'placeholer' => 'Leírás'])}}
                </div>
                <div class="form-group">
                        {{Form::label('location', 'Helyszín')}}
                        {{Form::text('location', '', ['class' => 'form-control', 'placeholer' => 'Helyszín'])}}
                    </div>
                <div class="form-group">
                    {{Form::label('start', 'Kezdete')}}
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        {{Form::text('start', '', ['class' => 'form-control datetimepicker-input', 'data-target' => '#datetimepicker1'])}}
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('end', 'Vége')}}
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        {{Form::text('end', '', ['class' => 'form-control datetimepicker-input', 'data-target' => '#datetimepicker2'])}}
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                        </div>
                    </div>
                </div>


                {{Form::submit('Létrehoz', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


@endsection


@section('jscripts')

<script type="text/javascript">
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            locale: 'hu',
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
    }});

    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
    $(function () {
        $('#datetimepicker2').datetimepicker();
    });
</script>


@endsection
