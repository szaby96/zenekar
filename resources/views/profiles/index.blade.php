@extends('layouts.app')

@section('content')

<div class="container">
        <div class="card-group">
        @foreach ($instruments->sortBy('name') as $instrument)
            <div class="col-lg-4 col-md-6 mt-4">
                <div class="card mt-4 border-info h-100">
                    <div class="card-body ">
                        <h4 class="card-title">{{$instrument->name}}</h4>
                        <hr>
                        @foreach ($users->where('instrument_id', $instrument->id) as $user)
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-1 col-sm-2 ">
                                        <img class="rounded-circle" width="30" height="30" src="{{url('/storage/avatars/'. $user->profile_picture)}}" alt="Profilkép">
                                    </div>
                                    <div class="col-10 col-sm-10 ">
                                        <p><a href="{{ route('profile.show', $user->id) }}">{{$user->name}}</a></p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        </div>
</div>


@endsection
