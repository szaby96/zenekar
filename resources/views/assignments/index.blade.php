@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-between pb-2">
        <div class="col-sm-6 md-5 text-center text-sm-left">
            <h2>
                @if(Request::segment(2) != NULL && $composition_name->id  ==  Request::segment(2) )
                    <span>{{$composition_name->title}} darab <span>
                @endif
                <span>{{Auth::user()->instrument->name}} <span>
                szólam beosztása
            </h2>
        </div>

        <div class="col-sm-6 text-sm-right text-center">
            <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Darab kiválasztása
                </button>
                <div class="dropdown-menu">
                    @forelse($compositions as $composition)
                    <a class="dropdown-item" href="{{route('assignments.index', $composition->id)}}">{{$composition->title}}</a>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(Auth::user()->right->id >= 2 && Request::segment(2) != NULL && $composition_name->id  ==  Request::segment(2))
            <div class="col-12 col-md-12 col-lg-4 order-lg-2 mb-4">
                <div class="card">
                    {!! Form::open(['action' => 'AssignmentsController@store', 'method' => 'POST']) !!}
                        <div class="card-header"><h3>Szólamtárs beosztása</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                {{Form::label('user', 'Tagok')}}
                                {{Form::select('user', $users, null, ['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('role', 'Szerep')}}
                                {{Form::text('role', '', ['class' => 'form-control', 'placeholer' => 'Szerep'])}}
                            </div>
                            {{Form::hidden('instrument_id', Auth::user()->instrument->id)}}
                            {{Form::hidden('composition_id', $composition_name->id)}}
                        </div>
                        <div class="card-footer text-center">
                            {{Form::submit('Jóváhagy', ['class' => 'btn btn-primary'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
        @if(Auth::user()->right->id >= 2 && Request::segment(2) != NULL && $composition_name->id  ==  Request::segment(2))
        <div class="col-12 col-md-12 col-lg-8 order-lg-1">
        @else
        <div class="col-12 order-lg-1">
        @endif
        <div class="row ">
            <div class="col-12" style="">
                <div class="panel panel-default list-group-panel">
                    <div class="panel-body">
                        <ul class="list-group list-group-header">
                            <li class="list-group-item list-group-body">
                                <div class="row">
                                    <div class="col-4 text-left"><h4>Név</h4></div>
                                    <div class="col-4 text-center"><h4>Szerep</h4></div>
                                    @if(Auth::user()->right_id >=2)
                                        <div class="col-4 text-right"><h4>Törlés</h4></div>
                                    @endif
                                </div>
                            </li>
                        </ul>
                        @if(Request::segment(2) != NULL)
                            @forelse ($assignments as $assignment)
                            <ul class="list-group list-group-body" style="">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4 text-left" style=" ">
                                            <div class="row">
                                                <div class="col-1 col-sm-2 ">
                                                    <img class="rounded-circle" width="25" height="25" src="{{url('/storage/avatars/'. $assignment->user->profile_picture)}}" alt="Profilkép">
                                                </div>
                                                <div class="col-10 col-sm-10 ">
                                                    <p><a href="{{ route('profile.show', $assignment->user->id) }}">{{ $assignment->user->name }}</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center" ><p>{{ $assignment->role }}</p></div>
                                        @if(Auth::user()->right_id >=2)
                                            <div class="col-4 text-right" >
                                                <a href="{{ route('assignments.delete', $assignment->id) }}" onclick="return confirm('Biztos vagy benne?')"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                            @empty
                            <ul class="list-group list-group-body" style="">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-12 text-center" style=" "> <p>Nincsenek még a szólamok beosztva</p> </div>
                                    </div>
                                </li>
                            </ul>
                            @endforelse
                        @else
                        <ul class="list-group list-group-body" style="">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-12 text-center" style=" "> <p>Válassz ki egy darabot</p> </div>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
