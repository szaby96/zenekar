@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col mb-3">
        <div class="card">
            <div class="card-body">
            <div class="e-profile">
            {!! Form::open(['action' => ['ProfilesController@update', $user->id], 'method' => 'POST']) !!}
                <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                        <div class="mx-auto" style="width: 160px;">
                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px;">
                                <img src="{{url('/storage/avatars/'. $user->profile_picture)}}" alt="Avatar" style="height: 140px; width: auto">
                            </div>
                        </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                    <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h2 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name}}</h2>
                    <p class="mb-0">
                        @if(is_null($user->instrument_id))
                            Nincs hangszercsoport meghatározva
                        @else
                            {{ $user->instrument->name }}
                        @endif
                    </p>
                    <div class="mt-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload-modal">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Profilkép megváltoztatása</span>
                        </button>
                    </div>
                    </div>
                    <div class="text-center text-sm-right">
                    <span class="badge badge-secondary">{{$user->right->name}}</span>
                    <div class="text-muted"><small>Regisztrált: {{$user->created_at}}</small></div>
                    </div>
                </div>
                </div>

                <div class="tab-content pt-3">
                <div class="tab-pane active">
                    <div class="row">
                        <div class="col">
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                {{Form::label('name', 'Név')}}
                                {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholer' => 'Név'])}}
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                {{Form::label('email', 'E-mail')}}
                                {{Form::email('email', $user->email, ['class' => 'form-control', 'placeholer' => 'E-mail'])}}
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Jelszó megváltoztatása</b></div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Jelenlegi jelszó</label>
                                <input name="current_password" id="current_password" class="form-control" type="password" placeholder="••••••">
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Új jelszó</label>
                                <input id="new_password" name="new_password" class="form-control" type="password" placeholder="••••••">
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                            <div class="form-group">
                                <label>Jelszó <span class="d-none d-xl-inline">megerősítése</span></label>
                                <input  id="new_confirm_password" name="new_confirm_password" class="form-control" type="password" placeholder="••••••"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                        <div class="mb-2"><b>E-mail értesítések</b></div>
                        <div class="row">
                            <div class="col">
                            <div class="custom-controls-stacked px-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="publicEvents" name="publicEvents" value="1"
                                        @if($user->public_events_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="publicEvents">Nyilvános események</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="publicPosts" name="publicPosts" value="{{$user->public_posts_notifications}}"
                                    @if($user->public_posts_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="publicPosts">Nyilvános posztok</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="bandEvents" name="bandEvents" value="{{$user->band_events_notifications}}"
                                    @if($user->band_events_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="bandEvents">Zenekari események</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="bandPosts" name="bandPosts" value="{{$user->band_posts_notifications}}"
                                    @if($user->band_posts_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="bandPosts">Zenekari posztok</label>
                                </div>
                                @if(is_null($user->instrument_id))

                                @else
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="groupEvents" name="groupEvents" value="{{$user->group_events_notifications}}"
                                    @if($user->group_events_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="groupEvents">Szólam események</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="groupPosts" name="groupPosts" value="{{$user->group_posts_notifications}}"
                                    @if($user->group_posts_notifications == 1) checked @endif>
                                    <label class="custom-control-label" for="groupPosts">Szólam posztok</label>
                                </div>
                                @endif
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">

                            {{Form::submit('Mentés', ['class' => 'btn btn-primary'])}}
                        </div>
                    </div>

                </div>
                </div>
                @method('PUT')
                @csrf
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


<!-- upload photo modal -->
<div class="modal fade" id="upload-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fotó feltöltése</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['action' => 'ProfilesController@uploadPhoto', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {{Form::file('photo', ['accept' => 'image/*'])}}
                </div>
                <div class="form-group">
                    {{Form::hidden('id', $user->id)}}
                </div>
            </div>
            <div class="modal-footer">
                {{Form::submit('Feltölt', ['class' => 'btn btn-primary'])}}
                <button type="button" class="btn btn-danger" data-dismiss="modal">Mégse</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


@endsection
