@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 col-sm-8 col-12 md-5 text-center text-sm-left">
                <h1>
                @if(Route::input('visibility_name') == 'public')
                    Publikus posztok
                @elseif(Route::input('visibility_name') == 'private')
                    Privát posztok
                @elseif(Route::input('visibility_name') == 'instrument')
                    {{Auth::user()->instrument->name}} szólam posztok
                @else
                    Posztok
                @endif
                </h1>
            </div>
            @if(Auth::check() && Auth::user()->approved_at)
                <div class="col-md-6 col-sm-4 col-12 text-sm-right text-center">
                    <a href="{{ route('post.create') }}" class="btn btn-primary">Poszt létrehozéra</a>
                    <div class="dropdown mt-1">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Szűrés
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('posts.index')}}">Összes poszt</a>
                            <a class="dropdown-item" href="{{route('posts.index', 'public')}}">Publikus posztok</a>
                            <a class="dropdown-item" href="{{route('posts.index', 'private')}}">Privát posztok</a>
                            @if(Auth::user()->instrument_id != NULL)
                                <a class="dropdown-item" href="{{route('posts.index', 'instrument')}}">{{Auth::user()->instrument->name}} szólam posztjai</a>
                            @endif
                        </div>
                    </div>
                </div>

            @endif

        </div>

    @if(count($posts) > 0)
        @foreach($posts->sortByDesc('created_at')  as $post)
            <div class="card mt-4">
                <div class="card-header">
                    <a class="card-link" href="{{route('post.show', $post->id)}}">
                        <h1 class="card-title">{{$post->title}}</h1>
                    </a>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mt-3 text-muted h7">
                                <div class="row">
                                    <div class="col-2 ">
                                        <img class="rounded-circle" width="25" height="25" src="{{url('/storage/avatars/'. $post->user->profile_picture)}}" alt="Profilkép">
                                    </div>
                                    <div class="col-8 ">
                                        <p><a href="{{route('profile.show', $post->user->id)}}">{{$post->user->name}}</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-muted h7 float-right">
                             <i class="fas fa-clock"></i> {{$post->created_at->diffForHumans()}}
                             @if($post->created_at != $post->updated_at)
                             <div class="p m-0">Szerkesztve</div>
                         @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text px-2">
                        {{str_limit($post->body, '400')}}
                        @if(strlen(strip_tags($post->body)) > 400)
                        <br>
                        <a href="{{route('post.show', $post->id)}}" class="btn btn-primary btn-sm">Olvass tovább</a>

                        @endif
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{route('post.show', $post->id)}}" class="card-link"><i class="fas fa-comment"></i> Hozzászólások száma: {{$post->comments->count()}}</a>
                </div>
            </div>
        @endforeach
        <div class="mt-4">
            {{$posts->links()}}
        </div>
    @else
        <p>Nincsenek posztok</p>
    @endif
    </div>


@endsection


