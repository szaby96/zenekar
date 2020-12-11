@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-between pr-1">
            <div class="col-md-6 col-6 mt-1">
                <a href="{{ route('events.index', $event->visibility_name) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Vissza</a>
        </div>
        @if(Auth::check() && (Auth::user()->id == $event->created_user_id || Auth::user()->right_id == 3))
            <div class="float-right pl-2 btn-toolbar mt-1" role="toolbar">
                <div class="btn-group pl-2 mr-2 pb-0" role="group">
                    <a  href="{{route('event.edit', $event->id )}}" class="btn btn-primary">Módosít</a>
                </div>
                <div class="btn-group mr-2" role="group">
                    {!!Form::open(['action' => ['EventsController@destroy', $event->id], 'method' =>'POST', 'class' => 'pull-right'])!!}
                        @method('DELETE')
                    {!! Form::submit('Töröl', ['class' => 'btn btn-danger']) !!}
                    {!!Form::close() !!}
                </div>
            </div>

        @endif
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <div class="row row-striped">
                    <div class="col-sm-4 col-lg-3 col-xl-2 col-12 text-sm-right text-center">
                        <h1 class="display-4"><span class="badge badge-secondary">{{ date('d', strtotime($event->start))}}</span></h1>
                        <h3>{{ date('F', strtotime($event->start))}}</h3>
                    </div>
                    <div class="col-sm-5 col-lg-7 col-xl-8 col-12 text-center text-sm-left">
                        <a href="{{route('event.show', $event->id)}}">
                            <h1 class="text-uppercase"><strong>{{$event->title}}</strong></h1>
                        </a>
                        <ul class="list-unstyled">
                            <li class="list-item"><i class="fas fa-clock"></i> {{ date('Y.m.d H:i', strtotime($event->start))}} - {{date('Y.m.d H:i', strtotime($event->end))}}</li>
                            <li class="list-item"><i class="fas fa-location-arrow"></i> {{$event->location}}</li>
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if($event->users->contains(Auth::user()))
                            <div class="col-sm-3 col-lg-2 col-xl-2 col-12 text-center text-sm-right">
                                <a  href="{{route('event.detachUser', $event->id )}}" class="btn btn-primary">Nem érdekel</a>
                            </div>
                        @else
                            <div class="col-sm-3 col-lg-2 col-xl-2 col-12 text-center text-sm-right">
                                <a  href="{{route('event.attachUser', $event->id )}}" class="btn btn-primary">Ott leszek</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="mx-sm-4 mx-xl-5">
                        <p>{{$event->description}}</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="mx-sm-4 mx-xl-5">
                    <h4>Résztvevők</h4>
                    <hr>
                    <div class="row mx-1">
                        @forelse($event->users as $participant)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="row">
                                    <div class="col-1 col-sm-2 ">
                                        <img class="rounded-circle" width="25" height="25" src="{{url('/storage/avatars/'. $participant->profile_picture)}}" alt="Profilkép">
                                    </div>
                                    <div class="col-10 col-sm-10 ">
                                        <p><a href="{{route('profile.show', $participant->id)}}">{{$participant->name}}</a></p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h5>Nincsenek résztvevők</h5>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
