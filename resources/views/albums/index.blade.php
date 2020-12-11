@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-between">
        <h1 class="col-sm-6 md-5 text-center text-sm-left">
            @if(Route::input('visibility_name') == 'public')
                Publikus albumok
            @elseif(Route::input('visibility_name') == 'private')
                Privát albumok
            @else
                Albumok
            @endif
        </h1>
        @if(Auth::check() && Auth::user()->approved_at)
            <div class="col-sm-6 text-sm-right text-center">
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-modal">
                        Album létrehozása
                    </button>
                </div>
                <div class="dropdown pt-1">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Szűrés
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('albums.index')}}">Összes album</a>
                        <a class="dropdown-item" href="{{route('albums.index', 'public')}}">Publikus album</a>
                        <a class="dropdown-item" href="{{route('albums.index', 'private')}}">Privát album</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div class="card-group">
    @forelse ($albums as $album)
        <div class="col-lg-4 col-md-6 mt-4">
            <div class="card border-info ">
                <div class="card-body ">
                    <h3 class="text-center"><a href="{{route('albums.show', $album->id)}}">{{$album->name}}</a></h3>
                </div>
            </div>
        </div>
    @empty
        <p>Nincsenek albumok</p>
    @endforelse

    </div>
</div>

  <!-- The Modal -->
    <div class="modal fade" id="create-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Album létrehozása</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {!! Form::open(['action' => 'AlbumsController@store', 'method' => 'POST']) !!}
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        {{Form::label('visibility', 'Láthatóság')}}
                        {{ Form::select('visibility',  ['1' => 'Publikus', '0' => 'Privát'], NULL, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{Form::label('name', 'Neve')}}
                        {{Form::text('name', '', ['class' => 'form-control', 'placeholer' => 'Név'])}}
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    {{Form::submit('Létrehoz', ['class' => 'btn btn-primary'])}}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Mégse</button>
                </div>
            </div>
        </div>
    </div>

@endsection
