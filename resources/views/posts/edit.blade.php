@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 col-sm-12 md-5">
                <h1>Poszt szerkesztése</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('title', 'Cím')}}
                    {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholer' => 'Cím'])}}
                </div>
                <div class="form-group">
                        {{Form::label('body', 'Szöveg')}}
                        {{Form::textarea('body', $post->body, ['class' => 'form-control', 'placeholer' => 'Szöveg'])}}
                </div>
                @method('PUT')
                @csrf
                {{Form::submit('Küldés', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
