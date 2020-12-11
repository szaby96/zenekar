@extends('layouts.app')

@section('content')

<div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-6 md-5 text-center text-sm-left">
                <h1>
                @if(Route::input('visibility_name') == 'public')
                    Publikus események
                @elseif(Route::input('visibility_name') == 'private')
                    Privát események
                @elseif(Route::input('visibility_name') == 'instrument')
                    {{Auth::user()->instrument->name}} szólam eseményei
                @else
                    Események
                @endif
                </h1>


            </div>
            @if(Auth::check() && Auth::user()->approved_at)
                <div class="col-sm-6 text-sm-right text-center">
                    <a href="{{ route('event.create') }}" class="btn btn-primary">Esemény létrehozéra</a>
                    <div class="dropdown mt-1">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Szűrés
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('events.index')}}">Összes esemény</a>
                            <a class="dropdown-item" href="{{route('events.index', 'public')}}">Publikus események</a>
                            <a class="dropdown-item" href="{{route('events.index', 'private')}}">Privát események</a>
                            @if(Auth::user()->instrument_id != NULL)
                            <a class="dropdown-item" href="{{route('events.index', 'instrument')}}">{{Auth::user()->instrument->name}} szólam eseményei</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <hr>

    @if(count($events) > 0)
        @foreach($events->sortByDesc('start')  as $event)
            <div class="row row-striped">
                <div class="col-sm-4 col-lg-3 col-xl-2 col-12 text-sm-right text-center">
                    <h1 class="display-4"><span class="badge badge-secondary">{{ date('d', strtotime($event->start))}}</span></h1>
                    <h2>{{ date('F', strtotime($event->start))}}</h2>
                </div>
                <div class="col-sm-8 col-lg-9 col-xl-10 col-12 text-center text-sm-left">
                    <a href="{{route('event.show', $event->id)}}">
                        <h3 class="text-uppercase"><strong>{{$event->title}}</strong></h3>
                    </a>
                    <ul class="list-unstyled">
                        <li class="list-item"><i class="fas fa-clock"></i> {{ date('Y.m.d H:i', strtotime($event->start))}} - {{date('Y.m.d H:i', strtotime($event->end))}}</li>
                        <li class="list-item"><i class="fas fa-location-arrow"></i> {{$event->location}}</li>
                        <li class="list-item"><i class="fas fa-users"></i>  {{$event->users->count()}} résztvevő</li>
                    </ul>
                </div>
            </div>
            <hr>
        @endforeach
        {{$events->links()}}
    @else
        <p>Nincsenek események</p>
    @endif


</div>

@endsection
