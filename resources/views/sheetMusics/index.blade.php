@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->right->id >= 2)
            <div class="col-12 col-md-12 col-lg-4 order-lg-2 mb-4">
                <div class="card">
                    {!! Form::open(['action' => 'SheetMusicsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="card-header"><h3>Kotta feltöltése</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                {{Form::label('title', 'Cím')}}
                                {{Form::text('title', '', ['class' => 'form-control', 'placeholer' => 'Cím'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('composition', 'Darab')}}
                                {{Form::select('composition', $title, null, ['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('sheet_music', 'Kotta')}}
                                {{ Form::file('sheet_music', ['accept' => 'application/pdf']) }}
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            {{Form::submit('Feltöltés', ['class' => 'btn btn-primary'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        @endif
        <div class="col-12 col-md-12 col-lg-8 order-lg-1">
            <div class="card">
                <div class="card-header"><h3>Darabok</h3></div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <tr>
                                <th>Szerző</th>
                                <th>Cím</th>
                                <th class="text-center">Kották</th>
                            </tr>
                            @forelse ($compositions as $composition)
                                <tr>
                                    <td>{{ $composition->composer }}</td>
                                    <td>{{ $composition->title }}</td>
                                    <td class="text-center"><a href="{{route('sheetMusic.show', $composition->id)}}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-file"></i></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nem található darab.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
