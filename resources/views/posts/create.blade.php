@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 col-sm-12 md-5">
                <h1>Poszt írása</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST']) !!}
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
                        {{Form::label('body', 'Szöveg')}}
                        {{Form::textarea('body', '', ['class' => 'form-control', 'placeholer' => 'Szöveg'])}}
                </div>
                {{Form::submit('Küldés', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

