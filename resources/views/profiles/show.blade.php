@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-auto mb-3">
                            <div class="mx-auto" style="width: 160px;">
                                <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px;">
                                    <img src="{{url('/storage/avatars/'. $user->profile_picture)}}" alt="Avatar" style="height: 140px; width: auto">
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                            @if(Auth::check() && Auth::user()->id == $user->id)
                                <div class="text-center text-sm-left mb-2 mb-sm-0 mt-sm-3">
                                    <h1 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name}}</h1>
                                    <div class="mt-2">
                                        <a href="{{route('profiles.edit', $user->id )}}" class="btn btn-primary" role="button">
                                        <i class="fas fa-user-edit"></i>
                                        <span>Profil Szerkesztése</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-sm-left mb-2 mb-sm-0 mt-sm-5">
                                    <h1 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name}}</h1>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="tab-content ml-1" id="myTabContent">
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">E-mail</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    {{$user->email}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">Betöltött szerep</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    {{$user->right->name}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">Hangszer</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    @if(is_null($user->instrument_id))
                                        Nincs meghatározva
                                    @else
                                        {{ $user->instrument->name }}
                                    @endif
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">Regisztráció dátuma</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    {{$user->created_at}}
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

    @endsection
