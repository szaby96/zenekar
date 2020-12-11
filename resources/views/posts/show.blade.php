@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-between pr-1">
            <div class="col-md-6 col-6 mt-1">
                <a href="{{ route('posts.index', $post->visibility_name) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Vissza</a>
            </div>
            @if(Auth::check() && Auth::user()->id == $post->user->id)
            <div class="float-right pl-2 btn-toolbar mt-1" role="toolbar">
                <div class="btn-group pl-2 mr-2 pb-0" role="group">
                <a  href="{{route('post.edit', $post->id )}}" class="btn btn-primary">Módosít</a>
                </div>
                <div class="btn-group mr-2" role="group">
                    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' =>'POST', 'class' => 'pull-right'])!!}
                        @method('DELETE')
                    {!! Form::submit('Töröl', ['class' => 'btn btn-danger']) !!}
                    {!!Form::close() !!}
                </div>
            </div>
            @endif

        </div>

        <h1 class="mt-4">{{$post->title}}</h1>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6">
                <p class="lead">
                    írta
                    <a href="{{route('profile.show', $post->user->id)}}">{{$post->user->name}}</a>
                </p>
            </div>
            <div class="col-12 col-sm-6 text-sm-right">
                <p><i class="fas fa-clock"></i> {{$post->created_at->diffForHumans()}}
                    @if($post->created_at != $post->updated_at)
                        Szerkesztve
                    @endif
                </p>
            </div>
        </div>
        <hr>


        <p class="lead">
            {{$post->body}}
        </p>

        <hr>

        @if(Auth::check())
            <h3 class="pt-4">Hozzászólások:</h3>
            <hr>
            @include('posts/commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])

            <div class="card my-4">
                <h5 class="card-header">Hozzászólok:</h5>
                <div class="card-body">
                    <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <div class="form-group">
                            <textarea class="form-control" name="body"></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Hozzászólok" />
                        </div>
                </div>
            </div>
        @endif


@endsection


